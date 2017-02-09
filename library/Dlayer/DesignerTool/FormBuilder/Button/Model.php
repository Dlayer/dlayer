<?php

/**
 * Data model for the button tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_Button_Model extends Zend_Db_Table_Abstract
{
    /**
     * Set the labels for the buttons
     *
     * @param integer $site_id
     * @param integer $form_id
     * @param string $submit_label
     * @param string $reset_label
     *
     * @return boolean
     */
    public function updateLabels($site_id, $form_id, $submit_label, $reset_label)
    {
        $sql = "UPDATE 
                    `user_site_form_layout` 
                SET 
                    `submit_label` = :submit_label, 
                    `reset_label` = :reset_label 
                WHERE 
                    `site_id` = :site_id AND 
                    `form_id` = :form_id 
                LIMIT 
                    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
        $stmt->bindValue(':submit_label', $submit_label, PDO::PARAM_STR);
        $stmt->bindValue(':reset_label', $reset_label, PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * Fetch the currently assigned button labels
     *
     * @param integer $site_id
     * @param integer $form_id
     *
     * @return array|false
     */
    public function labels($site_id, $form_id)
    {
        $sql = "SELECT 
                    `submit_label`, 
                    `reset_label` 
                FROM 
                    `user_site_form_layout` 
                WHERE 
                    `site_id` = :site_id AND 
                    `form_id` = :form_id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }
}
