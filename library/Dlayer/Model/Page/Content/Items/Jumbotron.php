<?php
/**
* Content jumbotron item data model, all the methods required to manage a 
* Jumbotron data item
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Model_Page_Content_Items_Jumbotron 
extends Dlayer_Model_Page_Content_Item
{
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
		$sql = "SELECT uspci.id, uscj.`name`, uscj.content AS title
				FROM user_site_page_content_item_jumbotron uspcij 
				JOIN user_site_page_content_item uspci 
					ON uspcij.content_id = uspci.id 
					AND uspci.site_id = :site_id 
					AND uspci.page_id = :page_id 
					AND uspci.row_id = :content_row_id 
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
				(site_id, page_id, content_id, data_id)
				VALUES
				(:site_id, :page_id, :content_id, :data_id)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':data_id', $data_id, PDO::PARAM_INT);
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
				SET data_id = :data_id 
				WHERE site_id = :site_id
				AND page_id = :page_id
				AND content_id = :content_id
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':data_id', $data_id, PDO::PARAM_INT);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
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
}