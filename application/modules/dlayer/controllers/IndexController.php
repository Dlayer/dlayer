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
     * @var Zend_Form
     */
    private $site_form;

    /**
     * @var Zend_Form
     */
    private $login_form;

    /**
     * @var array Nav bar items for logged in version of nav bar
     */
    private $nav_bar_items_private = array(
        array(
            'uri' => '/dlayer/index/home',
            'name' => 'Dlayer Demo',
            'title' => 'Dlayer.com: Web development simplified',
        ),
        array('uri' => 'http://www.dlayer.com/docs/', 'name' => 'Docs', 'title' => 'Read the Docs for Dlayer')
    );

    /**
     * @var array Nav bar items for public version of nav bar
     */
    private $nav_bar_items_public = array(
        array(
            'uri' => '/dlayer/index/index',
            'name' => 'Dlayer Demo',
            'title' => 'Dlayer.com: Web development simplified',
        ),
        array(
            'uri' => '/setup/index/index',
            'name' => 'Setup',
            'title' => 'Setup Dlayer'
        ),
        array(
            'uri' => 'http://www.dlayer.com/docs/',
            'name' => 'Docs',
            'title' => 'Read the Docs for Dlayer'
        ),
    );

    /**
     * Init the controller, run any set up code required by all the actions
     * in the controller
     *
     * @return void
     */
    public function init()
    {
        $layout = Zend_Layout::getMvcInstance();
        $layout->assign('show_control_bar', false);
    }

    /**
     * Dlayer splash page
     *
     * @return void
     */
    public function indexAction()
    {
        $session = $this->getInvokeArg('bootstrap')
            ->getOption('session');
        $app_settings = $this->getInvokeArg('bootstrap')->getOption('app');

        $model_authentication = new Dlayer_Model_Authentication();
        $model_authentication->logoutInactiveIdenties($session['timeout']);

        $session_dlayer = new Dlayer_Session();

        if ($session_dlayer->identityId() !== false) {
            $this->redirect('/dlayer/index/home');
        }

        $model_authentication = new Dlayer_Model_Authentication();

        $this->login_form = new Dlayer_Form_Login();

        if ($this->getRequest()
            ->isPost()
        ) {
            $this->handleLogin();
        }

        $test_credentials = false;

        if (intval($app_settings['demo']['show_credentials']) === 1) {
            $test_credentials = $model_authentication->testIdentities();
        }

        $this->view->test_credentials = $test_credentials;
        $this->view->form = $this->login_form;

        $this->_helper->setLayoutProperties($this->nav_bar_items_public, '/dlayer/index/index', array('css/dlayer.css'),
            array(), 'Dlayer.com - Sign in', '', false);
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
        $model_modules = new Dlayer_Model_Module();

        $last_accessed = $model_sites->lastAccessedSite($session_dlayer->identityId());

        $session_dlayer = new Dlayer_Session();
        $session_dlayer->setSiteId($last_accessed['site_id']);

        $this->view->active_items = $model_modules->activeItems($session_dlayer->siteId());
        $this->view->site_id = $session_dlayer->siteId();
        $this->view->site = $model_sites->site($session_dlayer->siteId());

        $this->controlBar($session_dlayer->identityId(), $session_dlayer->siteId());

        $this->_helper->setLayoutProperties($this->nav_bar_items_private, '/dlayer/index/home', array('css/dlayer.css'),
            array(), 'Dlayer.com - Web site development');
    }

    /**
     * Control bar
     *
     * @param integer $identity_id
     * @param integer $site_id
     *
     * @return void
     */
    private function controlBar($identity_id, $site_id)
    {
        $model_sites = new Dlayer_Model_Site();

        $control_bar_buttons = array(
            array(
                'uri'=>'/dlayer/index/new-site',
                'name'=>'New web site'
            )
        );

        $control_bar_drops = array(
            array(
                'name' => 'Your sites',
                'class' => 'info',
                'buttons' => $model_sites->sitesForControlBar($identity_id, $site_id)
            )
        );

        $this->assignToControlBar($control_bar_buttons, $control_bar_drops);
    }

    /**
     * Assign control bar buttons
     *
     * @param array $buttons
     * @param array $drops
     *
     * @todo Move this into an action helper
     * @return void
     */
    private function assignToControlBar(array $buttons, array $drops)
    {
        $layout = Zend_Layout::getMvcInstance();
        $layout->assign('show_control_bar', true);
        $layout->assign('control_bar_buttons', $buttons);
        $layout->assign('control_bar_drops', $drops);
    }

    /**
     * Activate another web site, checks site is accessible to user and then activates it
     *
     * @return void
     */
    public function activateAction()
    {
        $this->_helper->disableLayout(false);

        $this->_helper->authenticate();

        $site_id = Dlayer_Helper::getParamAsInteger('site');

        if ($site_id != null) {
            $model_sites = new Dlayer_Model_Site();
            $session_dlayer = new Dlayer_Session();

            if ($model_sites->valid($site_id, $session_dlayer->identityId()) == true) {
                $session_dlayer->setSiteId($site_id);
                $model_sites->setLastAccessedSite($site_id, $session_dlayer->identityId());
            }
        }

        $this->redirect('/dlayer/index/home');
    }

    /**
     * Create a new web site, at the moment a user only needs to define the name they want to use, later there
     * will be an updated to set additional data as well as some Dlayer options
     *
     * @return void
     */
    public function newSiteAction()
    {
        $this->_helper->authenticate();

        $session_dlayer = new Dlayer_Session();

        $this->site_form = new Dlayer_Form_Site_Site('/dlayer/index/new-site');

        if ($this->getRequest()->isPost()) {
            $this->handleAddSite();
        }

        $model_sites = new Dlayer_Model_Site();
        $this->view->site = $model_sites->site($session_dlayer->siteId());
        $this->view->form = $this->site_form;

        $this->controlBar($session_dlayer->identityId(), $session_dlayer->siteId());

        $this->_helper->setLayoutProperties($this->nav_bar_items_private, '/dlayer/index/home', array('css/dlayer.css'),
            array(), 'Dlayer.com - New web site');
    }

    /**
     * Edit the selected web site
     *
     * @return void
     */
    public function editSiteAction()
    {
        $this->_helper->authenticate();

        $session_dlayer = new Dlayer_Session();

        $this->site_form = new Dlayer_Form_Site_Site('/dlayer/index/edit-site', $session_dlayer->siteId());

        if ($this->getRequest()
            ->isPost()
        ) {
            $this->handleEditSite();
        }

        $model_sites = new Dlayer_Model_Site();
        $this->view->site = $model_sites->site($session_dlayer->siteId());
        $this->view->form = $this->site_form;

        $this->controlBar($session_dlayer->identityId(), $session_dlayer->siteId());

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
        $session_dlayer = new Dlayer_Session();
        $identity_id = $session_dlayer->identityId();

        if ($identity_id === false) {
            if (file_exists(APPLICATION_PATH . '/../private/logs/error.log') === true) {
                unlink(APPLICATION_PATH . '/../private/logs/error.log');
            }
            if (file_exists(APPLICATION_PATH . '/../private/logs/app.log') === true) {
                unlink(APPLICATION_PATH . '/../private/logs/app.log');
            }
        } else {
            if (file_exists(APPLICATION_PATH . '/../private/logs/error-' . $identity_id . '.log') === true) {
                unlink(APPLICATION_PATH . '/../private/logs/error-' . $identity_id . '.log');
            }
            if (file_exists(APPLICATION_PATH . '/../private/logs/app-' . $identity_id . '.log') === true) {
                unlink(APPLICATION_PATH . '/../private/logs/app-' . $identity_id . '.log');
            }
        }

        $this->handleLogout();
    }

    /**
     * Handle add web site, if successful the user is redirected back to app root, site is not automatically activate
     * done by a different action because it is more involved than just setting an id
     *
     * @return void
     */
    private function handleAddSite()
    {
        $post = $this->getRequest()
            ->getPost();

        if ($this->site_form->isValid($post)) {
            $model_sites = new Dlayer_Model_Site();
            $site_id = $model_sites->saveSite($post['name']);

            if ($site_id !== false) {
                $this->redirect('/dlayer/index/home');
            }
        }
    }

    /**
     * Handle edit web site, if successful the user is redirected back to app root
     *
     * @return void
     */
    private function handleEditSite()
    {
        $post = $this->getRequest()
            ->getPost();

        if ($this->site_form->isValid($post)) {
            $session_dlayer = new Dlayer_Session();

            $model_sites = new Dlayer_Model_Site();
            $site_id = $model_sites->saveSite($post['name'], $session_dlayer->siteId());

            if ($site_id !== false) {
                $this->redirect('/dlayer/index/home');
            }
        }
    }

    /**
     * Handle login
     *
     * @return void
     */
    private function handleLogin()
    {
        $model_authentication = new Dlayer_Model_Authentication();

        $post = $this->getRequest()
            ->getPost();

        if ($this->login_form->isValid($post)) {
            $authentication_options = $this->getInvokeArg('bootstrap')
                ->getOption('authentication');

            $model_authentication->setSalt($authentication_options['salt']);

            if ($model_authentication->checkCredentials($post['identity'], $post['credentials']) === true) {
                $identity_id = $model_authentication->identityId();

                if ($identity_id !== false) {
                    $session_dlayer = new Dlayer_Session();
                    $session_dlayer->setIdentityId($identity_id);

                    $model_authentication->loginIdentity($identity_id);

                    Dlayer_Helper::sendToInfoLog('Identity: ' . $identity_id . ' signed into app');

                    $this->redirect('/dlayer/index/home');
                } else {
                    $this->login_form->getElement('identity')
                        ->addError('There was an error fetching your details,
						    please try again.');
                    $this->login_form->markAsError();
                }
            } else {
                $this->login_form->getElement('identity')
                    ->addError('Username and password combination invalid or 
					    the account is already logged into Dlayer, please try again.');
                $this->login_form->markAsError();
            }
        }
    }

    /**
     * Logout the user
     *
     * @return void
     */
    private function handleLogout()
    {
        $session_content = new Dlayer_Session_Content();
        $session_form = new Dlayer_Session_Form();
        $session_designer = new Dlayer_Session_Designer();
        $session_dlayer = new Dlayer_Session();

        $model_authentication = new Dlayer_Model_Authentication();
        $model_authentication->logoutIdentity($session_dlayer->identityId());

        Dlayer_Helper::sendToInfoLog('Identity: ' . $session_dlayer->identityId() . ' signed out of app');

        $session_content->clearAll(true);
        $session_form->clearAll(true);
        $session_dlayer->clearAll();
        $session_designer->clearAll();

        $this->redirect('/dlayer');
    }
}
