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
     * Modules list, pull the module details for the application home page
     *
     * @param boolean $enabled Return only enabled modules
     * @return array  Array of modules which match the requested status
     */
    public function byStatus($enabled = true)
    {
        $sql = "SELECT `name`, title, description
                FROM dlayer_module
                WHERE enabled = :enabled 
                AND `name` <> 'dlayer' 
                ORDER BY sort_order ASC";
        $stmt = $this->_db->prepare($sql);
        if ($enabled == true) {
            $stmt->bindValue(':enabled', 1, PDO::PARAM_INT);
        } else {
            $stmt->bindValue(':enabled', 0, PDO::PARAM_INT);
        }
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
