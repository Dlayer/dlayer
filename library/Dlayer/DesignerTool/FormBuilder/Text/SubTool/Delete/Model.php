<?php

/**
 * Data model for the text element styling sub tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_Text_SubTool_Delete_Model extends Zend_Db_Table_Abstract
{
    /**
     * Set deleted flag
     *
     * @param integer $site_id
     * @param integer $form_id
     * @param integer $id Field id
     *
     * @return boolean
     */
    public function setDeleted($site_id, $form_id, $id)
    {
        $sql = "UPDATE 
                    `user_site_form_field` 
                SET 
                    `deleted` = 1, 
                    `sort_order` = 0 
                WHERE 
                    `site_id` = :site_id AND 
                    `form_id` = :form_id AND 
                    `id` = :field_id 
                LIMIT 
                    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id);
        $stmt->bindValue(':form_id', $form_id);
        $stmt->bindValue(':field_id', $id);

        return $stmt->execute();
    }

    /**
     * Re-order form fields
     *
     * @param integer $site_id
     * @param integer $form_id
     * @return boolean
     */
    public function reorderFields($site_id, $form_id)
    {
        $remaining_fields = $this->enabledFieldIdsInOrder($site_id, $form_id);

        $x = 1;
        foreach ($remaining_fields as $field_id) {
            $this->setFieldSortOrder($site_id, $form_id, $field_id, $x);
            $x++;
        }
    }

    /**
     * Fetch the ids of the form fields in order that aren't deleted
     *
     * @param integer $site_id
     * @param integer $form_id
     * @return array
     */
    private function enabledFieldIdsInOrder($site_id, $form_id)
    {
        $sql = "SELECT 
                    `id` 
                FROM 
                    `user_site_form_field` 
                WHERE 
                    `deleted` = 0 AND 
                    `form_id` = :form_id AND 
                    `site_id` = :site_id 
                ORDER BY 
                    `site_id` ASC";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->execute();

        $fields = array();

        foreach ($stmt->fetchAll() as $row) {
            $fields[] = intval($row['id']);
        }

        return $fields;
    }

    /**
     * Set the sort order for a field
     *
     * @param integer $site_id
     * @param integer $form_id
     * @param integer $id
     * @param integer $sort_order
     * @return boolean
     */
    private function setFieldSortOrder($site_id, $form_id, $id, $sort_order)
    {
        $sql = "UPDATE 
                    `user_site_form_field` 
                SET 
                    `sort_order` = :sort_order 
                WHERE 
                    `site_id` = :site_id AND 
                    `form_id` = :form_id AND 
                    `id` = :field_id 
                LIMIT 
                    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
        $stmt->bindValue(':field_id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);

        return  $stmt->execute();
    }
}
