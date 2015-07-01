<?php
/**
* Root controller for the Dlayer data manager
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Data_DatasetController extends Zend_Controller_Action
{
	/**
	* Type hinting for action helpers, hints the property to the code
	* hinting class which exists in the library
	*
	* @var Dlayer_Action_CodeHinting
	*/
	protected $_helper;

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
	* Data manager entry page
	*
	* @return void
	*/
	public function indexAction()
	{
		$this->dlayerMenu('/data/index/index');

		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - Dataset designer');
	}
	
	/**
	* Generate the base menu bar for the application.
	* 
	* @param string $url Selected url
	* @return string Html
	*/
	private function dlayerMenu($url) 
	{
		$items = array(array('url'=>'/data/index/index', 
			'name'=>'Data manager', 'title'=>'Dlayer Data manager'), 
			array('url'=>'', 'name'=>'Designers', 'title'=>'Choose a designer', 
				'children'=>array(
					array('url'=>'/content/index/index', 
						'name'=>'Content manager', 
						'title'=>'Dlayer Content manager'), 
					array('url'=>'/widget/index/index', 
						'name'=>'Widget designer', 
						'title'=>'Dlayer Widget designer'), 
					array('url'=>'/data/index/index', 
						'name'=>'Data manager', 
						'title'=>'Dlayer Data manager'),
					array('url'=>'/image/index/index', 
						'name'=>'Image library', 
						'title'=>'Dlayer Image library'),
					array('url'=>'/website/index/index', 
						'name'=>'Web site manager', 
						'title'=>'Dlayer Website manager'), 
					array('url'=>'/template/index/index', 
						'name'=>'Template designer', 
						'title'=>'Dlayer Template designer'))),
			array('url'=>'/form/settings/index', 
				'name'=>'Settings', 'title'=>'Form builder settings'), 
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