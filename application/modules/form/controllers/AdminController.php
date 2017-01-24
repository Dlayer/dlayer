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

        $this->_helper->setLayoutProperties($this->nav_bar_items, '/form/index/index', array('css/dlayer.css'),
            array(), 'Dlayer.com - Form Builder: New form');
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

            $model_form = new Dlayer_Model_Form();
            $form_id = $model_form->saveForm($this->site_id, $post['name'], $post['title']);

            if ($form_id !== false) {
                $this->session->clearAll(true);
                $this->session->setFormId($form_id);
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

        $model = new Dlayer_Model_Form();
        $form_id = Dlayer_Helper::getParamAsInteger('id');

        if ($form_id !== null && $model->valid($this->site_id, $form_id) === true) {
            $this->session->clearAll();
            $this->session->setFormId($form_id);
        }

        $this->redirect('/form');
    }
}
