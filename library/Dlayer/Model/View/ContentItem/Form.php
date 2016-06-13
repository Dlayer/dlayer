<?php

/**
 * Data model for 'form' based content items
 *
 * @category View model: These models are used to generate the data in the designers, the user data and later the web site
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Model_View_ContentItem_Form extends Zend_Db_Table_Abstract
{
	/**
	 * Fetch the core data needed to create a 'heading' based content item
	 *
	 * @param $site_id
	 * @param $page_id
	 * @param $id Id of the content item
	 * @return array|FALSE Either the content item data array or FALSE upon error
	 */
	private function baseItemData($site_id, $page_id, $id)
	{
		$sql = "SELECT uspcif.content_id, uspcif.form_id 
				FROM user_site_page_content_item_form uspcif  
				WHERE uspcif.content_id = :content_id  
				AND uspcif.site_id = :site_id 
				AND uspcif.page_id = :page_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch();
	}

	/**
	 * Fetch the data needed to create a 'form' based content item, this will include all the data that may have
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

	/**
	 * Fetch the title values for the form
	 *
	 * @return array|FALSE
	 */
	private function titles($site_id, $form_id)
	{
		$model_layout = new Dlayer_Model_View_Form_Layout();

		$titles = $model_layout->titles($site_id, $form_id);

		if($titles != FALSE)
		{
			return array(
				'show' => TRUE,
				'title' => $titles['title'],
				'sub_title' => $titles['sub_title'],
			);
		}
		else
		{
			return array('show' => FALSE);
		}
	}
}
