<?php
/**
* Content item styles model. The model is responsible for fetching all 
* the styles that have been defined for content items using the 
* styling tab of each content tool.
* 
* This model fetches the data for an entire content page and should only ever 
* be called when fetching the data for the design view of the designer, it is 
* output only, no management
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
* @category View model
*/
class Dlayer_Model_View_Content_ItemStyles extends Zend_Db_Table_Abstract
{
	/**
	* Fetch all the defined background colour styles for the content item 
	* that made up the current page, results are returned indexed by content 
	* item id
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @return array|FALSE Either an array indexed by content id or FALSE if 
	* 	there are no defined style values
	*/
	public function backgroundColors($site_id, $page_id) 
	{
		$sql = 'SELECT uspsibc.content_id, uspsibc.color_hex 
				FROM user_site_page_styles_item_background_color uspsibc 
				WHERE uspsibc.site_id = :site_id 
				AND uspsibc.page_id = :page_id ';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
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
}