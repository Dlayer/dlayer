<?php
/**
* Page model
*
* In the content module the user creates pages by adding content blocks, a page
* begins as a reference to a template
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
* @category Model
*/
class Dlayer_Model_ContentPage extends Zend_Db_Table_Abstract
{
	/**
	* Check to see if the given page id is valid. It needs to exist in the
	* database and belong to the requested site.
	*
	* Currently there is no status indicator, this will be added later when I
	* have fleshed out the modules and got the interlinking working
	*
	* @param integer $page_id
	* @param integer $site_id
	* @return boolean TRUE if the page id is valid
	*/
	public function valid($page_id, $site_id)
	{
		$sql = "SELECT id
				FROM user_site_page
				WHERE site_id = :site_id
				AND id = :page_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->execute();

		if($stmt->fetch() != FALSE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	* Check to see if the content id is valid, needs to be a child of all the
	* supplied params and also be the correct content type
	* 
	* @param integer $site_id
	* @param integer $page_id 
	* @param integer $div_id
	* @param integer $content_row_id
	* @param integer $content_id
	* @param string $content_type
	* @return boolean Returns TRUE if the content id is valid, FALSE otherwise
	*/
	public function contentIdValid($site_id, $page_id, $div_id, 
		$content_row_id, $content_id, $content_type)
	{
		$sql = "SELECT uspci.id 
				FROM user_site_page_content_item uspci 
				JOIN user_site_page_content_rows uscr ON 
					uspci.content_row_id = uscr.id 
					AND uscr.site_id = :site_id 
					AND uscr.page_id = :page_id 
					AND uscr.div_id = :div_id 
					AND uscr.id = :content_row_id 
				JOIN designer_content_type dct ON uspci.content_type = dct.id  
					AND dct.name = :content_type 
				WHERE uspci.site_id = :site_id 
				AND uspci.page_id = :page_id 
				AND uspci.id = :content_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_type', $content_type, PDO::PARAM_STR);
		$stmt->execute();

		if($stmt->fetch() != FALSE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	* Fetch all the pages that have been defined for the requested site.
	*
	* Initially a user will have 2 sample sites which will contain sample
	* pages, when a new site is created from scracth there will be no pages,
	* it is therefore entirely possible that there will be no pages for the
	* requested site
	*
	* @param integer $site_id
	* @return array Array of the pages for the site, includes the name of the
	*               template to create the page
	*/
	
	/**
	 * Fetch all the pages that have been added to the requested site
	 *
	 * The method should only be called after the validateSiteId(); action helper, the helper checks that the
	 * site id exists and belongs to the currently logged in user
	 *
	 * @param integer $site_id
	 * @return array If there are no pages and empty array is returned
	 */
	public function pages($site_id)
	{
		$sql = "SELECT usp.id, usp.`name` 
				FROM user_site_page usp 
				WHERE usp.site_id = :site_id 
				ORDER BY usp.`name` ASC";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll();
	}

	/**
	 * Fetch the data for the selected content page, array contains the combined data for user_site_page table and
	 * user_site_page_meta table
	 *
	 * @param $page_id
	 * @return array|FALSE
	 */
	public function page($page_id)
	{
		$sql = 'SELECT usp.`name`, uspm.title, uspm.description 
 				FROM user_site_page usp 
 				JOIN user_site_page_meta uspm ON uspm.page_id = usp.id
 				WHERE uspm.id = :page_id';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch();
	}

	/**
	 * Check to see if the given page name if unique for the site, optionally a page id can be defined which will be
	 * excluded from the check
	 *
	 * @param $name Name to check
	 * @param $site_id Site id to check against
	 * @param null $page_id Page id to exclude from the check
	 * @return boolean TRUE if the name is unique
	 */
	public function nameUnique($name, $site_id, $page_id=NULL)
	{
		$where = NULL;

		if($page_id != NULL) {
			$where = 'AND id != :page_id ';
		}

		$sql = "SELECT id
				FROM user_site_page
				WHERE UPPER(`name`) = :name
				AND site_id = :site_id ";
		$sql .= $where;
		$sql .= "LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':name', strtoupper($name), PDO::PARAM_STR);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		if($page_id != NULL) {
			$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		}
		$stmt->execute();

		$result = $stmt->fetch();

		if($result == FALSE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Save the content page, either inserts a new record or updates the given record
	 *
	 * @param integer $site_id
	 * @param string $name Name of page within Dlayer
	 * @param string $title Page title
	 * @param string $description Page description
	 * @param integer|NULL $id Page id for edit
	 * @return integer|FALSE Either the page id or FALSE upon failure
	 */
	public function savePage($site_id, $name, $title, $description, $id=NULL)
	{
		if($id === NULL)
		{
			$id = $this->addPage($site_id, $name);

			if($id !== FALSE)
			{
				$this->savePageMeta($id, $title, $description);
			}
			else
			{
				$id = FALSE;
			}
		}
		else
		{
			if($this->editPage($id, $name) !== false)
			{
				$this->savePageMeta($id, $title, $description);
			}
			else
			{
				$id = false;
			}
		}

		return $id;
	}

	/**
	 * Save the page meta data, either inserts a new record or updates the details for the record matching the given
	 * Page Id
	 *
	 * @param integer $page_id
	 * @param string $title Page title
	 * @param string $description Page description
	 * @return void
	 */
	private function savePageMeta($page_id, $title, $description)
	{
		$id = $this->pageMetaExists($page_id);

		if($id === FALSE)
		{
			$this->addPageMeta($page_id, $title, $description);
		}
		else
		{
			$this->editPageMeta($id, $title, $description);
		}
	}

	/**
	 * Insert a new page record
	 *
	 * @param $site_id Site the page belongs to
	 * @param $name Name of the page within Dlayer
	 * @return integer|FALSE Either the id of the new page or FALSE upon failure
	 */
	private function addPage($site_id, $name)
	{
		$sql = "INSERT INTO user_site_page 
				(site_id, `name`) 
				VALUES
				(:site_id, :name)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$result = $stmt->execute();

		if($result === TRUE)
		{
			return intval($this->_db->lastInsertId('user_site_page'));
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Edit the details for a page
	 *
	 * @param integer $id
	 * @param string $name
	 * @return boolean
	 */
	private function editPage($id, $name)
	{
		$sql = 'UPDATE user_site_page 
				SET `name` = :name  
				WHERE id = :id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		return $stmt->execute();
	}

	/**
	 * Add the meta data for a content page
	 *
	 * @param integer $page_id
	 * @param string $title
	 * @param string $description
	 * @return boolean
	 */
	private function addPageMeta($page_id, $title, $description)
	{
		$sql = "INSERT INTO user_site_page_meta  
				(page_id, title, description) 
				VALUES
				(:page_id, :title, :description)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':title', $title, PDO::PARAM_STR);
		$stmt->bindValue(':description', $description, PDO::PARAM_STR);
		return $stmt->execute();
	}

	/**
	 * Edit the meta entry for a page
	 *
	 * @param integer $id
	 * @param string $title
	 * @param string $description
	 * @return boolean
	 */
	private function editPageMeta($id, $title, $description)
	{
		$sql = 'UPDATE user_site_page_meta 
				SET title = :title, description = :description 
				WHERE id = :id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':title', $title, PDO::PARAM_STR);
		$stmt->bindValue(':description', $description, PDO::PARAM_STR);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		return $stmt->execute();
	}

	/**
	 * Check to see if a meta entry exists for the current page
	 *
	 * @param integer $page_id
	 * @return integer|FALSE Either the id of the row in the meta table or FALSE if no entry
	 */
	private function pageMetaExists($page_id)
	{
		$sql = 'SELECT id 
				FROM user_site_page_meta 
				WHERE page_id = :page_id';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result !== FALSE)
		{
			return $result['id'];
		}
		else
		{
			return FALSE;
		}
	}

	/**
	* Fetch the content areas that have been defined for the supplied content 
	* page ignoring the currently selected div id, only returns the ids of the 
	* last content areas, these are the only ones content can be added to
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $selected_div_id
	* @return array Returns an array containing all the other content areas 
	* 	that make up the content page
	*/
	public function useablePageContentAreas($site_id, $page_id, 
		$selected_div_id) 
	{
		$sql = 'SELECT ustd.id, ustd.parent_id, ustd.sort_order
				FROM user_site_page usp 
				JOIN user_site_template_div ustd 
					ON usp.template_id = ustd.template_id  
					AND ustd.site_id = :site_id 
				WHERE usp.id = :page_id 
				AND usp.site_id = :site_id
				ORDER BY ustd.parent_id, ustd.sort_order';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetchAll();
		
		$count_children = array();
		
		// Calculate the number of children for each div id
		foreach($result as $area) {
			if(array_key_exists($area['parent_id'], $count_children) == TRUE) {
				$count_children[$area['parent_id']]['children']++;
			}
			
			$count_children[$area['id']] = 
				array(
					'id'=>$area['id'],
					'children'=>0
				);
		}
		
		$areas = array();
		
		// Return only the ids with no children
		foreach($count_children as $area) {
			if($area['children'] == 0 && $area['id'] != $selected_div_id) {
				$areas[intval($area['id'])] = $area['id'];
			}		
		}
		
		return $areas;
	}
}
