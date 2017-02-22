<?php

/**
 * Data model for 'heading' based content items
 *
 * @category View model: These models are used to generate the data in the designers, the user data and later the web site
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Model_View_Page_Content_Heading extends Zend_Db_Table_Abstract
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
    public function data($site_id, $page_id, $id)
    {
        $sql = "SELECT 
                    `uspcih`.`content_id`, 
                    `usch`.`content`, 
                    `dch`.`tag`  
				FROM 
				    `user_site_page_content_item_heading` `uspcih` 
				INNER JOIN 
				    `user_site_content_heading` `usch` ON 
				        `uspcih`.`data_id` = `usch`.`id` AND 
				        `usch`.`site_id` = :site_id 
				INNER JOIN 
				    `designer_content_heading` `dch` ON 
				        `uspcih`.`heading_id` = `dch`.`id` 
				WHERE 
				    `uspcih`.`content_id` = :content_id AND 
				    `uspcih`.`site_id` = :site_id AND 
				    `uspcih`.`page_id` = :page_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result !== false) {
            $bits = explode('-:-', $result['content']);

            switch (count($bits)) {
                case 1:
                    $result['heading'] = $bits[0];
                    $result['sub_heading'] = '';
                    break;
                case 2:
                    $result['heading'] = $bits[0];
                    $result['sub_heading'] = $bits[1];
                    break;
                default:
                    $result['heading'] = $result['content'];
                    $result['sub_heading'] = '';
                    break;
            }
        }

        return $result;
    }
}
