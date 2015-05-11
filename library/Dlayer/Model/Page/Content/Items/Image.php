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
				(site_id, page_id, content_id, version_id, expand, caption) 
				VALUES 
				(:site_id, :page_id, :content_id, :version_id, :expand, 
				:caption)';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':version_id', $params['version_id'], PDO::PARAM_INT);
		$stmt->bindValue(':expand', $params['expand'], PDO::PARAM_INT);
		$stmt->bindValue(':caption', $params['caption'], PDO::PARAM_STR);
		$stmt->execute();
	}
	
	/**
	* Edit the data for a content item
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @param integer $content_id
	* @param array $params The data for the new content item
	* @return void
	*/
	public function editContentItemData($site_id, $page_id, $div_id, 
		$content_row_id, $content_id, array $params) 
	{
		$sql = 'UPDATE user_site_page_content_item_image 
				SET version_id = :version_id, 
				expand = :expand, 
				caption = :caption 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND content_id = :content_id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':version_id', $params['version_id'], PDO::PARAM_INT);
		$stmt->bindValue(':expand', $params['expand'], PDO::PARAM_INT);
		$stmt->bindValue(':caption', $params['caption'], PDO::PARAM_STR);
		$stmt->execute();
	}
	
	/**
	* Fetch the existing data for the content item being edited, in this 
	* case the version id, expand setting and the caption for the image
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @param integer $content_id
	* @return array|FALSE Returns either the data array or FALSE if no data 
	*     can be found
	*/
	public function formData($site_id, $page_id, $div_id, $content_row_id, 
		$content_id) 
	{
		$sql = 'SELECT uspci.id, uspcii.version_id, uspcii.expand, 
					uspcii.caption 
				FROM user_site_page_content_item_image uspcii 
				JOIN user_site_page_content_item uspci 
					ON uspcii.content_id = uspci.id 
					AND uspci.site_id = :site_id 
					AND uspci.page_id = :page_id 
					AND uspci.content_row_id = :content_row_id 
				JOIN user_site_page_content_rows uspcr 
					ON uspci.content_row_id = uspcr.id 
					AND uspcr.site_id = :site_id 
					AND uspcr.page_id = :page_id 
					AND uspcr.div_id = :div_id 
				WHERE uspcii.site_id = :site_id 
				AND uspcii.page_id = :page_id 
				AND uspcii.content_id = :content_id
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetch();
	}
}