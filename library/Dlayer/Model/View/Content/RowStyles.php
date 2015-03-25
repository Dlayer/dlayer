<?php
/**
* Content row styles model. The model is responsible for fetching all 
* the styles that have been defined for content rows using the row styling 
* options
* 
* This model fetches the data for an entire content page and should only ever 
* be called when fetching the data for the design view of the designer, it is 
* output only, no management
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @category View model
*/
class Dlayer_Model_View_Content_RowStyles extends Zend_Db_Table_Abstract
{
	/**
	* Fetch all the defined background colour styles for the content rows that 
	* make up the current page, results are returned indexed by content row id
	* 
	* If a content row is currently selected within the content manager 
	* we don't return its defined background colour as it will interfere with 
	* the selected status highlight
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer|NULL $content_row_id The Id of the currently selected 
	* 	content row
	* @return array|FALSE Either an array indexed by content row id or FALSE 
	* 	if there are no defined style values
	*/
	public function backgroundColors($site_id, $page_id, $content_row_id=NULL) 
	{
		$sql = 'SELECT uspsrbc.content_row_id, uspsrbc.color_hex 
				FROM user_site_page_styles_row_background_color uspsrbc 
				WHERE uspsrbc.site_id = :site_id 
				AND uspsrbc.page_id = :page_id ';
		if($content_row_id != NULL) {
			$sql .= 'AND uspsrbc.content_row_id != :content_row_id';
		}
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		if($content_row_id != NULL) {
			$stmt->bindValue(':content_row_id', $content_row_id, 
				PDO::PARAM_INT);
		}
		$stmt->execute();
		
		$result = $stmt->fetchAll();
		
		if(count($result) > 0) {
			$styles = array();
			
			foreach($result as $row) {
				$styles[$row['content_row_id']] = $row['color_hex'];
			}
			
			return $styles;
		} else {
			return FALSE;
		}
	}
}