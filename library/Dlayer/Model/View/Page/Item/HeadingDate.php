<?php

/**
 * Data model for 'heading-date' based content items
 *
 * @category View model: These models are used to generate the data in the designers, the user data and later the web
 *     site
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Model_View_Page_Item_HeadingDate extends Zend_Db_Table_Abstract
{
    /**
     * Fetch the core data needed to create a 'heading' based content item
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id Id of the content item
     *
     * @return array|false Either the content item data array or FALSE upon error
     */
    private function baseItemData($site_id, $page_id, $id)
    {
        $sql = "SELECT 
                    `uspcihd`.`content_id`, 
                    `uspcihd`.`format`,
                    `uschd`.`content`, 
                    `dch`.`tag`  
				FROM 
				    `user_site_page_content_item_heading_date` `uspcihd` 
				INNER JOIN 
				    `user_site_content_heading_date` `uschd` ON 
				        `uspcihd`.`data_id` = `uschd`.`id` AND 
				        `uschd`.`site_id` = :site_id 
				INNER JOIN 
				    `designer_content_heading` `dch` ON 
				        `uspcihd`.`heading_id` = `dch`.`id`
				WHERE 
				    `uspcihd`.`content_id` = :content_id AND 
				    `uspcihd`.`site_id` = :site_id AND 
				    `uspcihd`.`page_id` = :page_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result !== false) {
            $bits = explode('-:-', $result['content']);
            $result['heading'] = $bits[0];
            $result['date'] = date($result['format'], strtotime($bits['1']));
        }

        return $result;
    }

    /**
     * Fetch the data needed to create a 'heading-date' based content item, this will include all the data that may
     * have been defined by any sub tools
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id Id of the content item
     *
     * @return array|false Either the content item data or false upon error
     */
    public function data($site_id, $page_id, $id)
    {
        $content_item = $this->baseItemData($site_id, $page_id, $id);

        return $content_item;
    }
}
