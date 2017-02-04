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
}
