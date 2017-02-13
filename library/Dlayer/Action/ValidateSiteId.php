<?php

/**
 * Validate the site id
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Action_ValidateSiteId extends
    Zend_Controller_Action_Helper_Abstract
{
    /**
     * Checks the session to validate the currently stored site id, it needs to be set, exist in the database and
     * belong to the currently logged in user. On error the user is redirected back to the home page
     *
     * @return void
     */
    function direct()
    {
        $valid = false;

        $session_dlayer = new Dlayer_Session();

        if ($session_dlayer->siteId() != null) {
            $model = new Dlayer_Model_Admin_Site();
            if ($model->valid($session_dlayer->siteId(), $session_dlayer->identityId()) === true) {
                $valid = true;
            }
        }

        if ($valid == false) {
            $this->_actionController->getHelper('Redirector')->gotoUrl(
                '/dlayer/index/home');
        }
    }
}
