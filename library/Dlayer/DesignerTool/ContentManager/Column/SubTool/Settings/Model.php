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
     * @param integer $id Column id
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

    /**
     * Update the base width for the default layout
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id Column id
     * @param integer $width New width
     * @return boolean
     */
    public function updateWidth($site_id, $page_id, $id, $width)
    {
        $sql = "UPDATE 
                    `user_site_page_structure_column` 
                SET 
                    `size` = :width 
                WHERE 
                    `site_id` = :site_id AND 
                    `page_id` = :page_id AND 
                    `id` = :column_id 
                LIMIT 
                    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id);
        $stmt->bindValue(':page_id', $page_id);
        $stmt->bindValue(':column_id', $id);
        $stmt->bindValue(':width', $width);

        return $stmt->execute();
    }

    /**
     * Update the offset for a column
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id Column id
     * @param integer $offset New offset
     * @return boolean
     */
    public function updateOffset($site_id, $page_id, $id, $offset)
    {
        $sql = "UPDATE 
                    `user_site_page_structure_column` 
                SET 
                    `offset` = :offset 
                WHERE 
                    `site_id` = :site_id AND 
                    `page_id` = :page_id AND 
                    `id` = :column_id 
                LIMIT 
                    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id);
        $stmt->bindValue(':page_id', $page_id);
        $stmt->bindValue(':column_id', $id);
        $stmt->bindValue(':offset', $offset);

        return $stmt->execute();
    }
}
