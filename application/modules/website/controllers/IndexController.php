<?php
/**
* Root controller for the module. 
* 
* The web site manager allows their user tro build u[p a picturwe of their site, 
* iniitally the index page should show a few stats for the web site, they can 
* then move into the areas, sitemap, activity, logging etc
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Website_IndexController extends Zend_Controller_Action
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
		array('uri'=>'/website/index/index', 'name'=>'Web site manager', 'title'=>'Web site manager'),
		array('uri'=>'/dlayer/settings/index', 'name'=>'Settings', 'title'=>'Settings'),
		array('uri'=>'http://www.dlayer.com/docs/', 'name'=>'Dlayer Docs', 'title'=>'Read the Docs for Dlayer')
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
	* Root action, shows overview of the user's site
	* 
	* @return void
	*/
	public function indexAction()
	{
		$model_sites = new Dlayer_Model_Site();

		$this->view->site = $model_sites->site($this->session_dlayer->siteId());

		$this->_helper->setLayoutProperties($this->nav_bar_items, '/website/index/index', array('css/dlayer.css'),
			array(), 'Dlayer.com - Web site manager');
	}
}
