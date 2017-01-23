<?php

/**
 * Validate the module, check that the module is active in the database, should be the first action helper called
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Action_ValidateModule extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * Check to see if the module exists in the database and is valid
     *
     * @return boolean
     */
    function direct()
    {
        return true;
    }
}
