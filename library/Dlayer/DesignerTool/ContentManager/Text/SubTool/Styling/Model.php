<?php

/**
 * Data model for the styling sub tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Text_SubTool_Styling_Model extends Zend_Db_Table_Abstract
{
    /**
     * Fetch the background color for a content item
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $content_id
     *
     * @return string|false
     */
    public function contentBackgroundColor($site_id, $page_id, $content_id)
    {
        $sql = 'SELECT background_color 
                FROM user_site_page_styling_content_item 
                WHERE site_id = :site_id 
                AND page_id = :page_id 
                AND content_id = :content_id 
                LIMIT 1';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id);
        $stmt->bindValue(':page_id', $page_id);
        $stmt->bindValue(':content_id', $content_id);
        $stmt->execute();

        $result = $stmt->fetch();
        if ($result !== false) {
            return $result['background_color'];
        } else {
            return false;
        }
    }
}
