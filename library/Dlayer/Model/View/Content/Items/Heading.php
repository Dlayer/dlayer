<?php
/**
* Content heading view model
*
* Responsible for fetching the headings from the database and attaching the
* styling data for the heading type chosen. When someone adds a heading they get
* to choose the heading style and set the top and bottom margins
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @category View model
*/
class Dlayer_Model_View_Content_Items_Heading extends Zend_Db_Table_Abstract
{
	/**
	* Fetch the base data for the heading content item, this includes the 
	* text, heading type and tag. The styling options will have already been 
	* defined in the view based on the options in the settings, custom options 
	* defined by sub tools are returned in their own methods
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id Content id
	* @return array|FALSE Either the content data array including the content 
	* 					  id or FALSE is nothing can be found
	*/
	private function item($site_id, $page_id, $content_id)
	{
		$sql = "SELECT uspcih.content_id, usch.content, dch.tag 
				FROM user_site_page_content_item_heading uspcih 
				JOIN user_site_content_heading usch 
					ON uspcih.data_id = usch.id 
					AND usch.site_id = :site_id 
				JOIN designer_content_heading dch 
					ON uspcih.heading_id = dch.id 
				WHERE uspcih.content_id = :content_id 
				AND uspcih.site_id = :site_id 
				AND uspcih.page_id = :page_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch();
	}
	
	/**
	* Fetch the combined left and right margin values for the content item, 
	* margin values can be defined using the position tab of the text tool. 
	* 
	* Value is required to allow the view helpers to set the correct size for 
	* the container and controls for the content item
	* 
	* @todo this method is duplicated, remedy that
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id
	* @return integer Combined extra margin width
	*/
	private function containerCombinedMargin($site_id, $page_id, $content_id) 
	{
		$sql = "SELECT uspccm.`left`, uspccm.`right` 
				FROM user_site_page_content_container_margins uspccm 
				JOIN designer_content_types dct ON uspccm.content_type = dct.id 
				WHERE uspccm.site_id = :site_id
				AND uspccm.page_id = :page_id  
				AND uspccm.content_id = :content_id 
				AND dct.`name` = :content_type";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_type', 'heading', PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			return intval($result['left']) + intval($result['right']);
		} else {
			return 0;
		}
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
	* 					  content id or FALSE if the data can't be pulled
	*/
	public function data($site_id, $page_id, $content_id) 
	{
		$item = $this->item($site_id, $page_id, $content_id);   	
		
		/*if($item != FALSE) {    		
			$item['container_margin'] = $this->containerCombinedMargin(
			$site_id, $page_id, $content_id);
		}*/
		
		return $item;
	}
}