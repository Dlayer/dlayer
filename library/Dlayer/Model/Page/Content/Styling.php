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
    * Check to see if there is an existing background color for the content 
    * item
    * 
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @param integer $content_id
    * @param string $content_type
    * @return FALSE|integer Returns either the id of the existing background 
    * 						color value or FALSE if there is no existing value
    */
    public function existingBackgroundColor($site_id, $page_id, $div_id, 
    $content_id, $content_type) 
    {
    	$sql = "SELECT uspccbc.id
				FROM user_site_page_content_container_background_colors uspccbc 
				JOIN designer_content_types dct 
					ON uspccbc.content_type = dct.id 
					AND dct.`name` = :content_type 	
				WHERE uspccbc.site_id = :site_id 
				AND uspccbc.page_id = :page_id 
				AND uspccbc.div_id = :div_id 
				AND uspccbc.content_id = :content_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_type', $content_type, PDO::PARAM_STR);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			return intval($result['id']);
		} else {
			return FALSE;
		}
    }
    
    /**
    * Add a background color for the selected content container item
    * 
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @param integer $content_id
    * @param string $content_type
    * @param string $color_hex
    * @return void
    */
    public function addBackgroundColor($site_id, $page_id, $div_id, 
    $content_id, $content_type, $color_hex) 
    {
		$sql = "INSERT INTO user_site_page_content_container_background_colors 
				(site_id, page_id, div_id, content_id, content_type, 
				color_hex) 
				VALUES 
				(:site_id, :page_id, :div_id, :content_id, 
				(SELECT id FROM designer_content_types 
					WHERE `name` = :content_type), 
				:color_hex)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_type', $content_type, PDO::PARAM_STR);
		$stmt->bindValue(':color_hex', $color_hex, PDO::PARAM_STR);
		$stmt->execute();
    }
    
    /**
    * Update the background color, we have the id so just need to do a simple 
    * update. 
    * 
    * @param integer $id
    * @param string $color_hex
    * @return void
    */
    public function updateBackgroundColor($id, $color_hex) 
    {
		$sql = "UPDATE user_site_page_content_container_background_colors 
				SET color_hex = :color_hex 
				WHERE id = :id 
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':color_hex', $color_hex, PDO::PARAM_STR);
		$stmt->execute();
    }
    
    /**
    * Clear the background color for the content container
    * 
    * @param integer $id
    * @return void
    */
    public function clearBackgroundColor($id) 
    {
		$sql = "DELETE FROM user_site_page_content_container_background_colors 
				WHERE id = :id 
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
    }
    
    /** 
    * Fetch the current background color for the selected content item, if 
    * there is no existing data, return FALSE
    * 
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @param integer $content_id
    * @param string $content_type
    * @return string|FALSE
    */
    public function backgroundColor($site_id, $page_id, $div_id, $content_id, 
    $content_type) 
    {
		$sql = "SELECT uspccbc.color_hex 
				FROM user_site_page_content_container_background_colors uspccbc 
				JOIN designer_content_types dct 
					ON uspccbc.content_type = dct.id 
					AND dct.`name` = :content_type 
				WHERE uspccbc.site_id = :site_id 
				AND uspccbc.page_id = :page_id 
				AND uspccbc.div_id = :div_id 
				AND uspccbc.content_id = :content_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_type', $content_type, PDO::PARAM_STR);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result == FALSE) {
			return FALSE;
		} else {
			return $result['color_hex'];
		}
    }
}