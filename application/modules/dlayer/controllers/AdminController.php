<?php

/**
 * Admin controller for Dlayer
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_AdminController extends Zend_Controller_Action
{
    /**
     * Type hinting for action helpers
     *
     * @var Dlayer_Action_CodeHinting
     */
    protected $_helper;

    private $site_id;

    private $identity_id;

    private $form;

    /**
     * @var array Nav bar items
     */
    private $nav_bar_items = array(
        array(
            'uri' => '/dlayer/index/home',
            'name' => 'Dlayer Demo',
            'title' => 'Dlayer.com: Web development simplified'
        ),
        array(
            'uri' => 'http://www.dlayer.com/docs/',
            'name' => 'Docs',
            'title' => 'Read the Docs for Dlayer'
        )
    );

    /**
     * Execute the setup methods for the controller and set the properties
     *
     * @return void
     */
    public function init()
    {
        $this->_helper->validateModule();

        $this->_helper->authenticate();

        $session_dlayer = new Dlayer_Session();

        $this->site_id = $session_dlayer->siteId();
        $this->identity_id = $session_dlayer->identityId();
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
        $model = new Dlayer_Model_Admin_Site();

        $control_bar_buttons = array(
            array(
                'uri' => '/dlayer/index/home',
                'class' => 'default',
                'name' => 'Dashboard'
            ),
            array(
                'uri'=>'/dlayer/admin/new',
                'class' => 'primary',
                'name'=>'New website'
            )
        );

        $control_bar_drops = array(
            array(
                'name' => 'Your websites',
                'class' => 'default',
                'buttons' => $model->sitesForControlBar($identity_id, $site_id)
            )
        );

        $this->assignToControlBar($control_bar_buttons, $control_bar_drops);
    }

    /**
     * Create a new website, at the moment a user only needs to define the name they want to use, later there
     * will be an updated to set additional data as well as some Dlayer options
     *
     * @return void
     */
    public function newAction()
    {
        $this->_helper->authenticate();

        $this->form = new Dlayer_Form_Admin_Site('/dlayer/admin/new');

        if ($this->getRequest()->isPost()) {
            $this->handleAdd();
        }

        $model_sites = new Dlayer_Model_Admin_Site();
        $this->view->site = $model_sites->site($this->site_id);
        $this->view->form = $this->form;

        $this->controlBar($this->identity_id, $this->site_id);

        $this->_helper->setLayoutProperties($this->nav_bar_items, '/dlayer/index/home', array('css/dlayer.css'),
            array(), 'Dlayer.com - New website');
    }

    /**
     * Handle add web site, if successful the user is redirected back to app root, site is not automatically activate
     * done by a different action because it is more involved than just setting an id
     *
     * @return void
     */
    private function handleAdd()
    {
        $post = $this->getRequest()->getPost();

        if ($this->form->isValid($post)) {
            $model = new Dlayer_Model_Admin_Site();
            $site_id = $model->saveSite($post['name']);

            if ($site_id !== false) {
                $this->redirect('/dlayer/index/home');
            }
        }
    }

    /**
     * Edit the selected web site
     *
     * @return void
     */
    public function editAction()
    {
        $this->_helper->authenticate();

        $this->form = new Dlayer_Form_Admin_Site('/dlayer/admin/edit', $this->site_id);

        if ($this->getRequest()->isPost()) {
            $this->handleEdit();
        }

        $model = new Dlayer_Model_Admin_Site();
        $this->view->site = $model->site($this->site_id);
        $this->view->form = $this->form;

        $this->controlBar($this->identity_id, $this->site_id);

        $this->_helper->setLayoutProperties($this->nav_bar_items, '/dlayer/index/home', array('css/dlayer.css'),
            array(), 'Dlayer.com - Edit website');
    }

    /**
     * Handle edit web site, if successful the user is redirected back to app root
     *
     * @return void
     */
    private function handleEdit()
    {
        $post = $this->getRequest()->getPost();

        if ($this->form->isValid($post)) {
            $model = new Dlayer_Model_Admin_Site();
            $site_id = $model->saveSite($post['name'], $this->site_id);

            if ($site_id !== false) {
                $this->redirect('/dlayer/index/home');
            }
        }
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
}
