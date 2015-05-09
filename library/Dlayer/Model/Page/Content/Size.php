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
	
	/**
	* Calculate the suggested column size for a new item in the content row 
	* based upon the size of all the sibling content items
	* 
	* @param integer $site_id
	* @param integer $oage_id
	* @param integer $content_row_id
	* @param integer $suggested_maximum_size Suggested maximum size for the 
	*   content item
	* @return integer The suggested column size, will be a value between 1 and 
	* 	12
	*/
	public function suggestedColumnSize($site_id, $page_id, $content_row_id, 
		$suggested_maximum_size)
	{
		$content_items = $this->contentItemSizes($site_id, $page_id, 
			$content_row_id);
			
		$last_row = $this->sizeOfLastRow($content_items);
		
		if($last_row == 12) {
			return $suggested_maximum_size;
		} else {
			return 12-$last_row;
		}
	}
	
	/**
	* Calculate the size of the last 'row' based on the content items in a 
	* content row
	* 
	* @param array $content_items
	* @return integer Size of last row, value between 0 and 12
	*/
	private function sizeOfLastRow(array $content_items) 
	{
		$i = 0;
		$rows = array($i=>0);
				
		foreach ($content_items as $item) {
			if($rows[$i] + intval($item['size']) > 12) {				
				++$i;				
				$rows[$i] = intval($item['size']);
			} else {
				$rows[$i] += intval($item['size']);
			}
		}
		
		return $rows[$i];
	}
	
	/**
	* Fetch the size for all the content items in the content row taking into 
	* account any values that increase the size, for example offset
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_row_id
	* @return array Contains the total size for each of the content items in 
	* 	the row ordered by the current sort order
	*/
	public function contentItemSizes($site_id, $page_id, $content_row_id) 
	{
		$sql = 'SELECT IFNULL(uspcis.size, 12) + 
				IFNULL(uspcis.offset, 0) AS size
				FROM user_site_page_content_item uspci 
				LEFT JOIN user_site_page_content_item_size uspcis 
					ON uspci.id = uspcis.content_id 
					AND uspcis.site_id = :site_id
					AND uspcis.page_id = :page_id
				WHERE uspci.site_id = :site_id
				AND uspci.page_id = :page_id
				AND uspci.content_row_id = :content_row_id
				ORDER BY uspci.sort_order ASC';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetchAll();
	}
}