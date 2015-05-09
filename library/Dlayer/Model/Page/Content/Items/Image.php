<?php
/**
* Image content item model, all the model methods for adding and editing 
* an image content item
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Model_Page_Content_Items_Image 
extends Dlayer_Model_Page_Content_Item
{   
	/**
	* Insert an image as a content item
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @param integer $content_id
	* @param array $params The data for the heading content item
	* @return void
	*/
	public function addContentItemData($site_id, $page_id, $div_id, 
		$content_row_id, $content_id, array $params)
	{
		$sql = 'INSERT INTO user_site_page_content_item_image 
				(site_id, page_id, content_id, version_id, expand) 
				VALUES 
				(:site_id, :page_id, :content_id, :version_id, :expand)';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':version_id', $params['version_id'], PDO::PARAM_INT);
		$stmt->bindValue(':expand', $params['expand'], PDO::PARAM_INT);
		$stmt->execute();
	}
}