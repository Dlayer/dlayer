<?php
/**
* Validate that a form id is set and valid, it needs to belong to the 
* site id in the session. If for some reason the form id is not valid the user 
* will be returned to the home page
*
* @author Dean Blackborough
* @copyright G3D Development Limited
* @version $Id: ValidateFormId.php 1211 2013-11-10 14:54:33Z Dean.Blackborough $
*/
class Dlayer_Action_ValidateFormId extends 
Zend_Controller_Action_Helper_Abstract
{
	/**
	* Validate that a form id is set and valid, it needs to belong to the 
	* site id in the session. If for some reason the form id is not valid the 
	* user will be returned to the home page
	* 
	* @return void
	*/
	function direct() 
	{
		$valid = FALSE;
		
		$session_dlayer = new Dlayer_Session();
		$session_form = new Dlayer_Session_Form();
		
		$site_id = $session_dlayer->siteId();
		$form_id = $session_form->formId();
		
		if($site_id != NULL && $form_id != NULL) {
			$model_forms = new Dlayer_Model_Form();
			if($model_forms->valid($form_id, $site_id) == TRUE) {
				$valid = TRUE;
			}
		}
		
		if($valid == FALSE) {
			$this->_actionController->getHelper('Redirector')->gotoUrl(
			'/form');
		}		
	}
}