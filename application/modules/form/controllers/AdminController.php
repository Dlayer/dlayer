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

        $this->site_id = $session_dlayer->siteId();;
    }

    /**
     * Add a new form to the system for the selected site
     *
     * @return void
     */
    public function newAction()
    {
        $this->view->forms = array();

        $this->_helper->setLayoutProperties($this->nav_bar_items, '/form/admin/index', array('css/dlayer.css'),
            array(), 'Dlayer.com - Form Builder: New form');
    }
}
