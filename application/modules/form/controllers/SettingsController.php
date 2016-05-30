<?php
/**
* Settings
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Form_SettingsController extends Zend_Controller_Action
{
	/**
	* Type hinting for action helpers, hints the property to the code
	* hinting class which exists in the library
	*
	* @var Dlayer_Action_CodeHinting
	*/
	protected $_helper;

	private $session_dlayer;

	/**
	 * @var array Nav bar items
	 */
	private $nav_bar_items = array(
		array('uri'=>'/dlayer/index/home', 'name'=>'Dlayer Demo', 'title'=>'Dlayer.com: Web development simplified'),
		array('uri'=>'/form/index/index','name'=>'Form builder', 'title'=>'Form builder'),
		array('uri'=>'/form/settings/index','name'=>'Settings', 'title'=>'Settings'),
		array('uri'=>'http://www.dlayer.com/docs/', 'name'=>'Dlayer Docs', 'title'=>'Read the Docs for Dlayer'),
	);

	/**
	* Init the controller, run any set up code required by all the actions
	* in the controller
	*
	* @return void
	*/
	public function init()
	{
		$this->_helper->authenticate();

		$this->_helper->setModule();

		$this->_helper->validateSiteId();

		$this->session_dlayer = new Dlayer_Session();
	}

	/**
	* Settings action, settings for the module
	*
	* @return void
	*/
	public function indexAction()
	{
		$model_sites = new Dlayer_Model_Site();

		$this->view->site = $model_sites->site($this->session_dlayer->siteId());

		$this->_helper->setLayoutProperties($this->nav_bar_items, '/form/settings/index', array('css/dlayer.css'),
			array(), 'Settings - Form builder');
	}

	/**
	* Set the base content font family
	*
	* @return void
	*/
	public function baseFontFamilyAction()
	{		
		// Validate and save posted form 
		$model_settings_form = new Dlayer_Model_Settings_Form();
		
		$base_font_family = $model_settings_form->baseFontFamily(
			$this->session_dlayer->siteId());
		
		$form = new Dlayer_Form_Settings_Form_BaseFont($base_font_family['id']);
		
		if($this->getRequest()->isPost()) 
		{
			$post = $this->getRequest()->getPost();

			if($form->isValid($post)) 
			{
				$model_settings_form->updateFontFamily(
					$this->session_dlayer->siteId(), $post['font_family']);
				$this->redirect('/form/settings/base-font-family');
			}
		}
		
		// Display page
		$model_sites = new Dlayer_Model_Site();
		$model_settings = new Dlayer_Model_Settings();

		$font_families = $model_settings->fontFamilies();

		$this->view->form = $form;
		$this->view->font_families = $font_families;
		$this->view->base_font_family = $base_font_family;
		$this->view->site = $model_sites->site($this->session_dlayer->siteId());

		$this->_helper->setLayoutProperties($this->nav_bar_items, '/form/settings/index', array('css/dlayer.css'),
			array('scripts/dlayer.js'), 'Settings - Form builder: Base font family');
	}
}
