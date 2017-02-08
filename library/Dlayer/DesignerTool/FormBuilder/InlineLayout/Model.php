<?php

/**
 * Data model for the inline layout tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_InlineLayout_Model extends Zend_Db_Table_Abstract
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
}
