<?php

/**
 * Data model for 'form' based content items
 *
 * @category View model: These models are used to generate the data in the designers, the user data and later the web site
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Model_View_Page_Item_Form extends Zend_Db_Table_Abstract
{
    /**
     * Fetch the core data needed to create a 'heading' based content item
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id Id of the content item
     * @return array|FALSE Either the content item data array or FALSE upon error
     */
    private function baseItemData($site_id, $page_id, $id)
    {
        $sql = "SELECT 
                    `uspcif`.`content_id`, 
                    `uspcif`.`form_id`, 
                    `usfl`.`title`, 
                    `usfl`.`sub_title`
				FROM 
				    `user_site_page_content_item_form` `uspcif` 
                LEFT JOIN  
                    `user_site_form_layout` `usfl` ON
                        `uspcif`.`form_id` = `usfl`.id
				WHERE 
				    `uspcif`.`content_id` = :content_id AND 
				    `uspcif`.`site_id` = :site_id AND 
				    `uspcif`.`page_id` = :page_id";
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
}
