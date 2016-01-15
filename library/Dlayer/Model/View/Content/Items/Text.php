<?php
/**
* Content text view model
* 
* Responsible for fetching the text item data from the database, and attaching 
* all the additional data defined by the sub tools.
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
* @category View model
*/
class Dlayer_Model_View_Content_Items_Text extends Zend_Db_Table_Abstract 
{
	/**
	* Fetch the base data for the text content item, the text itself and the 
	* size of the content box, custom options defined by the sub tools are 
	* returned by their own methods
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id Content id
	* @return array|FALSE Either the content data array including the content 
	* 	id or FALSE is nothing can be found
	*/
	private function item($site_id, $page_id, $content_id) 
	{
		$sql = "SELECT uspcit.content_id, usct.content, uspcis.size, 
				uspcis.offset 
				FROM user_site_page_content_item_text uspcit 
				JOIN user_site_content_text usct ON uspcit.data_id = usct.id 
					AND usct.site_id = :site_id 
				LEFT JOIN user_site_page_content_item_size uspcis 
					ON uspcit.content_id = uspcis.content_id 
					AND uspcis.site_id = :site_id 
					AND uspcis.page_id = :page_id 
				WHERE uspcit.content_id = :content_id 
				AND uspcit.site_id = :site_id 
				AND uspcit.page_id = :page_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch();
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