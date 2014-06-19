<?php
/**
* Position model for content item containers
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Position.php 1774 2014-04-30 16:17:34Z Dean.Blackborough $
*/
class Dlayer_Model_Page_Content_Position extends Zend_Db_Table_Abstract
{
    /**
    * Check to see if there are existing margin values for the content item, 
    * all margins are returned, all values stored in the same row
    * 
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @param integer $content_id
    * @param string $content_type
    * @return FALSE|integer Returns either the id of the existing margin entry 
    * 						row of FALSE if there are no margin values for the 
    * 						content item
    */
    public function existingMarginValues($site_id, $page_id, $div_id, 
    $content_id, $content_type) 
    {
    	$sql = "SELECT uspccm.id
				FROM user_site_page_content_container_margins uspccm 
				JOIN designer_content_types dct 
					ON uspccm.content_type = dct.id 
					AND dct.`name` = :content_type 	
				WHERE uspccm.site_id = :site_id 
				AND uspccm.page_id = :page_id 
				AND uspccm.div_id = :div_id 
				AND uspccm.content_id = :content_id";
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
    * Fetch the combined left and right margin values, this can be used by the 
    * tool validate methods to make sure the user doesn't set the combined 
    * width of a content item to be larger than the page container the content 
    * item sits in
    * 
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @param integer $content_id
    * @param string $content_type
    * @return integer Always return an integer value for the margins, 0 being 
    * 				  the default if no left and right margins are defined
    */
    public function containerCombinedMarginWidth($site_id, $page_id, $div_id, 
    $content_id, $content_type) 
    {
    	$sql = "SELECT uspccm.`left`, uspccm.`right` 
				FROM user_site_page_content_container_margins uspccm 
				JOIN designer_content_types dct 
					ON uspccm.content_type = dct.id 
					AND dct.`name` = :content_type 	
				WHERE uspccm.site_id = :site_id 
				AND uspccm.page_id = :page_id 
				AND uspccm.div_id = :div_id 
				AND uspccm.content_id = :content_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_type', $content_type, PDO::PARAM_STR);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			return intval($result['left']) + intval($result['right']);
		} else {
			return 0;
		}
    }
    
    /**
    * Add the margin values for the selected content container item
    * 
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @param integer $content_id
    * @param string $content_type
    * @param array $margins Margins array contains four indexes, top, right, 
    * 						bottom and left
    * @return void
    */
    public function addMarginValues($site_id, $page_id, $div_id, 
    $content_id, $content_type, array $margins) 
    {
		$sql = "INSERT INTO user_site_page_content_container_margins 
				(site_id, page_id, div_id, content_id, content_type, 
				`top`, `right`, `bottom`, `left`) 
				VALUES 
				(:site_id, :page_id, :div_id, :content_id, 
				(SELECT id FROM designer_content_types 
					WHERE `name` = :content_type), 
				:top, :right, :bottom, :left)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_type', $content_type, PDO::PARAM_STR);
		$stmt->bindValue(':top', $margins['top'], PDO::PARAM_INT);
		$stmt->bindValue(':right', $margins['right'], PDO::PARAM_INT);
		$stmt->bindValue(':bottom', $margins['bottom'], PDO::PARAM_INT);
		$stmt->bindValue(':left', $margins['left'], PDO::PARAM_INT);
		$stmt->execute();
    }
    
    /**
    * Update the margin values, we have the id already so just need to do a 
    * simple update
    * 
    * @param integer $id
    * @param array $margins Margins array has four indexes, top, right, 
    * 						bottom and left
    * @return void
    */
    public function updateMarginValues($id, array $margins) 
    {
    	$sql = "UPDATE user_site_page_content_container_margins 
    			SET `top` = :top, `right` = :right, `bottom` = :bottom, 
    			`left` = :left 
    			WHERE id = :id 
    			LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':top', $margins['top'], PDO::PARAM_INT);
		$stmt->bindValue(':right', $margins['right'], PDO::PARAM_INT);
		$stmt->bindValue(':bottom', $margins['bottom'], PDO::PARAM_INT);
		$stmt->bindValue(':left', $margins['left'], PDO::PARAM_INT);
		$stmt->execute();
    }
    
    /**
    * Clear any currently set margin values, clears all values, top, right, 
    * left and bottom
    * `
    * @param integer $id
    * @return void
    */
    public function clearMarginValues($id) 
    {
		$sql = "DELETE FROM user_site_page_content_container_margins 
				WHERE id = :id 
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
    }
    
    /** 
    * Fetch the current margin values for the selected container, if there are 
    * no margins define for the container FALSE is returned other an array with 
    * top, right, bottom and left indexes
    * 
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @param integer $content_id
    * @param string $content_type
    * @return array|FALSE
    */
    public function marginValues($site_id, $page_id, $div_id, $content_id, 
    $content_type) 
    {
		$sql = "SELECT uspccm.`top`, uspccm.`right`, uspccm.`bottom`, 
				uspccm.`left` 
				FROM user_site_page_content_container_margins uspccm 
				JOIN designer_content_types dct 
					ON uspccm.content_type = dct.id 
					AND dct.`name` = :content_type 
				WHERE uspccm.site_id = :site_id 
				AND uspccm.page_id = :page_id 
				AND uspccm.div_id = :div_id 
				AND uspccm.content_id = :content_id";
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
			return array('top'=>intval($result['top']), 
			'right'=>intval($result['right']), 
			'bottom'=>intval($result['bottom']), 
			'left'=>intval($result['left']), 
			'content_id'=>$content_id);
		}
    }
    
    /**
    * Check that the margin value is within the required range, must be an 
    * integer between 0 and a 1000
    * 
    * @param integer $margin
    * @return boolean TRUE if the margin value is valid
    */
    public function marginValueValid($margin) 
    {
		if(intval($margin) >= 0 && intval($margin) <= 1000) {
			return TRUE;
		} else {
			return FALSE;
		}
    }
}