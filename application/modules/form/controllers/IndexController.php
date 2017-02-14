<?php

/**
 * Root controller for the Form Builder
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Form_IndexController extends Zend_Controller_Action
{
    /**
     * Type hinting for action helpers
     *
     * @var Dlayer_Action_CodeHinting
     */
    protected $_helper;

    /**
     * @var integer
     */
    private $site_id;

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
        array('uri' => '/form/index/index', 'name' => 'Form Builder', 'title' => 'Form Builder'),
        array('uri' => 'http://www.dlayer.com/docs/', 'name' => 'Docs', 'title' => 'Read the Docs for Dlayer'),
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
     * Show a list of the form for the selected site
     *
     * @return void
     */
    public function indexAction()
    {
        $model_sites = new Dlayer_Model_Admin_Site();
        $model_forms = new Dlayer_Model_Admin_Form();

        $forms = $model_forms->forms($this->site_id);

        // Auto activate if only one form in system
        if ($this->session->formId() === null && count($forms) === 1) {
            $this->redirect('/form/admin/activate/id/' . $forms[0]['id']);
        }

        $this->view->forms = $forms;
        $this->view->site = $model_sites->site($this->site_id);
        $this->view->form_id = $this->session->formId();

        $session_dlayer = new Dlayer_Session();
        $this->controlBar($session_dlayer->identityId(), $session_dlayer->siteId());

        $this->_helper->setLayoutProperties($this->nav_bar_items, '/form/index/index', array('css/dlayer.css'),
            array(), 'Dlayer.com - Form Builder');
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
                'uri'=>'/form/admin/new',
                'class' => 'primary',
                'name'=>'New form'
            )
        );

        $control_bar_drops = array(
            array(
                'name' => 'Your websites',
                'class' => 'default',
                'buttons' => $model->sitesForControlBar($identity_id, $site_id)
            )
        );

        $this->_helper->populateControlBar($control_bar_buttons, $control_bar_drops);
    }
}
