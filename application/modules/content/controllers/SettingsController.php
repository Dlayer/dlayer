<?php
/**
* Settings
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Content_SettingsController extends Zend_Controller_Action 
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
		array('uri'=>'/content/index/index', 'name'=>'Content manager', 'title'=>'Content manager'),
		array('uri'=>'/content/settings/index', 'name'=>'Settings', 'title'=>'Settings'),
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
	* Base settings page for the content manager settings
	* 
	* @return void
	*/
	public function indexAction()
	{
		$model_sites = new Dlayer_Model_Site();

		$this->view->site = $model_sites->site($this->session_dlayer->siteId());

		$this->_helper->setLayoutProperties($this->nav_bar_items, '/content/settings/index', array('css/dlayer.css'),
			array(), 'Settings - Content manager');
	}

	/**
	* Set the styles for the headings
	* 
	* @return void
	*/
	public function headingsAction()
	{
		$model_settings_content = new Dlayer_Model_Settings_Content();
		
		$heading_settings = $model_settings_content->headings(
			$this->session_dlayer->siteId());
		
		// Create the heading setting forms
		$heading_forms = array();

		foreach($heading_settings as $heading) {
			$heading_forms[$heading['id']] = 
			new Dlayer_Form_Settings_Content_Heading($heading);            
		}
		
		// Validate and save the posted data
		if($this->getRequest()->isPost()) {

			$post = $this->getRequest()->getPost();

			if(is_array($post) && array_key_exists('heading_id', $post) && 
			array_key_exists($post['heading_id'], $heading_forms)) {

				$form = $heading_forms[$post['heading_id']];

				if($form->isValid($post)) {
					$model_settings_content->updateHeadings(
						$this->session_dlayer->siteId(), $post);
					$this->_redirect('/content/settings/headings');
				}
			}
		}
		
		$model_sites = new Dlayer_Model_Site();
		$model_settings = new Dlayer_Model_Settings();		

		$heading_styles = array(
			'font_styles' => $model_settings->fontStyles(),
			'font_weights' => $model_settings->fontWeights(),
			'font_decorations' => $model_settings->fontDecorations()
		);

		// Assign content view vars
		$this->view->heading_settings = $heading_settings;
		$this->view->heading_forms = $heading_forms;
		$this->view->heading_styles = $heading_styles;
		$this->view->site = $model_sites->site($this->session_dlayer->siteId());

		$this->_helper->setLayoutProperties($this->nav_bar_items, '/content/settings/index', array('css/dlayer.css'),
			array('scripts/dlayer.js'), 'Settings - Content manager: Heading styles');
	}

	/**
	* Set the base content font family
	* 
	* @return void
	*/
	public function baseFontFamilyAction()
	{
		// Validate and save posted form 
		$model_settings_content = new Dlayer_Model_Settings_Content();
		
		$base_font_family = $model_settings_content->baseFontFamily(
			$this->session_dlayer->siteId());
		
		$form = new Dlayer_Form_Settings_Content_BaseFont(
			$base_font_family['id']);
		
		if($this->getRequest()->isPost()) {

			$post = $this->getRequest()->getPost();

			if($form->isValid($post)) {
				$model_settings_content->updateFontFamily(
					$this->session_dlayer->siteId(), $post['font_family']);
				$this->_redirect('/content/settings/base-font-family');
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

		$this->_helper->setLayoutProperties($this->nav_bar_items, '/content/settings/index', array('css/dlayer.css'),
			array('scripts/dlayer.js'), 'Settings - Content manager: Base font family');
	}
}
