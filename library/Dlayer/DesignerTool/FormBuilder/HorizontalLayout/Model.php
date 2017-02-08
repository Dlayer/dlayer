<?php

/**
 * Data model for the horizontal layout tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_HorizontalLayout_Model extends Zend_Db_Table_Abstract
{
    /**
     * Fetch the id for the inline value option
     *
     * @param string $layout
     * @return integer|false
     */
    public function layoutId($layout)
    {
        $sql = "SELECT 
                    `id`  
                FROM 
                    `designer_form_layout`
                WHERE 
                    `class` = :layout";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':layout', $layout, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result !== false) {
            return intval($result['id']);
        } else {
            return false;
        }
    }

    /**
     * Check layout id is valid
     *
     * @param integer $id
     * @return boolean
     */
    public function validId($id)
    {
        $sql = "SELECT 
                    `id`
                FROM 
                    `designer_form_layout` 
                WHERE 
                    `id`= :layout_id 
                LIMIT 
                    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':layout_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->fetch() !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set the layout id
     *
     * @param integer $site_id
     * @param integer $form_id
     * @param integer $id
     * @param integer $label_width
     * @param integer $element_width
     *
     * @return boolean
     */
    public function setLayout($site_id, $form_id, $id, $label_width, $element_width)
    {
        $sql = "UPDATE 
                    `user_site_form_layout` 
                SET 
                    `layout_id` = :layout_id, 
                    `horizontal_width_label` = :label_width,
                    `horizontal_width_field` = :label_element
                WHERE 
                    `site_id` = :site_id AND 
                    `form_id` = :form_id 
                LIMIT 
                    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
        $stmt->bindValue(':layout_id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':label_width', $label_width, PDO::PARAM_INT);
        $stmt->bindValue(':label_element', $element_width, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
