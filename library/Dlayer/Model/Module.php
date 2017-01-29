<?php

/**
 * Dlayer modules
 *
 * There are many modules to Dlayer, a module is only accessible when it is
 * enabled, designer tools are defined per module.
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 * @category Model
 */
class Dlayer_Model_Module extends Zend_Db_Table_Abstract
{
    /**
     * Check to see if the module exists and is valid
     *
     * @param string $module Module names to check exists
     * @param boolean $enabled Does to the module need to be enabled?
     * @return boolean
     */
    public function valid($module, $enabled = true)
    {
        $sql = "SELECT 
                    `id` 
				FROM 
				    `dlayer_module` 
				WHERE 
				    `name` = :name AND 
				    `enabled` = :enabled 
				LIMIT 
				    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':name', $module, PDO::PARAM_STR);
        if ($enabled === true) {
            $stmt->bindValue(':enabled', 1, PDO::PARAM_INT);
        } else {
            $stmt->bindValue(':enabled', 0, PDO::PARAM_INT);
        }
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Active items
     *
     * @param integer $site_id
     *
     * @return array|false
     */
    public function activeItems($site_id)
    {
        $sql = "SELECT 
                (
                    SELECT 
                        COUNT(`user_site_page`.`id`) 
                    FROM 
                        `user_site_page` 
                    WHERE 
                        `user_site_page`.`site_id` = 1
                ) AS `pages`, 
                (
                    SELECT 
                        COUNT(`user_site_form`.`id`) 
                    FROM 
                        `user_site_form` 
                    WHERE 
                        `user_site_form`.`site_id` = 1
                ) AS `forms`";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result !== false) {
            return $result;
        } else {
            return false;
        }
    }
}
