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
	* Fetch the currently set size and offset for the selected content item
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id
	* @return array|FALSE Either returns and array containing the size and 
	* 	offset or FALSE if there os no data
	*/
	public function sizeAndOffset($site_id, $page_id, $content_id) 
	{
		$sql = 'SELECT size, offset 
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
			return array(
				'size'=>intval($result['size']), 
				'offset'=>intval($result['offset'])
			);
		} else {
			return FALSE;
		}		
	}
		
	/**
	* Set the size and offset values for the selected content item
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id
	* @param integer $size
	* @param integer $offset
	* @return void
	*/
	public function setSizeAndOffset($site_id, $page_id, $content_id, 
		$size=12, $offset=0) 
	{
		$sql = 'INSERT INTO user_site_page_content_item_size
				(site_id, page_id, content_id, size, offset) 
				VALUES 
				(:site_id, :page_id, :content_id, :size, :offset)';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':size', $size, PDO::PARAM_INT);
		$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
		$stmt->execute();				
	}
	
	/**
	* Update the size for the selected content item
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
	
	/**
	* Update the offset for the selected content item
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id
	* @param integer $offset
	* @return void
	*/
	public function updateOffset($site_id, $page_id, $content_id, $offset) 
	{
		$sql = 'UPDATE user_site_page_content_item_size 
				SET offset = :offset 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND content_id = :content_id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
		$stmt->execute();
	}	
}