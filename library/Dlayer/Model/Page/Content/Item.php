<?php
/**
* Base class for the content item data model classes
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
abstract class Dlayer_Model_Page_Content_Item extends Zend_Db_Table_Abstract
{
	/** 
	* Add the data for a new content item
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @param integer $content_id
	* @param array $params The data for the new content item
	* @return void
	*/
	abstract public function addContentItemData($site_id, $page_id, $div_id, 
		$content_row_id, $content_id, array $params);
	
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
	abstract public function editContentItemData($site_id, $page_id, $div_id, 
		$content_row_id, $content_id, array $params);
}