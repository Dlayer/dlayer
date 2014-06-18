<?php
/**
* Validate that a conettn id is set and valid, it needs to belong to the 
* site id in the session. If for some reason the content id is not valid the 
* user will be returned to the home page
*
* @author Dean Blackborough
* @copyright G3D Development Limited
* @version $Id: ValidateContentId.php 1211 2013-11-10 14:54:33Z Dean.Blackborough $
*/
class Dlayer_Action_ValidateContentId extends 
Zend_Controller_Action_Helper_Abstract
{
	/**
	* Validate that a content id is set and valid, it needs to belong to the 
	* site id in the session. If for some reason the content id is not valid 
	* the user will be returned to the home page
	* 
	* @return void
	*/
	function direct() 
	{
		$valid = FALSE;
		
		$session_dlayer = new Dlayer_Session();
		$session_content = new Dlayer_Session_Content();
		
		$site_id = $session_dlayer->siteId();
		$page_id = $session_content->pageId();
		
		if($site_id != NULL && $page_id != NULL) {
			$model_page = new Dlayer_Model_Page();
			if($model_page->valid($page_id, $site_id) == TRUE) {
				$valid = TRUE;
			}
		}
		
		if($valid == FALSE) {
			$this->_actionController->getHelper('Redirector')->gotoUrl(
			'/content');
		}		
	}
}