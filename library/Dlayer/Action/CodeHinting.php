<?php
/**
* PHPed can't code hint for action helpers, they are dynamically invoked, in 
* the controllers we can phpDoc hint _helpers to this class and then create 
* methods for each of the view helpers, these methods will return the class 
* name of the helper class, the result being code complettion
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Action_CodeHinting extends Zend_Controller_Action_Helper_Abstract 
{
	/**
	* Set the layout file to use for the controller, typically in the case of 
	* Dlayer these will match the name of the module that the controller is in, 
	* pass in the file name without the extension, layout file must exist in 
	* /applications.views/layouts
	* 
	* @param string $layout Name of layout file, no extension
	* @return void
	*/
	function setLayout($layout) { } 
	
	/**
	* Turns off the layout for the controller, this will generally be called in 
	* AJAX and redirect actions, no point loading the layout if we aren't 
	* intending on using it, we can optionally disable the view script
	* 
	* @param boolean $view_script Render view script
	* @return void
	*/
	function disableLayout($view_script=TRUE) { } 
		
	/**
	* Simplify AJAX context switching based on requested format
	* 
	* @param  mixed   $data
	* @param  boolean $sendNow
	* @param  boolean $keepLayouts
	* @return Zend_Controller_Action_Helper_Json
	*/
	function json($data, $sendNow = true, $keepLayouts = false) { }
	
	/**
	* @var Zend_Controller_Action_Helper_ViewRenderer
	*/
	public $viewRenderer;
	
	/**
	* Set the module in the dlayer session. 
	* 
	* When setting the module we check to see if it exists and is enabled. If 
	* the module doesn't exist or isn't enabled the user is redirected to the 
	* base of the app
	*
	* @return Dlayer_Action_SetModule
	*/
	public function setModule() { } 
	
	/**
	* Checks the session to validate a site id, needs to be set and exist in 
	* the database. If tthe site id is for some reason not valid the user is 
	* returned back to the home page
	* 
	* @return Dlayer_Action_ValidateSiteId
	*/
	public function validateSiteId() { }
	
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
	* @return Dlayer_Action_ValidateTemplateId
	*/
	public function validateTemplateId($content=FALSE) { }
	
	/**
	* Validate that a form id is set and valid, it needs to belong to the 
	* site id in the session. If for some reason the form id is not valid the 
	* user will be returned to the home page
	* 
	* @return Dlayer_Action_ValidateFormId
	*/
	function validateFormId() { } 
	
	/**
	* Authenticate the request, checks that the user is logged in, there will 
	* be an identity id in the session
	*
	* @return void Redirects the user if identity id not set
	*/
	function authenticate() { }
}