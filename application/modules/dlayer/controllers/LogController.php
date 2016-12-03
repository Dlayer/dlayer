<?php

/**
 * Log controller
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_LogController extends Zend_Controller_Action
{
    /**
     * Type hinting for action helpers, hints the property to the code
     * hinting class which exists in the library
     *
     * @var Dlayer_Action_CodeHinting
     */
    protected $_helper;

    /**
     * @var array Nav bar items for public version of nav bar
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
        ),
        array(
            'uri' => '/dlayer/log/app',
            'name' => 'App log',
            'title' => 'App log'
        ),
        array(
            'uri' => '/dlayer/log/error',
            'name' => 'Error log',
            'title' => 'Error log'
        )
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
     * App log
     *
     * @return void
     */
    public function appAction()
    {
        $this->_helper->authenticate();

        $this->view->file = file(APPLICATION_PATH . '/../private/logs/app.log');

        $this->_helper->setLayoutProperties($this->nav_bar_items, '/dlayer/log/app', array('css/dlayer.css'),
            array(), 'Dlayer.com - App log');
    }

    /**
     * Error log
     *
     * @return void
     */
    public function errorAction()
    {
        $this->_helper->authenticate();

        $this->view->file = file(APPLICATION_PATH . '/../private/logs/error.log');

        $this->_helper->setLayoutProperties($this->nav_bar_items, '/dlayer/log/error', array('css/dlayer.css'),
            array(), 'Dlayer.com - Error log');
    }
}
