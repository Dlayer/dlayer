<?php
/**
* Image content item model, all the model methods for adding and editing 
* an image content item
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
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
	
	/**
	* Fetch the data for the currently selcted image
	* 
	* @param integer $site_id 
	* @param integer $page_id 
	* @param integer $content_id 
	* @return array|FALSE
	*/
	public function selectedImage($site_id, $page_id, $content_id) 
	{
		$sql = 'SELECT usilv.library_id AS image_id, usilvm.version_id, 
				usil.`name`, usilvm.width, usilvm.height, usilvm.size, 
				usilvm.extension, usil.category_id, usil.sub_category_id 
				FROM user_site_page_content_item_image uspcii 
				JOIN user_site_image_library_version usilv
					ON uspcii.version_id = usilv.id  
					AND usilv.site_id = :site_id 
				JOIN user_site_image_library usil 
					ON usilv.library_id = usil.id 
					AND usil.site_id = :site_id 
				JOIN user_site_image_library_version_meta usilvm 
					ON usilv.id = usilvm.version_id 
					AND usilv.library_id = usilvm.library_id 
					AND usilvm.site_id = :site_id 
				WHERE uspcii.site_id = :site_id 
				AND uspcii.page_id = :page_id  
				AND uspcii.content_id = :content_id';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			
			$result['size'] = Dlayer_Helper::readableFilesize($result['size']);
			$result['dimensions'] = $result['width'] . ' x ' . 
				$result['height'] . ' pixels';
			return $result;
		} else {
			return FALSE;
		}
	}
	
	/**
	* Fetch the data for the image defined in the designer session
	* 
	* @param integer $site_id 
	* @param integer $image_id 
	* @param integer $version_id 
	* @return array|FALSE Either returns an array containing the image name 
	* 	name of FALSE if the image cannot be selected
	*/
	public function sessionImage($site_id, $image_id, $version_id) 
	{
		$sql = 'SELECT usil.`name`, usilvm.width, usilvm.height, usilvm.size, 
				usilvm.extension 
				FROM user_site_image_library_version usilv 
				JOIN user_site_image_library usil 
					ON usilv.library_id = usil.id 
					AND usil.id = :image_id 
					AND usil.site_id = :site_id 
				JOIN user_site_image_library_version_meta usilvm 
					ON usilv.id = usilvm.version_id 
					AND usilvm.library_id = :image_id 
					AND usilvm.site_id = :site_id 
				WHERE usilv.id = :version_id 
				AND usilv.library_id = :image_id 
				AND usilv.site_id = :site_id';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':image_id', $image_id, PDO::PARAM_INT);
		$stmt->bindValue(':version_id', $version_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			
			$result['size'] = Dlayer_Helper::readableFilesize($result['size']);
			$result['dimensions'] = $result['width'] . ' x ' . 
				$result['height'] . ' pixels';
			return $result;
		} else {
			return FALSE;
		}
	}
}