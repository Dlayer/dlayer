<?php
/**
* Root controller for the image library. 
* 
* The image library is where the user manages all their images
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Image_IndexController extends Zend_Controller_Action
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
		array('uri'=>'/image/index/index', 'name'=>'Image library', 'title'=>'Media management'),
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

		$this->_helper->setLayoutProperties($this->nav_bar_items, '/image/index/index', array('css/dlayer.css'),
			array(), 'Dlayer.com - Image library');
	}
}
