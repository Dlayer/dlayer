<?php

/**
 * Data model for the text element styling sub tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_Text_SubTool_Styling_Model extends Zend_Db_Table_Abstract
{
    /**
     * Fetch the existing row background color for a field row
     *
     * @param integer $site_id
     * @param integer $form_id
     * @param integer $id Field id
     *
     * @return string|false
     */
    public function rowBackgroundColor($site_id, $form_id, $id)
    {
        $sql = "SELECT 
                    `background_color` 
                FROM 
                    `user_site_form_field_styling_row_background_color`
                WHERE 
                    `site_id` = :site_id AND 
                    `form_id` = :form_id AND 
                    `field_id` = :field_id 
                LIMIT 
                    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id);
        $stmt->bindValue(':form_id', $form_id);
        $stmt->bindValue(':field_id', $id);
        $stmt->execute();

        $result = $stmt->fetch();
        if ($result !== false) {
            return $result['background_color'];
        } else {
            return false;
        }
    }

    /**
     * Check to see if there is an existing background color for a field row
     *
     * @param integer $site_id
     * @param integer $form_id
     * @param integer $id Field id
     *
     * @return integer|false
     */
    public function existingRowBackgroundColor($site_id, $form_id, $id)
    {
        $sql = "SELECT 
                    `id` 
                FROM 
                    `user_site_form_field_styling_row_background_color` 
                WHERE 
                    `site_id` = :site_id AND 
                    `form_id` = :form_id AND 
                    `field_id` = :field_id 
                LIMIT 
                    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id);
        $stmt->bindValue(':form_id', $form_id);
        $stmt->bindValue(':field_id', $id);
        $stmt->execute();

        $result = $stmt->fetch();
        if ($result !== false) {
            return intval($result['id']);
        } else {
            return false;
        }
    }

    /**
     * Add a row background color
     *
     * @param integer $site_id
     * @param integer $form_id
     * @param integer $id Field id
     * @param string $color_hex
     *
     * @return boolean
     */
    public function addRowBackgroundColor($site_id, $form_id, $id, $color_hex)
    {
        $sql = "INSERT INTO `user_site_form_field_styling_row_background_color` 
                (
                    `site_id`, 
                    `form_id`, 
                    `field_id`, 
                    `background_color`) 
                VALUES 
                (
                    :site_id, 
                    :form_id, 
                    :field_id, 
                    :background_color
                )";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id);
        $stmt->bindValue(':form_id', $form_id);
        $stmt->bindValue(':field_id', $id);
        $stmt->bindValue(':background_color', $color_hex);

        return $stmt->execute();
    }

    /**
     * Edit the row background color for a field row, optionally delete the existing value if the user is clearing the
     * value
     *
     * @param integer $id
     * @param string $color_hex
     *
     * @return boolean
     */
    public function editRowBackgroundColor($id, $color_hex)
    {
        if (strlen($color_hex) !== 0) {
            return $this->updateRowBackgroundColor($id, $color_hex);
        } else {
            return $this->deleteRowBackgroundColor($id);
        }
    }

    /**
     * Update background colour for a field row
     *
     * @param integer $id
     * @param string $color_hex
     *
     * @return boolean
     */
    protected function updateRowBackgroundColor($id, $color_hex)
    {
        $sql = "UPDATE 
                    `user_site_form_field_styling_row_background_color` 
                SET 
                    `background_color` = :background_color 
                WHERE 
                    `id` = :id 
                LIMIT 
                    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':background_color', $color_hex);

        return $stmt->execute();
    }

    /**
     * Remove a background color for a field row
     *
     * @param integer $id
     *
     * @return boolean
     */
    protected function deleteRowBackgroundColor($id)
    {
        $sql = "DELETE FROM `user_site_form_field_styling_row_background_color` 
                WHERE 
                    `id` = :id 
                LIMIT 
                    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }
}
