<?php
/**
* Root controller for the widget module, The widget module allows the user to 
* create reusable fragments to use either on templates, on content pages or 
* in other widgets
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: IndexController.php 1568 2014-02-14 14:59:50Z Dean.Blackborough $
*/
class Widget_IndexController extends Zend_Controller_Action
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
		$this->layout->assign('js_include', array());
		$this->layout->assign('css_include', array());
	}

	/**
	* Root action, show an overview of the widgets for the web site
	* 
	* @return void
	*/
	public function indexAction()
	{
		$model_sites = new Dlayer_Model_Site();
		$model_forms = new Dlayer_Model_Form();

		$this->dlayerMenu('/widget/index/index');
		$this->view->site = $model_sites->site($this->session_dlayer->siteId());

		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - Widget designer');
	}
	
	/**
	* Generate the base menu bar for the application.
	* 
	* @param string $url Selected url
	* @return string Html
	*/
	private function dlayerMenu($url) 
	{
		$items = array(array('url'=>'/widget/index/index', 
			'name'=>'Widget designer', 'title'=>'Dlayer Widget designer'), 
			array('url'=>'', 'name'=>'Designers', 'title'=>'Choose a designer', 
				'children'=>array(
					array('url'=>'/content/index/index', 
						'name'=>'Content manager', 
						'title'=>'Dlayer Content manager'), 
					array('url'=>'/form/index/index', 
						'name'=>'Form builder', 
						'title'=>'Dlayer Form builder'), 
					array('url'=>'/image/index/index', 
						'name'=>'Image library', 
						'title'=>'Dlayer Image library'),
					array('url'=>'/website/index/index', 
						'name'=>'Web site manager', 
						'title'=>'Dlayer Website manager'), 
					array('url'=>'/template/index/index', 
						'name'=>'Template designer', 
						'title'=>'Dlayer Template designer'))),
			array('url'=>'/widget/settings/index', 
				'name'=>'Settings', 'title'=>'Widget designer settings'), 
			array('url'=>'http://specification.dlayer.com', 
				'name'=>'<span class="glyphicon glyphicon-new-window" 
					aria-hidden="true"></span> Specification', 
				'title'=>'Current specification'),
			array('url'=>'/dlayer/index/logout', 'name'=>'<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Sign out (' . 
				$this->session_dlayer->identity() . ')', 'title'=>'Sign out of my app'));

		$this->layout->assign('nav', array('class'=>'top_nav', 
			'items'=>$items, 'active_url'=>$url));
	}
}