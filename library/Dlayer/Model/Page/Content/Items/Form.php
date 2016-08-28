<?php
/**
* Import form tool
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Model_Page_Content_Items_Form extends Zend_Db_Table_Abstract
{
	/**
	 * Fetch a list of forms to be imported
	 *
	 * @since 0.99
	 * @param integer $site_id
	 * @return array Simple array, indexed by id
	 */
	public function forms($site_id)
	{
		$sql = "SELECT id, `name` 
				FROM user_site_form 
				WHERE site_id = :site_id 
				ORDER BY `name` ASC";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->execute();

		$forms = array();

		foreach($stmt->fetchAll() as $form)
		{
			$forms[$form['id']] = $form['name'];
		}

		return $forms;
	}

	/**
	 * Check to see if the given form id is valid for the site
	 *
	 * @since 0.99
	 * @param integer $site_id
	 * @param integer $id
	 * @return boolean
	 */
	public function valid($site_id, $id)
	{
		$sql = "SELECT id 
				FROM user_site_form
				WHERE site_id = :site_id 
				AND id = :form_id 
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result !== FALSE)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Add a new form item
	 *
	 * @since 0.99
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $content_id
	 * @param array $params The params data array from the tool
	 * @return boolean
	 */
	public function add($site_id, $page_id, $content_id, array $params)
	{
		$sql = "INSERT INTO user_site_page_content_item_form 
				(site_id, page_id, content_id, form_id) 
				VALUES 
				(:site_id, :page_id, :content_id, :form_id)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $params['form_id'], PDO::PARAM_INT);
		$result = $stmt->execute();

		return $result;
	}








	/**
	* Import a new form as a content item
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @param integer $content_id
	* @param array $params The data for the heading content item
	* @return void
	*/
	public function addContentItemData($site_id, $page_id, $div_id, 
		$content_row_id, $content_id, array $params)
	{
		$sql = 'INSERT INTO user_site_page_content_item_form 
				(site_id, page_id, content_id, form_id) 
				VALUES 
				(:site_id, :page_id, :content_id, :form_id)';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $params['form_id'], PDO::PARAM_INT);
		$stmt->execute();
	}
	
	/**
	* Edit the details for the selected imported form
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @param integer $content_id
	* @param array $params The data for the new content item
	* @return void
	*/
	public function editContentItemData($site_id, $page_id, $div_id, 
		$content_row_id, $content_id, array $params)
	{
		$sql = "UPDATE user_site_page_content_item_form 
				SET form_id = :form_id 
				WHERE site_id = :site_id
				AND page_id = :page_id
				AND content_id = :content_id 
				LIMIT 1";

		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':form_id', $params['form_id'], PDO::PARAM_INT);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();
	}
	
	/**
	* Fetch the existing data for the content item being edited, in this 
	* case just for form id
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @param integer $content_id
	* @return array|FALSE Returns either the data array or FALSE if no data 
	* 	can be found
	*/
	public function formData($site_id, $page_id, $div_id, $content_row_id, 
		$content_id)
	{
		$sql = "SELECT uspci.id, uspcif.form_id  
				FROM user_site_page_content_item_form uspcif 
				JOIN user_site_page_content_item uspci 
					ON uspcif.content_id = uspci.id 
					AND uspci.id = :content_id 
					AND uspci.site_id = :site_id 
					AND uspci.page_id = :page_id 
					AND uspci.content_row_id = :content_row_id 
				JOIN user_site_page_content_rows uspcr 
					ON uspci.content_row_id = uspcr.id 
					AND uspcr.site_id = :site_id 
					AND uspcr.page_id = :page_id 
					AND uspcr.div_id = :div_id 
				WHERE uspcif.site_id = :site_id 
				AND uspcif.page_id = :page_id 
				AND uspcif.content_id = :content_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch();
	}
	
	/**
	* Fetch the of the form currently selected in the Form builder by the 
	* content id
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id
	* @return integer|FALSE Return either the form id or FALSE if we have 
	* 	been unable to select a form
	*/
	public function formId($site_id, $page_id, $content_id) 
	{
		$sql = "SELECT form_id 
				FROM user_site_page_content_item_form 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND content_id = :content_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			return intval($result['form_id']);
		} else {
			return FALSE;
		}
	}
}
