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
        return 'SET FOREIGN_KEY_CHECKS = :value;';
    }
}
