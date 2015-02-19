<?php
/**
* Page model
*
* In the content module the user creates pages by adding content blocks, a page
* begins as a reference to a template
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @category Model
*/
class Dlayer_Model_Page extends Zend_Db_Table_Abstract
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
	* Check to see if the given div id belongs to the requested page. To do
	* this we check to see if the div id exists for the template the page is
	* based upon
	*
	* No need to check the site id in this method ebacuse it will have already
	* been check by the valid() method
	*
	* @param integer $div_id
	* @param integer $page_id
	* @return boolean TRUE if the div id is valid
	*/
	public function divValid($div_id, $page_id)
	{
		$sql = "SELECT ustd.id
				FROM user_site_template_div ustd
				WHERE ustd.template_id = (SELECT template_id
				FROM user_site_page WHERE id = :page_id)
				AND ustd.id = :div_id
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
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
				JOIN user_site_page_content_rows uscr ON uspci.row_id = uscr.id 
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
	public function pages($site_id)
	{
		$sql = "SELECT usp.id, usp.`name`, ust.`name` AS template
		FROM user_site_page usp
		JOIN user_site_template ust ON usp.template_id = ust.id
		WHERE usp.site_id = :site_id
		ORDER BY usp.`name` ASC";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll();
	}

	/**
	* Fetch the data array for the requested page, able to pull the data by
	* page id because the site id will have already been validated.
	*
	* @param integer $page_id
	* @return array|FALSE
	*/
	public function page($page_id)
	{
		$sql = "SELECT template_id, `name`, title, description
				FROM user_site_page
				WHERE id = :page_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch();
	}

	/**
	* Check to see if the supplied page name is unique
	*
	* @param string $name
	* @param integer $site_id Site id to limit results by
	* @param integer|NULL $page_id If in edit mode we need to supply the id of
	*                              the current template so that the row can be
	*                               excluded from the query
	* @return boolean TRUE if the tested form name is unique
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
	* Add a new page to the requested site
	*
	* @param integer $site_id
	* @param string $name Name for the new page
	* @param integer $template Template id
	* @param string $title Title for page
	* @param string $description Description of page
	* @return integer New page id
	*/
	public function addPage($site_id, $name, $template, $title, $description)
	{
		$sql = "INSERT INTO user_site_page
				(site_id, template_id, `name`, title, description)
				VALUES
				(:site_id, :template_id, :name, :title, :description)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':template_id', $template, PDO::PARAM_INT);
		$stmt->bindValue(':title', $title, PDO::PARAM_STR);
		$stmt->bindValue(':description', $description, PDO::PARAM_STR);
		$stmt->execute();

		return $this->_db->lastInsertId('user_site_page');
	}

	/**
	* Edit the details for the selected site page
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param string $name
	* @param string $title
	* @param string $description
	* @return void
	*/
	public function editPage($site_id, $page_id, $name, $title, $description)
	{
		$sql = "UPDATE user_site_page
				SET `name` = :name,
				title = :title,
				description = :description
				WHERE site_id = :site_id
				AND id = :page_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':title', $title, PDO::PARAM_STR);
		$stmt->bindValue(':description', $description, PDO::PARAM_STR);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->execute();
	}

	/**
	* Check to see if a page has been created from the requested template
	*
	* @param integer $template_id
	* @param integer $site_id
	* @return boolean TRUE if a page has been created using the template
	*/
	public function pageCreatedUsingTemplate($template_id, $site_id)
	{
		$sql = "SELECT id
				FROM user_site_page
				WHERE site_id = :site_id
				AND template_id = :template_id
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result == FALSE) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	/**
	* Check to see if the specific template div id has content items defined 
	* on any pages
	*
	* @param integer $div_id Template div id
	* @param integer $site_id
	* @param integer $template_id
	* @return boolean TRUE if the template div has content has content assigned
	* 				  to it on at least one page
	*/
	public function templateDivHasContent($div_id, $site_id, $template_id)
	{
		$sql = "SELECT uspci.id 
				FROM user_site_page_content_item uspci 
				JOIN user_site_page_content_rows uspcr 
					ON uspci.row_id = uspcr.id 
					AND uspcr.site_id = :site_id 
					AND uspcr.div_id = :div_id 
				WHERE uspci.site_id = :site_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetchAll();

		if(count($result) == 0) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	/**
	* Fetch the content ids and content types for the requested page template
	* div
	*
	* @param integer $div_id
	* @param integer $site_id
	* @param integer $template_id
	* @return array Result array includes the content type and content id
	*/
	public function templateDivContent($div_id, $site_id, $template_id)
	{
		$sql = "SELECT uspc.id, dct.`name` AS `type`
				FROM user_site_page_content uspc
				JOIN user_site_page usp ON uspc.page_id = usp.id
				AND usp.site_id = :site_id
				AND usp.template_id = :template_id
				JOIN designer_content_type dct ON uspc.content_type = dct.id
				WHERE uspc.site_id = :site_id
				AND uspc.div_id = :div_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll();
	}
}