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

	private $layout;

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

		// Include js and css files in layout
		$this->layout = Zend_Layout::getMvcInstance();
		$this->layout->assign('js_include', array('scripts/dlayer.js'));
		$this->layout->assign('css_include', array('styles/forms.css', 
			'styles/settings.css', 'styles/settings/content.css'));
	}

	/**
	* Base settings page for the content manager settings
	* 
	* @return void
	*/
	public function indexAction()
	{
		$model_sites = new Dlayer_Model_Site();

		$this->navBar('/dlayer/settings/index');

		$this->view->site = $model_sites->site($this->session_dlayer->siteId());

		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - Content manager settings');
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

		$this->navBar('/dlayer/settings/index');

		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - Heading styles');
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

		$this->navBar('/dlayer/settings/index');

		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - Base font family - 
		Content manager');
	}

	/**
	* Assign the content for the nav bar
	* 
	* @param string $active_uri Uri
	* @return void Assigns values to the layout
	*/
	private function navBar($active_uri) 
	{
		$items = array(
			array('uri'=>'/dlayer/index/home', 'name'=>'Dlayer Demo', 
				'title'=>'Dlayer.com: Web development simplified'),
			array('uri'=>'/dlayer/settings/index', 
				'name'=>'Settings', 'title'=>'Settings'), 
			array('uri'=>'/dlayer/index/logout', 
				'name'=>'<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Sign out (' . 
				$this->session_dlayer->identity() . ')', 'title'=>'Sign out of demo')		
		);
		
		$this->layout->assign('nav', array(
			'class'=>'top_nav', 'items'=>$items, 'active_uri'=>$active_uri));		
	}

	/**
	* Generate the setting and section menus for settings
	*
	* @param string $group Settings group to fetch settings for
	* @param string $group_url Active setting group url
	* @param string $setting_url Active setting url
	* @return string Html
	*/
	private function settingsMenus($group, $group_url='', $setting_url='')
	{
		$model_settings = new Dlayer_Model_Settings();
		$setting_groups = $model_settings->settingGroups();

		$settings = $model_settings->settings($group);

		$this->view->setting_groups = array('class'=>'setting_groups', 
			'items'=>$setting_groups, 'active_url'=>$group_url);

		$this->view->settings = array('class'=>'settings', 
			'items'=>$settings, 'active_url'=>$setting_url);
	}
}