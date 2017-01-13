<?php
/**
 * Import model
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Setup_Model_Import extends Zend_Db_Table_Abstract
{
    /**
     * Set foreign key checks value
     *
     * @param integer $value
     * @return string
     */
    public function setForeignKeyChecks($value)
    {
        return 'SET FOREIGN_KEY_CHECKS = :value;' . PHP_EOL;
    }

    /**
     * Execute queries
     *
     * @param string $query
     * @param boolean $foreign_keys Modify SET_FOREIGN_KEYS
     * @return boolean
     */
    public function executeQuery($query, $foreign_keys = false)
    {
        if ($foreign_keys === true) {
            $sql = $this->setForeignKeyChecks(0);
            $sql .= $query . PHP_EOL;
            $sql .= $this->setForeignKeyChecks(1);
        } else {
            $sql = $query;
        }

        $stmt = $this->_db->prepare($sql);
        return $stmt->execute();
    }
}
