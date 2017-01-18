<?php

/**
 * Data model for the settings sub tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Column_SubTool_Settings_Model extends Zend_Db_Table_Abstract
{
    /**
     * Fetch the current properties for the default column width
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id
     *
     * @return string|false
     */
    public function widthProperties($site_id, $page_id, $id)
    {
        $sql = "SELECT 
                    `size` AS `width`, 
                    `offset`, 
                    `column_type` 
                FROM 
                    `user_site_page_structure_column` 
                WHERE 
                    `site_id` = :site_id AND  
                    `page_id` = :page_id AND 
                    `id` = :column_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id);
        $stmt->bindValue(':page_id', $page_id);
        $stmt->bindValue(':column_id', $id);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result !== false) {
            return array(
                'width' => intval($result['width']),
                'offset' => intval($result['offset']),
                'column_type' => $result['column_type']
            );
        } else {
            return false;
        }
    }
}
