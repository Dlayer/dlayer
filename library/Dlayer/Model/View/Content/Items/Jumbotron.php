<?php
/**
* Content jumbotron view model
*
* Responsible for fetching the jumbotron item data from the database, and 
* attaching  all the additional data defined by the sub tools.
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @category View model
*/
class Dlayer_Model_View_Content_Items_Jumbotron extends Zend_Db_Table_Abstract
{
	/**
	* Fetch the base data for the jumbotron content item, this includes the 
	* title and sub title. The styling options will have already been 
	* defined in the view based on the options in the settings, custom options 
	* defined by sub tools are returned in their own methods
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id Content id
	* @return array|FALSE Either the content data array including the content 
	* 	id or FALSE is nothing can be found
	*/
	private function item($site_id, $page_id, $content_id)
	{
		$sql = "SELECT uspcij.content_id, uscj.content AS title, uspcis.size  
				FROM user_site_page_content_item_jumbotron uspcij 
				JOIN user_site_content_jumbotron uscj 
					ON uspcij.data_id = uscj.id 
					AND uscj.site_id = :site_id 
				LEFT JOIN user_site_page_content_item_size uspcis 
					ON uspcij.content_id = uspcis.content_id 
					AND uspcis.site_id = :site_id 
					AND uspcis.page_id = :page_id 
				WHERE uspcij.content_id = :content_id  
				AND uspcij.site_id = :site_id 
				AND uspcij.page_id = :page_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		$exploded = explode('-:-', $result['title']);
		
		$result['title'] = $exploded['0'];
		$result['sub_title'] = $exploded['1'];

		return $result;
	}
	
	/**
	* Fetch the base data for the content item as well as any additional 
	* data that may have been defined by the sub tools, examples being styling 
	* values
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id Content id
	* @return array|FALSE Either the full content data array including the 
	* 	content id or FALSE if the data can't be pulled
	*/
	public function data($site_id, $page_id, $content_id) 
	{
		$item = $this->item($site_id, $page_id, $content_id);   	
		
		return $item;
	}
}