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
	function setLayout($layout)
	{
	}

	/**
	 * Turns off the layout for the controller, this will generally be called in
	 * AJAX and redirect actions, no point loading the layout if we aren't
	 * intending on using it, we can optionally disable the view script
	 *
	 * @param boolean $view_script Render view script
	 * @return void
	 */
	function disableLayout($view_script = TRUE)
	{
	}

	/**
	 * Simplify AJAX context switching based on requested format
	 *
	 * @param  mixed $data
	 * @param  boolean $sendNow
	 * @param  boolean $keepLayouts
	 * @return Zend_Controller_Action_Helper_Json
	 */
	function json($data, $sendNow = TRUE, $keepLayouts = FALSE)
	{
	}

	/**
	 * @var Zend_Controller_Action_Helper_ViewRenderer
	 */
	public $viewRenderer;

	/**
	 * Checks the session to validate a site id, needs to be set and exist in
	 * the database. If tthe site id is for some reason not valid the user is
	 * returned back to the home page
	 *
	 * @return Dlayer_Action_ValidateSiteId
	 */
	public function validateSiteId()
	{
	}

    /**
     * Validate the module, check that the module is active in the database, should be the first action helper called
     *
     * @return Dlayer_Action_ValidateModule
     */
    public function validateModule()
    {
    }

	/**
	 * Authenticate the request, checks that the user is logged in, there will
	 * be an identity id in the session
	 *
	 * @return void Redirects the user if identity id not set
	 */
	public function authenticate()
	{
	}

	/**
	 * Pass in the values which need to be passed to the layout
	 *
	 * @param array $nav_bar_items
	 * @param string $active_nav_bar_uri
	 * @param array $css_includes
	 * @param array $js_includes
	 * @param string $title
	 * @param string $preview_uri
	 * @param boolean $signed_in Is the user signed in to app?
	 * @return Dlayer_Action_SetLayoutProperties
	 */
	public function setLayoutProperties(array $nav_bar_items, $active_nav_bar_uri, array $css_includes,
		array $js_includes, $title, $preview_uri = '', $signed_in = TRUE)
	{
	}

    /**
     * Pass the control bar options to the layout
     *
     * @param array $buttons Buttons for control bar
     * @param array $dropdowns Drop down data array for control bar
     * @return Dlayer_Action_PopulateControlBar
     */
    public function populateControlBar(array $buttons, array $dropdowns)
    {
    }
}
