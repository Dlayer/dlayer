<?php

/**
 * Data model for the alternate row styling tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_StylingAlternateRow_Model extends Zend_Db_Table_Abstract
{
    /**
     * Fetches the form field ids in order
     *
     * @param integer $site_id
     * @param integer $id
     *
     * @return array
     */
    public function fieldIdsInOrder($site_id, $id)
    {
        $sql = "SELECT 
                    `id` 
                FROM 
                    `user_site_form_field` 
                WHERE 
                    `site_id` = :site_id AND 
                    `form_id` = :form_id AND 
                    `deleted` = 0
                ORDER BY 
                    `sort_order` ASC";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Set the background color for a field row
     *
     * @param integer $site_id
     * @param integer $form_id
     * @param integer $id
     * @param string $hex
     *
     * @return boolean
     */
    public function setRowBackgroundColor($site_id, $form_id, $id, $hex)
    {
        $sql = "INSERT INTO `user_site_form_field_styling_row_background_color` 
                (
                    `site_id`,
                    `form_id`, 
                    `field_id`,
                    `background_color`
                )
                VALUES 
                (
                    :site_id, 
                    :form_id, 
                    :field_id, 
                    :hex
                )";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
        $stmt->bindValue(':field_id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':hex', $hex, PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * Clear any existing form row styling
     *
     * @param integer $site_id
     * @param integer $id
     *
     * @return boolean
     */
    public function clearAllFormRowBackgroundColors($site_id, $id)
    {
        $sql = "DELETE FROM 
                    `user_site_form_field_styling_row_background_color` 
                WHERE 
                    `site_id` = :site_id AND 
                    `form_id` = :form_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
