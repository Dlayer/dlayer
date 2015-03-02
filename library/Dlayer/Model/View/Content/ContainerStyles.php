<?php
/**
* Content container styles model. The model is responsible for fetching all 
* the styles that have been defined for content item containers using the 
* styling tab of each content tool.
* 
* This model fetches the data for an entire content page and should only ever 
* be called when fetching the data for the design view of the designer, it is 
* output only, no management
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @category View model
*/
class Dlayer_Model_View_Content_ContainerStyles extends Zend_Db_Table_Abstract
{
	/**
	* Fetch all the defined background colour styles for the content item 
	* containers that makde up the current page, results are returned indexed 
	* by content item id
	* 
	* If a content item is currently selected within the content manager 
	* we don't return its defined background colour as it will interfere with 
	* the selected status highlight
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer|NULL $content_id The Id of the currently selected 
	* 	content item
	* @return array|FALSE Either an array indexed by content id or FALSE if 
	* 	there are no defined style values
	*/
	public function backgroundColors($site_id, $page_id, $content_id=NULL) 
	{
		$sql = 'SELECT uspcicbc.content_id, uspcicbc.color_hex 
				FROM user_site_page_content_item_container_background_color uspcicbc 
				WHERE uspcicbc.site_id = :site_id 
				AND uspcicbc.page_id = :page_id ';
		if($content_id != NULL) {
			$sql .= 'AND uspcicbc.content_id != :content_id';
		}
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		if($content_id != NULL) {
			$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		}
		$stmt->execute();
		
		$result = $stmt->fetchAll();
		
		if(count($result) > 0) {
			$styles = array();
			
			foreach($result as $row) {
				$styles[$row['content_id']] = $row['color_hex'];
			}
			
			return $styles;
		} else {
			return FALSE;
		}
	}
	
	/**
	* Fetch all the defined margin values for the content item containers for 
	* a specific page, returns and array indexed by content id
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @return array|FALSE An array of the margin values indexes by content id, 
	* 					  the value will be an array with indexes for each set 
	* 					  margin
	*/
	/*public function margins($site_id, $page_id) 
	{
		$sql = "SELECT uspccm.content_id, uspccm.`top`, uspccm.`right`, 
				uspccm.`bottom`, uspccm.`left` 
				FROM user_site_page_content_container_margins uspccm 
				WHERE uspccm.site_id = :site_id 
				AND uspccm.page_id = :page_id";
				
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetchAll();
		
		if(count($result) > 0) {
			$rows = array();
			
			foreach($result as $row) {
				$rows[$row['content_id']] = $row;
			}
			
			return $rows;
		} else {
			return FALSE;
		}
	}*/
}