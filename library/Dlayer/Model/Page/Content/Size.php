<?php
/**
* Sizing model for content items
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Model_Page_Content_Size extends Zend_Db_Table_Abstract
{
	/**
	* Fetch the currently set size for the content item
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id
	* @return integer|FALSE Either return the size of the content item as a 
	* 	value between 1 and 12 or FALSE if there is no data	
	*/
	public function size($site_id, $page_id, $content_id) 
	{
		$sql = 'SELECT size 
				FROM user_site_page_content_item_size 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND content_id = :content_id';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			return intval($result['size']);
		} else {
			return FALSE;
		}		
	}
	
	/**
	* Set the size for the given content item
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id
	* @param integer $size
	* @return void
	*/
	public function setSize($site_id, $page_id, $content_id, $size) 
	{
		$sql = 'INSERT INTO user_site_page_content_item_size
				(site_id, page_id, content_id, size) 
				VALUES 
				(:site_id, :page_id, :content_id, :size)';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':size', $size, PDO::PARAM_INT);
		$stmt->execute();				
	}
	
	/**
	* Update the size for the given content item
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id
	* @param integer $size
	* @return void
	*/
	public function updateSize($site_id, $page_id, $content_id, $size) 
	{
		$sql = 'UPDATE user_site_page_content_item_size 
				SET size = :size 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND content_id = :content_id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':size', $size, PDO::PARAM_INT);
		$stmt->execute();
	}	
}