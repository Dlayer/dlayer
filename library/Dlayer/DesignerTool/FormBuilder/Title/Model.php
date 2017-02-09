<?php

/**
 * Data model for the title tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_Title_Model extends Zend_Db_Table_Abstract
{
    /**
     * Set the titles
     *
     * @param integer $site_id
     * @param integer $form_id
     * @param string $title
     * @param string $subtitle
     *
     * @return boolean
     */
    public function updateTitles($site_id, $form_id, $title, $subtitle)
    {
        $sql = "UPDATE 
                    `user_site_form_layout` 
                SET 
                    `title` = :title, 
                    `sub_title` = :subtitle 
                WHERE 
                    `site_id` = :site_id AND 
                    `form_id` = :form_id 
                LIMIT 
                    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':subtitle', $subtitle, PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * Fetch the currently assigned titles
     *
     * @param integer $site_id
     * @param integer $form_id
     *
     * @return array|false
     */
    public function titles($site_id, $form_id)
    {
        $sql = "SELECT 
                    `title`, 
                    `sub_title` AS `subtitle` 
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
