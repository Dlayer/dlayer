<?php
/**
* Authenticate the request
* 
* helper checks to see if an identity id exists in the session, as the system 
* evolves additional checks will be made, user level access etc
*
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Action_Authenticate extends Zend_Controller_Action_Helper_Abstract
{
	
	private $model_authentication;
	
    /**
    * Authenticate the request, checks that the user is logged in, there will 
    * be an identity id in the session
    *
    * @return void
    */
    function direct()
    {
    	$this->logoutInactive();
    	
    	$session_dlayer = new Dlayer_Session();
    	
    	if($session_dlayer->identityId() == FALSE) {
			$this->_actionController->getHelper('Redirector')->gotoUrl('/');
        } else {
			$this->model_authentication->updateLastActionTimestamp(
			$session_dlayer->identityId());
        }
    }
    
    /**
    * Log out any inactive account, use last action time to check
    * 
    * @return void
    */
    private function logoutInactive() 
    {
		$session = $this->_actionController->getInvokeArg(
		'bootstrap')->getOption('session');
        
        $this->model_authentication = new Dlayer_Model_Authentication();
        $this->model_authentication->logoutInactiveIdenties(
        $session['timeout']);
    }
}