<?php
/**
* Set the module in the dlayer session. 
* 
* When setting the module we check to see if it exists and is enabled. If the 
* module doesn't exist or isn't enabled the user is redirected to the base of 
* the app
*
* @author Dean Blackborough
* @copyright G3D Development Limited
* @version $Id: SetModule.php 1211 2013-11-10 14:54:33Z Dean.Blackborough $
*/
class Dlayer_Action_SetModule extends Zend_Controller_Action_Helper_Abstract
{
    /**
    * Set the module in the dlayer session. 
    * 
    * When setting the module we check to see if it exists and is enabled. If 
    * the module doesn't exist or isn't enabled the user is redirected to the 
    * base of the app
    *
    * @return void
    */
    function direct()
    {
        $request = Zend_Controller_Front::getInstance()->getRequest();

        $model_modules = new Dlayer_Model_Module();
        if($model_modules->valid($request->getModuleName()) == TRUE) {
			$session_dlayer = new Dlayer_Session();
            $session_dlayer->setModule($request->getModuleName());
        } else {
			$this->_actionController->getHelper('Redirector')->gotoUrl('/');
        }
    }
}