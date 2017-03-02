<?php

/**
 * Data model for 'rich-text' content item
 *
 * @category View model: These models are used to generate the data in the designers, the user data and later the web site
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Model_View_Page_Content_RichText extends Zend_Db_Table_Abstract
{
    /**
     * Fetch the core data needed to create a 'html'snippet
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
                    `uspcirt`.`content_id`, 
                    `uscrt`.`content`  
				FROM 
				    `user_site_page_content_item_rich_text` `uspcirt` 
				INNER JOIN 
				    `user_site_content_richtext` `uscrt`	ON 
				        `uspcirt`.`data_id` = uscrt.id AND 
				        `uscrt`.`site_id` = :site_id 
				WHERE 
				    `uspcirt`.`content_id` = :content_id	AND 
				    `uspcirt`.`site_id` = :site_id AND 
				    `uspcirt`.`page_id` = :page_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result !== false) {
            $renderer = new \DBlackborough\Quill\Renderer\Html();

            if ($renderer->load($result['content']) === true) {
                $result['content'] = $renderer->render();
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
