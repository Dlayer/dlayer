<?php

/**
 * Admin controller for Form Builder
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Form_AdminController extends Zend_Controller_Action
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
     * @var Dlayer_Session_Form
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
            'uri' => '/form/index/index',
            'name' => 'Form Builder',
            'title' => 'Form Builder'
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

        $this->session = new Dlayer_Session_Form();
    }

    /**
     * Add a new form to the system for the selected site
     *
     * @return void
     */
    public function newAction()
    {
        $model_sites = new Dlayer_Model_Site();

        $this->form = new Dlayer_Form_Site_Form('/form/admin/new', $this->site_id);

        if ($this->getRequest()->isPost()) {
            $this->processAddForm();
        }

        $this->view->form = $this->form;
        $this->view->site = $model_sites->site($this->site_id);

        $this->controlBar($this->identity_id, $this->site_id);

        $this->_helper->setLayoutProperties($this->nav_bar_items, '/form/index/index', array('css/dlayer.css'),
            array(), 'Dlayer.com - Form Builder: New form');
    }

    /**
     * Edit the selected form
     *
     * @return void
     */
    public function editAction()
    {
        $model_sites = new Dlayer_Model_Site();
        $model_forms = new Dlayer_Model_Admin_Form();

        $form_id = $this->session->formId();

        $this->form = new Dlayer_Form_Site_Form(
            '/form/admin/edit',
            $this->site_id,
            $form_id,
            $model_forms->form($this->site_id, $form_id)
        );

        if ($this->getRequest()->isPost()) {
            $this->processEditForm($form_id);
        }

        $this->view->form = $this->form;
        $this->view->site = $model_sites->site($this->site_id);

        $this->controlBar($this->identity_id, $this->site_id);

        $this->_helper->setLayoutProperties($this->nav_bar_items, '/form/index/index', array('css/dlayer.css'),
            array(), 'Dlayer.com - Form Builder: Edit form');
    }

    /**
     * Validate for new form data and if successful add the form and redirect the user after activating the form
     *
     * @return void
     */
    private function processAddForm()
    {
        $post = $this->getRequest()->getPost();

        if ($this->form->isValid($post)) {

            $model = new Dlayer_Model_Admin_Form();
            $form_id = $model->saveForm($this->site_id, $post['name'], $post['title']);

            if ($form_id !== false) {
                $this->session->clearAll(true);
                $this->session->setFormId($form_id);
                $this->redirect('/form');
            }
        }
    }

    /**
     * Validate for new form data and if successful edit the form and redirect the user back to the Form Builder
     *
     * @param integer $form_id
     * @return void
     */
    private function processEditForm($form_id)
    {
        $post = $this->getRequest()->getPost();

        if ($this->form->isValid($post)) {

            $model = new Dlayer_Model_Admin_Form();
            $form_id = $model->saveForm(
                $this->site_id,
                $post['name'],
                $post['title'],
                $form_id
            );

            if ($form_id !== false) {
                $this->redirect('/form');
            }
        }
    }

    /**
     * Activate the selected form, cleans the session and set the new form id
     *
     * @return void
     */
    public function activateAction()
    {
        $this->_helper->disableLayout(false);

        $model = new Dlayer_Model_Admin_Form();
        $form_id = Dlayer_Helper::getParamAsInteger('id');

        if ($form_id !== null && $model->valid($this->site_id, $form_id) === true) {
            $this->session->clearAll();
            $this->session->setFormId($form_id);
        }

        $this->redirect('/form');
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
                'uri'=>'/form/admin/new',
                'class' => 'primary',
                'name'=>'New form'
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
