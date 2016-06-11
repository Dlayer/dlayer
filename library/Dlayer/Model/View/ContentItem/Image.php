<?php

/**
 * Data model for 'image' based content items
 *
 * @category View model: These models are used to generate the data in the designers, the user data and later the web site
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Model_View_ContentItem_Image extends Zend_Db_Table_Abstract
{
	/**
	 * Fetch the core data needed to create an 'image' based content item
	 *
	 * @param $site_id
	 * @param $page_id
	 * @param $id Id of the content item
	 * @return array|FALSE Either the content item data array or FALSE upon error
	 */
	private function baseItemData($site_id, $page_id, $id)
	{
		$sql = "SELECT uspcii.content_id, usilv.id AS version_id, usilv.library_id, usil.`name`, usilvm.extension,  
				uspcii.expand, uspcii.caption 
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
				WHERE uspcii.content_id = :content_id 
				AND uspcii.site_id = :site_id 
				AND uspcii.page_id = :page_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch();
	}

	/**
	 * Fetch the data needed to create a 'heading' based content item, this will include all the data that may have
	 * been defined by any sub tools
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $id Id of the content item
	 * @return array|FALSE Either the content item data or FALSE upon error
	 */
	public function data($site_id, $page_id, $id)
	{
		$content_item = $this->baseItemData($site_id, $page_id, $id);

		return $content_item;
	}
}
