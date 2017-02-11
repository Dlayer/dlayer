<?php

/**
 * Data model for the delete sub tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Shared_Model_Delete extends Zend_Db_Table_Abstract
{
    /**
     * Set the deleted flag
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $column_id
     * @param integer $id Content item id
     * @return boolean
     */
    public function setDeleted($site_id, $page_id, $column_id, $id)
    {
        $sql = "UPDATE 
                    `user_site_page_structure_content` 
                SET 
                    `deleted` = 1 
                WHERE 
                    `site_id` = :site_id AND 
                    `page_id` = :page_id AND 
                    `column_id` = :column_id AND 
                    `id` = :content_id 
                LIMIT 
                    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':column_id', $column_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Re-order remaining content items
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $column_id
     * @return boolean
     */
    public function reorderColumnContent($site_id, $page_id, $column_id)
    {
        $remaining_content = $this->enabledContentIdsInOrder($site_id, $page_id, $column_id);

        $x = 1;
        foreach ($remaining_content as $id) {
            $this->setContentSortOrder($site_id, $page_id, $column_id, $id, $x);
            $x++;
        }
    }

    /**
     * Fetch the ids of the content items in order that haven't been deleted
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $column_id
     * @return array
     */
    private function enabledContentIdsInOrder($site_id, $page_id, $column_id)
    {
        $sql = "SELECT 
                    `id` 
                FROM 
                    `user_site_page_structure_content` 
                WHERE 
                    `deleted` = 0 AND 
                    `site_id` = :site_id AND 
                    `page_id` = :page_id AND 
                    `column_id` = :column_id 
                ORDER BY 
                    `sort_order` ASC";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':column_id', $column_id, PDO::PARAM_INT);
        $stmt->execute();

        $content = array();

        foreach ($stmt->fetchAll() as $row) {
            $content[] = intval($row['id']);
        }

        return $content;
    }

    /**
     * Set the new sort order for the content item
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $column_id
     * @param integer $id
     * @param integer $sort_order
     * @return boolean
     */
    private function setContentSortOrder($site_id, $page_id, $column_id, $id, $sort_order)
    {
        $sql = "UPDATE 
                    `user_site_page_structure_content` 
                SET 
                    `sort_order` = :sort_order 
                WHERE 
                    `site_id` = :site_id AND 
                    `page_id` = :page_id AND 
                    `column_id` = :column_id AND  
                    `id` = :content_id 
                LIMIT 
                    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':column_id', $column_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);

        return  $stmt->execute();
    }
}
