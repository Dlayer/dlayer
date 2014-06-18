<?php
/**
* Base class for the content item data model classes
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Item.php 1568 2014-02-14 14:59:50Z Dean.Blackborough $
*/
abstract class Dlayer_Model_Page_Content_Item extends Zend_Db_Table_Abstract
{
    /**
    * Add the data for the content item, definition for content item will have 
    * been added, this method adds the rleated data for the content item type
    * 
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $content_id
    * @param array $params Data for the content item
    * @return void
    */
    abstract public function addContentItemData($site_id, $page_id, 
    $content_id, array $params);
    
    /**
    * Edit the daata for the content item
    *
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $content_id
    * @param array $params Data for the content item
    * @return void
    */
    abstract public function editContentItemData($site_id, $page_id, 
    $content_id, array $params);
}