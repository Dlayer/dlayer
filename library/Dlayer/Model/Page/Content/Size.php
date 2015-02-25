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
		$stmt->bindValue(':page_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $site_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			return intval($result['size']);
		} else {
			return FALSE;
		}		
	}
}