<?php

/**
 * Data model for the text content item
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_Text_Model extends Zend_Db_Table_Abstract
{
    /**
     * Fetch the existing field data
     *
     * @param integer $site_id
     * @param integer $form_id
     * @param integer $id
     * @return array|FALSE The data array for the field or false upon failure
     */
    public function fieldData($site_id, $form_id, $id)
    {
        $sql = "SELECT 
                    `usff`.`id`, 
                    `dffa`.`attribute`, 
                    `usffa`.`attribute` AS `value`, 
                    `dfft`.`type`, 
                    `dffat`.`type` AS `attribute_type` 
                FROM 
                    `user_site_form_field_attribute` `usffa`
                INNER JOIN 
                    `designer_form_field_attribute` `dffa` ON 
                        `usffa`.`attribute_id` = `dffa`.`id` 
                INNER JOIN 
                    `user_site_form_field` `usff` ON 
                        `usffa`.`field_id` = `usff`.`id` AND 
                        `usff`.`site_id` = :site_id AND 
                        `usff`.`form_id` = :form_id 
                INNER JOIN 
                    `designer_form_field_attribute_type` `dffat` ON 
                        `dffa`.`attribute_type_id` = `dffat`.`id` 
                INNER JOIN 
                    `designer_form_field_type` `dfft` ON 
                        `usff`.`field_type_id` = `dfft`.`id` 
                WHERE 
                    `usffa`.`site_id` = :site_id AND 
                    `usffa`.`form_id` = :form_id AND 
                    `usffa`.`field_id` = :field_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
        $stmt->bindValue(':field_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }
}
