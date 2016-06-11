<?php

/**
 * Data model for 'text' based content items
 *
 * @category View model: These models are used to generate the data in the designers, the user data and later the web site
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Model_View_Content_Items_Text extends Zend_Db_Table_Abstract
{
	/**
	 * Fetch the core data needed to create a 'text' based content item
	 *
	 * @param $site_id
	 * @param $page_id
	 * @param $id Id of the content item
	 * @return array|FALSE Either the content item data array or FALSE upon error
	 */
	private function baseItemData($site_id, $page_id, $id)
	{
		$sql = 'SELECT uspcit.content_id, usct.content 
				FROM user_site_page_content_item_text uspcit 
				JOIN user_site_content_text usct ON uspcit.data_id = usct.id
					AND usct.site_id = :site_id 
				WHERE uspcit.content_id = :content_id 
				AND uspcit.site_id = :site_id  
				AND uspcit.page_id = :page_id';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch();
	}

	/**
	 * Fetch the data needed to create a 'text' based content item, this will include all the data that may have
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
