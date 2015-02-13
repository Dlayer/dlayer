<?php
/**
* Validate that a template id is set and valid, it also needs to belong to the 
* site id in the session. If for some reason the template id is not valid the 
* user will be returned to the home page
*
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Action_ValidateTemplateId extends 
Zend_Controller_Action_Helper_Abstract
{
	/**
	* Validate that a template id is set and valid, it also needs to belong to 
	* the site id in the session. If for some reason the template id is not 
	* valid the user will be returned to the home page
	* 
	* The helper is used by both the template designer and the content manager, 
	* the content param dictates which session class to use, template session 
	* or content session
	* 
	* @param boolean $content Should check use the content session, default to 
	*                         template session
	* @return void
	*/
	function direct($content=FALSE) 
	{
		$valid = FALSE;

		$session_dlayer = new Dlayer_Session();
		$site_id = $session_dlayer->siteId();

		if($content==FALSE) {
			$session_template = new Dlayer_Session_Template();
			$template_id = $session_template->templateId();
		} else {
			$session_content = new Dlayer_Session_Content();
			$template_id = $session_content->templateId();
		}

		if($site_id != NULL && $template_id != NULL) {
			$model_templates = new Dlayer_Model_Template();
			if($model_templates->valid($template_id, $site_id) == TRUE) {
				$valid = TRUE;
			}
		}

		if($valid == FALSE) {
			if($content == FALSE) {
				$this->_actionController->getHelper('Redirector')->gotoUrl(
					'/template');
			} else {
				$this->_actionController->getHelper('Redirector')->gotoUrl(
					'/content');
			}
		}		
	}
}