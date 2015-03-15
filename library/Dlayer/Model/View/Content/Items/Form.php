<?php
/**
* Content form item view model
* 
* Responsible for fetching the data required to allow the form builder to 
* genereate the requested form
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @category View model
*/
class Dlayer_Model_View_Content_Items_Form extends Zend_Db_Table_Abstract 
{
	/**
	* Fetch the base data required to instantiate the form, essentially 
	* just the id of the form, custom options defined by subtools will be 
	* returned by their  own methods
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id Content id
	* @return array|FALSE Either the content data array including the content 
	* 	id or FALSE is the data cannot be pulled
	*/
	private function item($site_id, $page_id, $content_id) 
	{
		$sql = "SELECT uspcif.content_id, uspcif.form_id, uspcis.size, 
				uspcis.offset 
				FROM user_site_page_content_item_form uspcif 
				LEFT JOIN user_site_page_content_item_size uspcis 
					ON uspcif.content_id = uspcis.content_id 
					AND uspcis.site_id = :site_id 
					AND uspcis.page_id = :page_id 
				WHERE uspcif.content_id = :content_id 
				AND uspcif.site_id = :site_id 
				AND uspcif.page_id = :page_id";
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