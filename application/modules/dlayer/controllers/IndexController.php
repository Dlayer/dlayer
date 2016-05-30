<?php
/**
* Root controller for the application, will be the home page for a user once
* they have logged into the designer app
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
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

	/**
	 * @var array Nav bar items for logged in version of nav bar
	 */
	private $nav_bar_items_private = array(
		array('uri'=>'/dlayer/index/home', 'name'=>'Dlayer Demo', 'title'=>'Dlayer.com: Web development simplified'),
		array('uri'=>'/dlayer/settings/index', 'name'=>'Settings', 'title'=>'Settings'),
		array('uri'=>'http://www.dlayer.com/docs/', 'name'=>'Dlayer Docs', 'title'=>'Read the Docs for Dlayer'),
	);

	/**
	 * @var array Nav bar items for public version of nav bar
	 */
	private $nav_bar_items_public = array(
		array('uri'=>'/dlayer/index/home', 'name'=>'Dlayer Demo', 'title'=>'Dlayer.com: Web development simplified'),
		array('uri'=>'http://www.dlayer.com/docs/', 'name'=>'Dlayer Docs', 'title'=>'Read the Docs for Dlayer'),
	);

	/**
	* Init the controller, run any set up code required by all the actions
	* in the controller
	*
	* @return void
	*/
	public function init()
	{

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
		if($session_dlayer->identityId() != FALSE)
		{
			$this->redirect('/dlayer/index/home');
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
						password combination invalid or the account is 
						already logged into Dlayer, please try again.');
					$form->markAsError();
				}
			}
		}

		$this->view->test_identities = $model_authentication->testIdentities();
		$this->view->form = $form;

		$this->_helper->setLayoutProperties($this->nav_bar_items_public, '/dlayer/index/index', array('css/dlayer.css'),
			array(), 'Dlayer.com - Sign in');
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
		$last_accessed = $model_sites->lastAccessedSite($session_dlayer->identityId());

		$session_dlayer = new Dlayer_Session();
		$session_dlayer->setSiteId($last_accessed['site_id']);

		$model_modules = new Dlayer_Model_Module();

		$this->view->modules_enabled = $model_modules->byStatus();
		$this->view->sites = $model_sites->byIdentity($session_dlayer->identityId());
		$this->view->site_id = $session_dlayer->siteId();
		$this->view->last_accessed_site = $last_accessed['name'];

		$this->_helper->setLayoutProperties($this->nav_bar_items_private, '/dlayer/index/home', array('css/dlayer.css'),
			array(), 'Dlayer.com - Web site development');
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

		$this->redirect('/dlayer/index/home');
	}

	/**
	* Allows the user to create a new site
	*
	* Currently the only data that is required to create a site is the name. 
	* the name needs to be unique for the user
	*
	* @return void
	*/
	public function newSiteAction()
	{
		$this->_helper->authenticate();

		$session_dlayer = new Dlayer_Session();
		$form = new Dlayer_Form_Site_NewSite($session_dlayer->identityId());

		// Validate and save the posted data
		if($this->getRequest()->isPost()) {

			$post = $this->getRequest()->getPost();

			if($form->isValid($post)) {
				$model_sites = new Dlayer_Model_Site();
				$model_sites->addSite($session_dlayer->identityId(),
					$post['name']);
				$this->redirect('/dlayer/index/home');
			}
		}

		$this->view->form = $form;

		$this->_helper->setLayoutProperties($this->nav_bar_items_private, '/dlayer/index/home', array('css/dlayer.css'),
			array(), 'Dlayer.com - New web site');
	}

	/**
	* Allows the user to edit the details for the currently selected site
	*
	* @return void
	*/
	public function editSiteAction()
	{
		$this->_helper->authenticate();

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
				$this->redirect('/dlayer/index/home');
			}
		}

		$this->view->form = $form;

		$this->_helper->setLayoutProperties($this->nav_bar_items_private, '/dlayer/index/home', array('css/dlayer.css'),
			array(), 'Dlayer.com - Edit web site');
	}

	/**
	* Log the user out of the system, clears all session vars
	*
	* @return void
	*/
	public function logoutAction()
	{
		$session_form = new Dlayer_Session_Form();
		$session_content = new Dlayer_Session_Content();
		$session_image = new Dlayer_Session_Image();
		$session_designer = new Dlayer_Session_Designer();
		$session_dlayer = new Dlayer_Session();

		$model_authentication = new Dlayer_Model_Authentication();
		$model_authentication->logoutIdentity($session_dlayer->identityId());

		$session_form->clearAll(TRUE);
		$session_content->clearAll(TRUE);
		$session_dlayer->clearAll();
		$session_designer->clearAll();
		$session_image->clearAll();

		$this->redirect('/dlayer');
	}
}
