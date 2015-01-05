<?php
/**
* Root controller for the application, will be the home page for a user once
* they have logged into the designer app
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: IndexController.php 1568 2014-02-14 14:59:50Z Dean.Blackborough $
*/
class Dlayer_IndexController extends Zend_Controller_Action
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
		// Include js and css files in layout
		$this->layout = Zend_Layout::getMvcInstance();
		$this->layout->assign('js_include', array());
		$this->layout->assign('css_include', array());
	}

	/**
	* Dlayer splash page
	*
	* @return void
	*/
	public function indexAction()
	{
		$session = $this->getInvokeArg('bootstrap')->getOption('session');

		$model_authentication = new Dlayer_Model_Authentication();
		$model_authentication->logoutInactiveIdenties($session['timeout']);

		$session_dlayer = new Dlayer_Session();
		if($session_dlayer->identityId() != FALSE) {
			$this->_redirect('/dlayer/index/home');
		}

		$model_authentication = new Dlayer_Model_Authentication();

		$form = new Dlayer_Form_Login();

		// Validate and save the posted data
		if($this->getRequest()->isPost()) {

			$post = $this->getRequest()->getPost();

			if($form->isValid($post)) {

				$authentication_options =
				$this->getInvokeArg('bootstrap')->getOption('authentication');

				$model_authentication->setSalt(
					$authentication_options['salt']);

				if($model_authentication->checkCredentials($post['identity'],
				$post['credentials']) == TRUE) {
					$identity_id = $model_authentication->identityId();

					if($identity_id != FALSE) {
						$session_dlayer = new Dlayer_Session();
						$session_dlayer->setIdentityId($identity_id);

						$model_authentication->loginIdentity($identity_id);

						$this->_redirect('/dlayer/index/home');
					} else {
						$form->getElement('identity')->addError('There
						was an error fetching your details, please try again.');
						$form->markAsError();
					}
				} else {
					$form->getElement('identity')->addError('Username and
						password combination invalid or the account is currently
					logged into Dlayer, please try again.');
					$form->markAsError();
				}
			}
		}

		$this->view->test_identities = $model_authentication->testIdentities();
		$this->view->form = $form;
		$this->dlayerMenuPublic('/dlayer/index/index');
		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - Login');
	}

	/**
	* User has logged into the app, the view allows them to choose a site
	* to work on, it is the root of the app
	*
	* @return void
	*/
	public function homeAction()
	{
		$this->_helper->authenticate();

		$session_dlayer = new Dlayer_Session();

		$model_sites = new Dlayer_Model_Site();
		$last_accessed = $model_sites->lastAccessedSite(
			$session_dlayer->identityId());

		$session_dlayer = new Dlayer_Session();
		$session_dlayer->setSiteId($last_accessed['site_id']);

		$model_modules = new Dlayer_Model_Module();

		$this->view->modules_enabled = $model_modules->byStatus();
		$this->view->modules_disabled = $model_modules->byStatus(FALSE);
		$this->dlayerMenu('/dlayer/index/home');
		$this->view->sites = $model_sites->byIdentity(
			$session_dlayer->identityId());
		$this->view->site_id = $session_dlayer->siteId();
		$this->view->last_accessed_site = $last_accessed['name'];

		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - Web site development
		simplified');
	}

	/**
	* Activate another web site, checks that the given site id is valid and
	* then activates the site by setting the session value, updating the
	* site history and then sending the user back to home
	*
	* @return void
	*/
	public function activateAction()
	{
		$this->_helper->authenticate();
		$this->_helper->disableLayout(FALSE);

		$site_id = Dlayer_Helper::getInteger('site');

		if($site_id != NULL) {
			$model_sites = new Dlayer_Model_Site();
			$session_dlayer = new Dlayer_Session();
			if($model_sites->valid($site_id,
			$session_dlayer->identityId()) == TRUE) {
				$session_dlayer->setSiteId($site_id);
				$model_sites->setLastAccessedSite($site_id,
					$session_dlayer->identityId());
			}
		}

		$this->_redirect('/dlayer/index/home');
	}

	/**
	* Generate the base menu bar for the application.
	*
	* @param string $url Active url
	* @return string Html
	*/
	private function dlayerMenu($url='')
	{
		$session_dlayer = new Dlayer_Session();

		$items = array(array('url'=>'/dlayer/index/home', 'name'=>'Dlayer', 
			'title'=>'Dlayer.com: Web development simplified'), 
			array('url'=>'/dlayer/settings/index', 'name'=>'Settings', 
				'title'=>'Dlayer settings'), 
			array('url'=>'/dlayer/index/development-plan', 
				'name'=>'Development plan', 'title'=>'Dlayer development plan'), 
			array('url'=>'/dlayer/index/development-log', 
				'name'=>'Development log', 'title'=>'Dlayer development log'), 
			array('url'=>'/dlayer/index/bugs', 'name'=>'Bugs', 
				'title'=>'Dlayer known bugs'), 
			array('url'=>'/dlayer/index/logout', 'name'=>'<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout (' . 
				$session_dlayer->identity() . ')', 'title'=>'Logout of site'));

		$this->layout->assign('nav', array('class'=>'top_nav', 
			'items'=>$items, 'active_url'=>$url));
	}

	/**
	* Generate the base menu bar for the public version of the menu
	*
	* @param string $url Active url
	* @return string html
	*/
	private function dlayerMenuPublic($url)
	{
		$items = array(array('url'=>'/dlayer/index/index', 'name'=>'Dlayer', 
			'title'=>'Dlayer.com: Web development simplified'), 
			array('url'=>'/dlayer/index/dlayer', 'name'=>'What is Dlayer?', 
				'title'=>'What is Dlayer'), 
			array('url'=>'/dlayer/index/dlayer-history', 
				'name'=>'History of Dlayer', 'title'=>'How Dlayer came to be'), 
			array('url'=>'/dlayer/index/development-plan', 
				'name'=>'Development plan', 'title'=>'Dlayer development plan'), 
			array('url'=>'/dlayer/index/development-log', 
				'name'=>'Development log', 'title'=>'Dlayer development log'), 
			array('url'=>'/dlayer/index/bugs', 'name'=>'Bugs', 
				'title'=>'Dlayer known bugs'));

		$this->layout->assign('nav', array('class'=>'top_nav', 
			'items'=>$items, 'active_url'=>$url));
	}

	/**
	* Development log for application, shows all public changes to app
	*
	* @return void
	*/
	public function developmentLogAction()
	{
		$session_dlayer = new Dlayer_Session();

		if($session_dlayer->identityId() == FALSE) {
			$this->dlayerMenuPublic('/dlayer/index/development-log');
		} else {
			$this->_helper->authenticate();
			$this->dlayerMenu('/dlayer/index/development-log');
		}

		$per_page = 30;
		$start = Dlayer_Helper::getInteger('start', 0);

		$model_development_log = new Dlayer_Model_Development();
		$updates = $model_development_log->updates($per_page, $start);

		$this->view->updates = $updates['results'];
		$this->view->updates_count = $updates['count'];
		$this->view->start = $start;
		$this->view->per_page = $per_page;

		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - Development log');
	}

	/**
	* Development plan action
	*
	* @return void
	*/
	public function developmentPlanAction()
	{
		$session_dlayer = new Dlayer_Session();

		if($session_dlayer->identityId() == FALSE) {
			$this->dlayerMenuPublic('/dlayer/index/development-plan');
		} else {
			$this->_helper->authenticate();
			$this->dlayerMenu('/dlayer/index/development-plan');
		}

		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - Development plan');
	}

	/**
	* Known bugs
	*
	* @return void
	*/
	public function bugsAction()
	{
		$session_dlayer = new Dlayer_Session();

		if($session_dlayer->identityId() == FALSE) {
			$this->dlayerMenuPublic('/dlayer/index/bugs');
		} else {
			$this->_helper->authenticate();
			$this->dlayerMenu('/dlayer/index/bugs');
		}

		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - Known bugs');
	}

	/**
	* Dlayer info page
	*
	* @return void
	*/
	public function dlayerAction()
	{
		$this->dlayerMenuPublic('/dlayer/index/dlayer');

		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - What is Dlayer?');
	}

	/**
	* SVN & release policy
	*
	* @return void
	*/
	public function svnReleasePolicyAction()
	{
		$session_dlayer = new Dlayer_Session();

		if($session_dlayer->identityId() == FALSE) {
			$this->dlayerMenuPublic('/dlayer/index/index');
		} else {
			$this->_helper->authenticate();
			$this->dlayerMenu('/dlayer/index/index');
		}

		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - SVN & release policy');
	}

	/**
	* Dlayer history page
	*
	* @return void
	*/
	public function dlayerHistoryAction()
	{
		$this->dlayerMenuPublic('/dlayer/index/dlayer-history');

		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - The history of Dlayer');
	}

	/**
	* Allows the user to create a new site
	*
	* Currently the only data that is required to create a site is a name, the
	* name needs to be unique for the user
	*
	* @return void
	*/
	public function newSiteAction()
	{
		$this->_helper->authenticate();

		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - Create web site');

		$session_dlayer = new Dlayer_Session();
		$form = new Dlayer_Form_Site_NewSite($session_dlayer->identityId());

		// Validate and save the posted data
		if($this->getRequest()->isPost()) {

			$post = $this->getRequest()->getPost();

			if($form->isValid($post)) {
				$model_sites = new Dlayer_Model_Site();
				$model_sites->addSite($session_dlayer->identityId(),
					$post['name']);
				$this->_redirect('/dlayer/index/home');
			}
		}

		$this->view->form = $form;
		$this->dlayerMenu('/dlayer/index/home');
	}

	/**
	* Allows the user to edit the details for the currently selected site
	*
	* @return void
	*/
	public function editSiteAction()
	{
		$this->_helper->authenticate();
		
		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - Edit web site');

		$session_dlayer = new Dlayer_Session();
		$form = new Dlayer_Form_Site_EditSite($session_dlayer->identityId(),
			$session_dlayer->siteId());

		// Validate and save the posted data
		if($this->getRequest()->isPost()) {

			$post = $this->getRequest()->getPost();

			if($form->isValid($post)) {
				$model_sites = new Dlayer_Model_Site();
				$model_sites->editSite($session_dlayer->siteId(),
					$post['name']);
				$this->_redirect('/dlayer/index/home');
			}
		}

		$this->view->form = $form;
		$this->dlayerMenu('/dlayer/index/home');
	}

	/**
	* Log the user out of the system, clears all session vars
	*
	* @return void
	*/
	public function logoutAction()
	{
		$session_template = new Dlayer_Session_Template();
		$session_form = new Dlayer_Session_Form();
		$session_content = new Dlayer_Session_Content();
		$session_image = new Dlayer_Session_Image();
		$session_dlayer = new Dlayer_Session();

		$model_authentication = new Dlayer_Model_Authentication();
		$model_authentication->logoutIdentity($session_dlayer->identityId());

		$session_template->clearAll(TRUE);
		$session_form->clearAll(TRUE);
		$session_content->clearAll(TRUE);
		$session_dlayer->clearAll();
		$session_image->clearAll();

		$this->_redirect('/dlayer');
	}
}