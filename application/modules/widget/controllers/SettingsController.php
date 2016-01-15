<?php
/**
* Settings
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Widget_SettingsController extends Zend_Controller_Action 
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
			'styles/settings.css'));
	}

	/**
	* Base settings page for the web site manager
	* 
	* @return void
	*/
	public function indexAction()
	{
		$model_sites = new Dlayer_Model_Site();

		$this->dlayerMenu('/widget/settings/index');
		$this->settingsMenus('Widget', '/widget/settings/index', 
			'/widget/settings/index');

		$this->view->site = $model_sites->site($this->session_dlayer->siteId());

		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - Widget designer settings');
	}
	
	/**
	* Generate the base menu bar for the application.
	* 
	* @param string $url Selected url
	* @return string Html
	*/
	private function dlayerMenu($url) 
	{
		$items = array(array('url'=>'/dlayer/index/home', 'name'=>'Dlayer', 
		'title'=>'Dlayer.com: Web development simplified'), 
		array('url'=>'/widget/settings/index', 'name'=>'Settings', 
		'title'=>'Widget designer settings'), 
		array('url'=>'/dlayer/index/development-plan', 
		'name'=>'Dev plan', 'title'=>'Current Dlayer development plan'), 
		array('url'=>'/dlayer/index/development-log', 
		'name'=>'Dev log', 'title'=>'Dlayer development log'), 
		array('url'=>'/dlayer/index/bugs', 'name'=>'Bugs', 
		'title'=>'Known bugs'), 
		array('url'=>'http://specification.dlayer.com', 
				'name'=>'<span class="glyphicon glyphicon-new-window" 
					aria-hidden="true"></span> Specification', 
				'title'=>'Current specification'),
		array('url'=>'/dlayer/index/logout', 'name'=>'<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Sign out (' . 
				$this->session_dlayer->identity() . ')', 'title'=>'Logout of site'));
		
		$this->layout->assign('nav', array('class'=>'top_nav', 
		'items'=>$items, 'active_url'=>$url));
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