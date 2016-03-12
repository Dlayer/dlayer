<?php
/**
* Settings
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_SettingsController extends Zend_Controller_Action 
{
	/**
	* Type hinting for action helpers, hints the property to the code 
	* hinting class which exists in the library
	* 
	* @var Dlayer_Action_CodeHinting
	*/
	protected $_helper;
	
	private $layout;
	private $session_dlayer;
	
	/**
	* Init the controller, run any set up code required by all the actions 
	* in the controller
	* 
	* @return void
	*/
	public function init()
	{
		$this->_helper->authenticate();
		
		$this->_helper->validateSiteId();
		
		$this->session_dlayer = new Dlayer_Session();
		
		// Include js and css files in layout
		$this->layout = Zend_Layout::getMvcInstance();
		$this->layout->assign('js_include', array());
		$this->layout->assign('css_include', array('styles/settings.css'));
	}

	/**
	* Settings overview page, short description of each settings page for the 
	* section
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
			array('uri'=>'http://www.dlayer.com/docs/', 
				'name'=>'Dlayer Docs', 'title'=>'Read the Docs for Dlayer')
		);
		
		$this->layout->assign('nav', array(
			'class'=>'top_nav', 'items'=>$items, 'active_uri'=>$active_uri));		
	}
	
	/**
	* Set the colors for the three color palettes
	* 
	* @return void
	*/
	public function palettesAction()
	{
		$model_sites = new Dlayer_Model_Site();
		
		$this->navBar('/dlayer/settings/index');
				
		$this->view->site = $model_sites->site($this->session_dlayer->siteId());
		
		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - Colour palettes');
	}
}