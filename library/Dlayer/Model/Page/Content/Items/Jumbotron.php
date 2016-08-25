<?php
/**
* Content jumbotron item data model, all the methods required to manage a 
* Jumbotron data item
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Model_Page_Content_Items_Jumbotron extends Zend_Db_Table_Abstract
{
	/**
	 * Fetch the existing data for the content item
	 *
	 * @since 0.99
	 * @param integer $site_id
	 * @param integer $id
	 * @return array|FALSE The data array for the content item or FALSE upon failure
	 */
	public function existingData($site_id, $id)
	{
		$sql = "SELECT uscj.`name`, uscj.`content`, uspcij.button_label
				FROM user_site_page_content_item_jumbotron uspcij 
				JOIN user_site_content_jumbotron uscj 
					ON uspcij.data_id = uscj.id 
					AND uscj.site_id = :site_id 
				WHERE uspcij.site_id = :site_id  
				AND uspcij.content_id = :content_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch();
	}

	/**
	 * Check to see how many instances there are of the content item data within the site
	 *
	 * @since 0.99
	 * @param integer $site_id
	 * @param integer $content_id
	 * @return integer Number of instances
	 */
	public function instancesOfData($site_id, $content_id)
	{
		$sql = "SELECT COUNT(content.id) AS instances
				FROM user_site_page_content_item_jumbotron content
				WHERE content.data_id = (
					SELECT uspcij.data_id 
					FROM user_site_page_content_item_jumbotron uspcij 
					WHERE uspcij.site_id = :site_id  
					AND uspcij.content_id = :content_id 
					LIMIT 1
				)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result !== FALSE)
		{
			return intval($result['instances']);
		}
		else
		{
			return 0;
		}
	}

	/**
	 * Add a new jumbotron content item
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
		$result = false;

		if(strlen($params['intro']) > 0)
		{
			$content = $params['title'] . Dlayer_Config::CONTENT_DELIMITER . $params['intro'];
		}
		else
		{
			$content = $params['title'];
		}

		$data_id = $this->existingDataId($site_id, $content);

		if($data_id === FALSE)
		{
			$data_id = $this->addData($site_id, $params['name'], $content);
		}

		if($data_id !== FALSE)
		{
			$sql = "INSERT INTO user_site_page_content_item_jumbotron 
                    (site_id, page_id, content_id, data_id, button_label) 
                    VALUES 
                    (:site_id, :page_id, :content_id, :data_id, :button_label)";
			$stmt = $this->_db->prepare($sql);
			$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
			$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
			$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
			$stmt->bindValue(':data_id', $data_id, PDO::PARAM_INT);
			$stmt->bindValue(':button_label', $params['button_label'], PDO::PARAM_STR);
			$result = $stmt->execute();
		}

		return $result;
	}

	/**
	 * Check to see if the content exists in the data tables, if so we re-use the data from a previous content item
	 *
	 * @since 0.99
	 * @param integer $site_id
	 * @param string $content
	 * @param integer|NULL $ignore_id
	 * @return integer|FALSE Id of the existing data array or FALSE if a new content item
	 */
	private function existingDataId($site_id, $content, $ignore_id = NULL)
	{
		$sql = "SELECT id 
                FROM user_site_content_jumbotron 
                WHERE site_id = :site_id  
				AND UPPER(content) = :content";
		if($ignore_id !== NULL)
		{
			$sql .= " AND id != :ignore_id LIMIT 1";
		}
		else
		{
			$sql .= " LIMIT 1";
		}
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':content', strtoupper($content), PDO::PARAM_STMT);
		if($ignore_id !== NULL)
		{
			$stmt->bindValue(':ignore_id', $ignore_id, PDO::PARAM_INT);
		}
		$stmt->execute();

		$result = $stmt->fetch();

		if($result !== FALSE)
		{
			return intval($result['id']);
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Add the new content item data into the content table for text items
	 *
	 * @since 0.99
	 * @param integer $site_id
	 * @param string $name
	 * @param string $content
	 * @return integer|FALSE The id for the new data or FALSE upon failure
	 */
	private function addData($site_id, $name, $content)
	{
		$sql = "INSERT INTO user_site_content_jumbotron 
				(site_id, `name`, content) 
				VALUES 
				(:site_id, :name, :content)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':content', $content, PDO::PARAM_STR);
		$result = $stmt->execute();

		if($result === TRUE)
		{
			return intval($this->_db->lastInsertId('user_site_content_jumbotron'));
		}
		else
		{
			return FALSE;
		}
	}












	/**
	* Fetch the data for the content item being edited
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
		$sql = "SELECT uspci.id, uscj.`name`, uscj.content AS title, 
				uspcij.button_label 
				FROM user_site_page_content_item_jumbotron uspcij 
				JOIN user_site_page_content_item uspci 
					ON uspcij.content_id = uspci.id 
					AND uspci.site_id = :site_id 
					AND uspci.page_id = :page_id 
					AND uspci.content_row_id = :content_row_id 
					AND uspci.id = :content_id 
				JOIN user_site_content_jumbotron uscj 
					ON uspcij.data_id = uscj.id 
					AND uscj.site_id = :site_id 
				WHERE uspcij.site_id = :site_id 
				AND uspcij.page_id = :page_id
				AND uspcij.content_id = :content_id";
		$stmt = $this->_db->prepare($sql);		
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			$result['instances'] = $this->contentDataInstances(
				$site_id, $content_id);
				
			$exploded = explode('-:-', $result['title']);
			
			$result['title'] = $exploded[0];
			$result['sub_title'] = $exploded[1];
			
			return $result;
		} else {
			return FALSE;
		}
	}
	
	/**
	* Calculate the number of instances of the text content item text within 
	* the entire site
	* 
	* @param integer $site_id
	* @param integer $content_id 
	* @return integer Returns the count of the number of times the text has 
	* 	been used within the site
	*/
	private function contentDataInstances($site_id, $content_id) 
	{
		$sql = "SELECT COUNT(uspctj.id) AS instances 
				FROM user_site_page_content_item_jumbotron uspctj 
				WHERE uspctj.site_id = :site_id 
				AND uspctj.data_id = (SELECT ref_data.data_id 
				FROM user_site_page_content_item_jumbotron ref_data 
				WHERE ref_data.content_id = :content_id 
				AND ref_data.site_id = :site_id)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			return intval($result['instances']);
		} else {
			return 0;
		}
	}
	
	/**
	* Add a new jumbotron content item
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @param integer $content_id
	* @param array $params The data for the jumbotron content item
	* @return void
	*/
	public function addContentItemData($site_id, $page_id, $div_id, 
		$content_row_id, $content_id, array $params)
	{
		$data_id = $this->contentDataExists($site_id, $params['title'], 
			$params['sub_title']);
		
		if($data_id == FALSE) {
			$data_id = $this->addToDataTable($site_id, $params['name'], 
			$params['title'], $params['sub_title']);
		}
		
		$sql = "INSERT INTO user_site_page_content_item_jumbotron 
				(site_id, page_id, content_id, data_id, button_label)
				VALUES
				(:site_id, :page_id, :content_id, :data_id, :button_label)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':data_id', $data_id, PDO::PARAM_INT);
		$stmt->bindValue(':button_label', $params['button_label'], 
			PDO::PARAM_STR);
		$stmt->execute();
	}
	
	/**
	* Check to see if the jumbotron content exists in the jumbotron data 
	* table, if it does we can use the id for the previously stored value
	* 
	* @param integer $site_id
	* @param string $title The main title
	* @param string $sub_title The sub title content
	* @return integer|FALSE Either return the id for the existing jumbotron 
	* 	content string or FALSE if the test is a new string
	*/
	private function contentDataExists($site_id, $title, $sub_title) 
	{
		$content = trim(strtoupper($title)) . '-:-' . 
			trim(strtoupper($sub_title));
		
		$sql = "SELECT uscj.id 
				FROM user_site_content_jumbotron uscj 
				WHERE uscj.site_id = :site_id 
				AND UPPER(uscj.content) = :content 
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':content', $content, PDO::PARAM_STR);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			return intval($result['id']);
		} else {
			return FALSE;
		}
	}
	
	/** 
	* Add the content into the content data table and return the id for the 
	* newly stored string
	* 
	* @param integer $site_id
	* @param string $name 
	* @param string $title
	* @param string $sub_title
	* @return integer Id of the text in the content data table
	*/
	private function addToDataTable($site_id, $name, $title, $sub_title) 
	{
		$content = trim($title) . '-:-' . trim($sub_title);
		
		$sql = "INSERT INTO user_site_content_jumbotron 
				(site_id, `name`, content) 
				VALUES 
				(:site_id, :name, :content)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':content', $content, PDO::PARAM_STR);
		$stmt->execute();
		
		return $this->_db->lastInsertId('user_site_content_jumbotron');
	}
	
	/**
	* Edit the data for the selected jumbotron content item
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
		if($params['instances'] == FALSE) {
			$data_id = $this->contentDataExists($site_id, $params['title'], 
				$params['sub_title']);
			
			if($data_id == FALSE) {
				$data_id = $this->addToDataTable($site_id, $params['name'], 
					$params['title'], $params['sub_title']);
			} else {				
				$data_id = $this->updateContentData($site_id, $page_id, 
					$content_id, $params['name'], $params['title'], 
					$params['sub_title']);
			}
		} else {
			$data_id = $this->updateContentData($site_id, $page_id, 
				$content_id, $params['name'], $params['title'], 
				$params['sub_title']);
		}
		
		$sql = "UPDATE user_site_page_content_item_jumbotron 
				SET data_id = :data_id, 
				button_label = :button_label 
				WHERE site_id = :site_id
				AND page_id = :page_id
				AND content_id = :content_id
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':data_id', $data_id, PDO::PARAM_INT);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':button_label', $params['button_label'], 
			PDO::PARAM_STR);
		$stmt->execute();
	}
	
	/**
	* Update the content data text for the given data id
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id
	* @param string $name
	* @param string $title
	* @param string $sub_title
	* @return integer Id for the updated content
	*/
	private function updateContentData($site_id, $page_id, $content_id, 
	$name, $title, $sub_title) 
	{
		$content = trim($title) . '-:-' . trim($sub_title);
		
		$sql = "UPDATE user_site_content_jumbotron 
				SET `name` = :name, content = :content 
				WHERE site_id = :site_id 
				AND id = (SELECT uspcij.data_id 
				FROM user_site_page_content_item_jumbotron uspcij 
				WHERE uspcij.content_id = :content_id 
				AND uspcij.site_id = :site_id 
				AND uspcij.page_id = :page_id 
				LIMIT 1)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':content', $content, PDO::PARAM_LOB);
		$stmt->execute();
		
		return $this->contentDataExists($site_id, $title, $sub_title);
	}
	
	/**
	* Fetch all the defined names and ids for the jumbotron data stored in the 
	* database, used by the import jumbotron tool
	* 
	* @param integer $site_id
	* @return array
	*/
	public function existingJumbotronContentNames($site_id)
	{
		$sql = "SELECT id, `name` 
				FROM user_site_content_jumbotron 
				WHERE site_id = :site_id
				ORDER BY `name` ASC";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetchAll();
	}
	
	/**
	* Fetch the existsing jumbotron content that matches the supplied id
	* 
	* @param integer $site_id
	* @param integer $id
	* @return array|FALSE Either returns the data array for the jumbotron 
	* 	content or FALSE if an invalid id was supplied
	*/
	public function existingJumbotronContent($site_id, $data_id) 
	{
		$sql = "SELECT `name`, content 
				FROM user_site_content_jumbotron 
				WHERE site_id = :site_id 
				AND id = :data_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':data_id', $data_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		$exploded = explode('-:-', $result['content']);
			
		switch(count($exploded)) {
			case 1:
				$result['title'] = $exploded[0];
				$result['sub_title'] = '';
				break;
				
			case 2:
				$result['title'] = $exploded[0];
				$result['sub_title'] = $exploded[1];
				break;
			
			default:
				$result['title'] = '';
				$result['sub_title'] = '';
				break;
		}
			
		return $result;
	}
	
	/** 
	* Fetch the data required by the live editing preview functions, in this 
	* case the current title and sub title values
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id
	* @return array|FALSE Eithers returns the required data array or FALSE if 
	* 	the data cannot be found
	*/
	public function previewData($site_id, $page_id, $content_id) 
	{
		$sql = 'SELECT uspcij.content_id, uscj.content 
				FROM user_site_page_content_item_jumbotron uspcij 
				JOIN user_site_content_jumbotron uscj 
					ON uspcij.data_id = uscj.id 
					AND uscj.site_id = :site_id 
				WHERE uspcij.site_id = :site_id 
				AND uspcij.page_id = :page_id 
				AND uspcij.content_id = :content_id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			$content = $this->splitContent($result['content']);
			
			$result['title'] = $content['title'];
			$result['sub_title'] = $content['sub_title'];
		}
		
		return $result;
	}
	
	/**
	* Split the content field into title and sub title
	* 
	* @param string $content
	* @return array
	*/
	private function splitContent($content) 
	{
		$exploded = explode('-:-', $content);
		
		$result = array();
			
		switch(count($exploded)) {
			case 1:
				$result['title'] = $exploded[0];
				$result['sub_title'] = '';
				break;
				
			case 2:
				$result['title'] = $exploded[0];
				$result['sub_title'] = $exploded[1];
				break;
			
			default:
				$result['title'] = '';
				$result['sub_title'] = '';
			break;
		}
		
		return $result;
	}
}
