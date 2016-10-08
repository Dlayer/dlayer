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

	private $session_dlayer;

	/**
	 * @var array Nav bar items for logged in version of nav bar
	 */
	private $nav_bar_items = array(
		array('uri'=>'/dlayer/index/home', 'name'=>'Dlayer Demo', 'title'=>'Dlayer.com: Web development simplified'),
		array('uri'=>'/dlayer/settings/index', 'name'=>'Settings', 'title'=>'Settings'),
		array('uri'=>'http://www.dlayer.com/docs/', 'name'=>'Docs', 'title'=>'Read the Docs for Dlayer'),
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
		
		$this->_helper->validateSiteId();
		
		$this->session_dlayer = new Dlayer_Session();
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
		
		$this->view->site = $model_sites->site($this->session_dlayer->siteId());

		$this->_helper->setLayoutProperties($this->nav_bar_items, '/dlayer/settings/index', array('css/dlayer.css'),
			array(), 'Settings - Dlayer');
	}

	/**
	* Set the colors for the three color palettes
	* 
	* @return void
	*/
	public function palettesAction()
	{
		$model_sites = new Dlayer_Model_Site();
		
		$this->view->site = $model_sites->site($this->session_dlayer->siteId());

		$this->_helper->setLayoutProperties($this->nav_bar_items, '/dlayer/settings/index', array('css/dlayer.css'),
			array(), 'Settings - Dlayer: Colour palettes');
	}
}
