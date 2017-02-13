<?php

/**
 * Admin controller for Content manager
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Content_AdminController extends Zend_Controller_Action
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
     * @var Dlayer_Session_Content
     */
    private $session;

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
            'uri' => '/content/index/index',
            'name' => 'Content Manager',
            'title' => 'Content Manager'
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

        $this->session = new Dlayer_Session_Content();
    }

    /**
     * Add a new content page
     *
     * @return void
     */
    public function newAction()
    {
        $model_sites = new Dlayer_Model_Site();

        $this->form = new Dlayer_Form_Site_ContentPage('/content/admin/new', $this->site_id);

        if ($this->getRequest()->isPost()) {
            $this->handleAddPage();
        }

        $this->view->form = $this->form;
        $this->view->site = $model_sites->site($this->site_id);

        $this->controlBar($this->identity_id, $this->site_id);

        $this->_helper->setLayoutProperties($this->nav_bar_items, '/content/index/index', array('css/dlayer.css'),
            array(), 'Dlayer.com - Content Manager: New page');
    }

    /**
     * Handle add content page, if successful the user is redirected after the ids for the new page has been set in
     * the session
     *
     * @return void
     */
    private function handleAddPage()
    {
        $post = $this->getRequest()->getPost();

        if ($this->form->isValid($post)) {
            $model_pages = new Dlayer_Model_Page();
            $page_id = $model_pages->savePage($this->site_id, $post['name'], $post['title'], $post['description']);

            if ($page_id !== false) {
                $this->session->clearAll(true);
                $this->session->setPageId($page_id);
                $this->redirect('/content');
            }
        }
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
                'uri' => '/dlayer/index/home',
                'class' => 'default',
                'name' => 'Dashboard'
            ),
            array(
                'uri'=>'/content/admin/new',
                'class' => 'primary',
                'name'=>'New page'
            )
        );

        $control_bar_drops = array(
            array(
                'name' => 'Your websites',
                'class' => 'default',
                'buttons' => $model_sites->sitesForControlBar($identity_id, $site_id)
            )
        );

        $this->assignToControlBar($control_bar_buttons, $control_bar_drops);
    }

    /**
     * Edit the selected content page
     *
     * @return void
     */
    public function editAction()
    {
        $model_sites = new Dlayer_Model_Site();

        $this->form = new Dlayer_Form_Site_ContentPage('/content/admin/edit', $this->site_id,
            $this->session->pageId());

        if ($this->getRequest()->isPost()) {
            $this->handleEditContentPage();
        }

        $this->view->form = $this->form;
        $this->view->site = $model_sites->site($this->site_id);

        $session_dlayer = new Dlayer_Session();
        $this->controlBar($session_dlayer->identityId(), $this->site_id);

        $this->_helper->setLayoutProperties($this->nav_bar_items, '/content/index/index', array('css/dlayer.css'),
            array(), 'Dlayer.com - Edit content page');
    }

    /**
     * Handle edit content page, if successful the user is redirected back to Content manager root
     *
     * @return void
     */
    private function handleEditContentPage()
    {
        $post = $this->getRequest()->getPost();

        if ($this->form->isValid($post)) {
            $model_pages = new Dlayer_Model_Page();
            $page_id = $model_pages->savePage($this->site_id, $post['name'], $post['title'], $post['description'],
                $this->session->pageId());

            if ($page_id !== false) {
                $this->redirect('/content');
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
