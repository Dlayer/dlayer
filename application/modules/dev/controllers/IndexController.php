<?php
/**
* Base controller for the development module, just links to the individual 
* development actions
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dev_IndexController extends Zend_Controller_Action
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
        $this->_helper->setLayout('dev');
        
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
        
    }
}