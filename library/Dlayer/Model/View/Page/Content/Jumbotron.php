<?php

/**
 * Data model for 'jumbotron' based content items
 *
 * @category View model: These models are used to generate the data in the designers, the user data and later the web site
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Model_View_Page_Content_Jumbotron extends Zend_Db_Table_Abstract
{
    /**
     * Fetch the core data needed to create a 'jumbotron' based content item
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id Id of the content item
     *
     * @return array|false Either the content item data array or FALSE upon error
     */
    public function data($site_id, $page_id, $id)
    {
        $sql = "SELECT 
                    `uspcij`.`content_id`, 
                    `uscj`.`content`, 
                    `uspcij`.`button_label` 
				FROM 
				    `user_site_page_content_item_jumbotron` `uspcij` 
				INNER JOIN 
				    `user_site_content_jumbotron` `uscj` ON 
				        `uspcij`.`data_id` = uscj.id AND 
				        `uscj`.`site_id` = :site_id 
				WHERE 
				    `uspcij`.`content_id` = :content_id	AND 
				    `uspcij`.`site_id` = :site_id AND 
				    `uspcij`.`page_id` = :page_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();

        $bits = explode('-:-', $result['content']);

        $result['title'] = $bits[0];
        $result['sub_title'] = $bits[1];

        return $result;
    }
}
