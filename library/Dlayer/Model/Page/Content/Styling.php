<?php
/**
* Styling model for content item containers
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Styling.php 1861 2014-05-27 11:30:18Z Dean.Blackborough $
*/
class Dlayer_Model_Page_Content_Styling extends Zend_Db_Table_Abstract
{
	/**
	* Check to see if a background colour has been defined for the selected 
	* content item container
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id
	* @return integer|FALSE Either returns the id of the assigned background 
	* 	colour or FALSE if no background colour has been define
	*/
	public function existingItemContainerBackgroundColor($site_id, $page_id, 
		$content_id) 
	{
		$sql = 'SELECT uspscbc.id 
				FROM user_site_page_styles_container_background_color uspscbc
				WHERE uspscbc.site_id = :site_id 
				AND uspscbc.page_id = :page_id 
				AND uspscbc.content_id = :content_id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			return intval($result['id']);
		} else {
			return FALSE;
		}
	}
	
	/**
	* Check to see if a background colour has been defined for the selected 
	* content row
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_row_id
	* @return integer|FALSE Either returns the id of the assigned background 
	* 	colour or FALSE if no background colour has been defined
	*/
	public function existingRowBackgroundColor($site_id, $page_id, 
		$content_row_id) 
	{
		$sql = 'SELECT uspsrbc.id 
				FROM user_site_page_styles_row_background_color uspsrbc
				WHERE uspsrbc.site_id = :site_id 
				AND uspsrbc.page_id = :page_id 
				AND uspsrbc.content_row_id = :content_row_id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			return intval($result['id']);
		} else {
			return FALSE;
		}
	}
	
	/**
	* Check to see if a background colour has been defined for the selected 
	* content area
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_area_id
	* @return integer|FALSE Either returns the id of the assigned background 
	* 	colour or FALSE if no background colour has been defined
	*/
	public function existingAreaBackgroundColor($site_id, $page_id, 
		$content_area_id) 
	{
		$sql = 'SELECT uspsabc.id 
				FROM user_site_page_styles_area_background_color uspsabc
				WHERE uspsabc.site_id = :site_id 
				AND uspsabc.page_id = :page_id 
				AND uspsabc.content_area_id = :content_area_id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_area_id', $content_area_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			return intval($result['id']);
		} else {
			return FALSE;
		}
	}
	
	/**
	* Check to see if a background colour has been defined for the selected 
	* content item
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id
	* @return integer|FALSE Either returns the id of the assigned background 
	* 	colour or FALSE if no background colour has been define
	*/
	public function existingItemBackgroundColor($site_id, $page_id, 
		$content_id) 
	{
		$sql = 'SELECT uspsibc.id 
				FROM user_site_page_styles_item_background_color uspsibc
				WHERE uspsibc.site_id = :site_id 
				AND uspsibc.page_id = :page_id 
				AND uspsibc.content_id = :content_id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			return intval($result['id']);
		} else {
			return FALSE;
		}
	}
	
	/**
	* Add a background colour for the selected content item container
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id
	* @param string $hex
	* @return void
	*/
	public function addItemContainerBackgroundColor($site_id, $page_id, 
		$content_id, $hex) 
	{
		$sql = 'INSERT INTO user_site_page_styles_container_background_color 
				(site_id, page_id, content_id, color_hex) 
				VALUES 
				(:site_id, :page_id, :content_id, :color_hex)';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);		
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);		
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':color_hex', $hex, PDO::PARAM_STR);
		$stmt->execute();
	}
	
	/**
	* Add a background colour for the selected content item
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id
	* @param string $hex
	* @return void
	*/
	public function addItemBackgroundColor($site_id, $page_id, $content_id, 
		$hex) 
	{
		$sql = 'INSERT INTO user_site_page_styles_item_background_color 
				(site_id, page_id, content_id, color_hex) 
				VALUES 
				(:site_id, :page_id, :content_id, :color_hex)';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);		
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);		
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':color_hex', $hex, PDO::PARAM_STR);
		$stmt->execute();
	}
	
	/**
	* Add a background colour for the selected content row
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_row_id
	* @param string $hex
	* @return void
	*/
	public function addRowBackgroundColor($site_id, $page_id, $content_row_id, 
		$hex) 
	{
		$sql = 'INSERT INTO user_site_page_styles_row_background_color 
				(site_id, page_id, content_row_id, color_hex) 
				VALUES 
				(:site_id, :page_id, :content_row_id, :color_hex)';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);		
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);		
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->bindValue(':color_hex', $hex, PDO::PARAM_STR);
		$stmt->execute();
	}
	
	/**
	* Add a background colour for the selected content area
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_row_id
	* @param string $hex
	* @return void
	*/
	public function addAreaBackgroundColor($site_id, $page_id, $content_area_id, 
		$hex) 
	{
		$sql = 'INSERT INTO user_site_page_styles_area_background_color 
				(site_id, page_id, content_area_id, color_hex) 
				VALUES 
				(:site_id, :page_id, :content_area_id, :color_hex)';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);		
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);		
		$stmt->bindValue(':content_area_id', $content_area_id, PDO::PARAM_INT);
		$stmt->bindValue(':color_hex', $hex, PDO::PARAM_STR);
		$stmt->execute();
	}
	
	/**
	* Update the background colour for the selected content item container
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id
	* @param integer $id
	* @param string $hex
	* @return void
	*/
	public function updateItemContainerBackgroundColor($site_id, $page_id, 
		$content_id, $id, $hex) 
	{
		$sql = 'UPDATE user_site_page_styles_container_background_color 
				SET color_hex = :hex 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND content_id = :content_id 
				AND id = :id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':hex', $hex, PDO::PARAM_STR);
		$stmt->execute();
	}
	
	/**
	* Update the background colour for the selected content item
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id
	* @param integer $id
	* @param string $hex
	* @return void
	*/
	public function updateItemBackgroundColor($site_id, $page_id, $content_id, 
		$id, $hex) 
	{
		$sql = 'UPDATE user_site_page_styles_item_background_color 
				SET color_hex = :hex 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND content_id = :content_id 
				AND id = :id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':hex', $hex, PDO::PARAM_STR);
		$stmt->execute();
	}
	
	/**
	* Update the background colour for the selected content row
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_row_id
	* @param integer $id
	* @param string $hex
	* @return void
	*/
	public function updateRowBackgroundColor($site_id, $page_id, 
		$content_row_id, $id, $hex) 
	{
		$sql = 'UPDATE user_site_page_styles_row_background_color 
				SET color_hex = :hex 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND content_row_id = :content_row_id 
				AND id = :id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':hex', $hex, PDO::PARAM_STR);
		$stmt->execute();
	}
	
	/**
	* Update the background colour for the selected content area
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_area_id
	* @param integer $id
	* @param string $hex
	* @return void
	*/
	public function updateAreaBackgroundColor($site_id, $page_id, 
		$content_area_id, $id, $hex) 
	{
		$sql = 'UPDATE user_site_page_styles_area_background_color 
				SET color_hex = :hex 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND content_area_id = :content_area_id 
				AND id = :id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_area_id', $content_area_id, PDO::PARAM_INT);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':hex', $hex, PDO::PARAM_STR);
		$stmt->execute();
	}
	
	/**
	* Clear the background color for the selected content item container
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id
	* @param integer $id
	* @return void
	*/
	public function clearItemContainerBackgroundColor($site_id, $page_id, 
		$content_id, $id) 
	{
		$sql = 'DELETE FROM user_site_page_styles_container_background_color 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND content_id = :content_id 
				AND id = :id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
	}
	
	/**
	* Clear the background color for the selected content item
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id
	* @param integer $id
	* @return void
	*/
	public function clearItemBackgroundColor($site_id, $page_id, $content_id, 
		$id) 
	{
		$sql = 'DELETE FROM user_site_page_styles_item_background_color 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND content_id = :content_id 
				AND id = :id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
	}
	
	/**
	* Clear the background color for the selected content row
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_row_id
	* @param integer $id
	* @return void
	*/
	public function clearRowBackgroundColor($site_id, $page_id, 
		$content_row_id, $id) 
	{
		$sql = 'DELETE FROM user_site_page_styles_row_background_color 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND content_row_id = :content_row_id 
				AND id = :id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
	}
	
	/**
	* Clear the background color for the selected content area
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_row_id
	* @param integer $id
	* @return void
	*/
	public function clearAreaBackgroundColor($site_id, $page_id, 
		$content_row_id, $id) 
	{
		$sql = 'DELETE FROM user_site_page_styles_area_background_color 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND content_area_id = :content_area_id 
				AND id = :id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_area_id', $content_area_id, PDO::PARAM_INT);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
	}
	
	/**
	* Fetch the background colour for an item container
	* 
	* @param integer site_id
	* @param integer $page_id
	* @param integer $content_id
	* @return string|FALSE Either the background colour hex or FALSE if there 
	* 	is no value
	*/
	public function itemContainerBackgroundColor($site_id, $page_id, 
		$content_id) 
	{
		$sql = 'SELECT color_hex 
				FROM user_site_page_styles_container_background_color 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND content_id = :content_id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			return $result['color_hex'];
		} else {
			return FALSE;
		}
	}
	
	/**
	* Fetch the background colour for a content item
	* 
	* @param integer site_id
	* @param integer $page_id
	* @param integer $content_id
	* @return string|FALSE Either the background colour hex or FALSE if there 
	* 	is no value
	*/
	public function itemBackgroundColor($site_id, $page_id, 
		$content_id) 
	{
		$sql = 'SELECT color_hex 
				FROM user_site_page_styles_item_background_color 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND content_id = :content_id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			return $result['color_hex'];
		} else {
			return FALSE;
		}
	}
	
	/**
	* Fetch the background colour for a content row
	* 
	* @param integer site_id
	* @param integer $page_id
	* @param integer $content_row_id
	* @return string|FALSE Either the background colour hex or FALSE if there 
	* 	is no value
	*/
	public function rowBackgroundColor($site_id, $page_id, $content_row_id) 
	{
		$sql = 'SELECT color_hex 
				FROM user_site_page_styles_row_background_color 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND content_row_id = :content_row_id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			return $result['color_hex'];
		} else {
			return FALSE;
		}
	}
	
	/**
	* Fetch the background colour for the content area
	* 
	* @param integer site_id
	* @param integer $page_id
	* @param integer $content_area_id
	* @return string|FALSE Either the background colour hex or FALSE if there 
	* 	is no current value
	*/
	public function areaBackgroundColor($site_id, $page_id, $content_area_id) 
	{
		$sql = 'SELECT color_hex 
				FROM user_site_page_styles_area_background_color 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND content_area_id = :content_area_id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_area_id', $content_area_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			return $result['color_hex'];
		} else {
			return FALSE;
		}
	}
}