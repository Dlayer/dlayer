<?php
/**
* Checks the session to validate a site id, needs to be set and exist in the 
* database. If tthe site id is for some reason not valid the user is returned 
* back to the home page
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
* @version $Id: ValidateSiteId.php 1240 2013-11-14 16:27:15Z Dean.Blackborough $
*/
class Dlayer_Action_ValidateSiteId extends 
Zend_Controller_Action_Helper_Abstract
{
	/**
	* Checks the session to validate a site id, needs to be set and exist in 
	* the database. If tthe site id is for some reason not valid the user is 
	* returned back to the home page
	* 
	* @return void
	*/
	function direct() 
	{
		$valid = FALSE;
		
		$session_dlayer = new Dlayer_Session();
		
		if($session_dlayer->siteId() != NULL) {
			$model_sites = new Dlayer_Model_Site();
			if($model_sites->valid($session_dlayer->siteId(), 
			$session_dlayer->identityId()) == TRUE) {
				$valid = TRUE;
			}
		}
		
		if($valid == FALSE) {
			$this->_actionController->getHelper('Redirector')->gotoUrl(
			'/dlayer/index/home');
		}		
	}
}