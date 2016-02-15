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
			'styles/settings.css', 'styles/settings/form.css'));
	}

	/**
	* Settings action, settings for the module
	*
	* @return void
	*/
	public function indexAction()
	{
		$model_sites = new Dlayer_Model_Site();
		
		$this->navBar('/dlayer/settings/index');
		
		$this->view->site = $model_sites->site($this->session_dlayer->siteId());
		
		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - Settings');
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
				$this->_redirect('/form/settings/base-font-family');
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
		Form builder');
	}
}
