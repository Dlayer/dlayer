<?php
/**
* Image content item view model
* 
* Responsible for fetching the image content item data from the database and 
* attaching all the additional data defined by the sub tools
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @category View model
*/
class Dlayer_Model_View_Content_Items_Image extends Zend_Db_Table_Abstract 
{
	/**
	* Fetch the base data for the image content, the data required to fetch the 
	* image, the title and the size of the content box, custom options 
	* defined by the sub tools are returned by their own methods
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id Content id
	* @return array|FALSE Either the content data array including the content 
	* 	id or FALSE is nothing can be found
	*/
	private function item($site_id, $page_id, $content_id) 
	{
		$sql = "SELECT uspcii.content_id, usilv.id AS version_id, 
				usilv.library_id, usil.`name`, usilvm.extension
				FROM user_site_page_content_item_image uspcii 
				JOIN user_site_image_library_version usilv 
					ON uspcii.version_id = usilv.id 
					AND usilv.site_id = :site_id
				JOIN user_site_image_library_version_meta usilvm 
					ON usilv.id = usilvm.version_id 
					AND usilvm.library_id = usilv.library_id 
					AND usilvm.site_id = :site_id 
				JOIN user_site_image_library usil 
					ON usilv.library_id = usil.id
					AND usil.site_id = :site_id 
				LEFT JOIN user_site_page_content_item_size uspcis 
					ON uspcii.content_id = uspcis.content_id 
					AND uspcis.site_id = :site_id 
					AND uspcis.page_id = :page_id 
				WHERE uspcii.content_id = :content_id 
				AND uspcii.site_id = :site_id 
				AND uspcii.page_id = :page_id";
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