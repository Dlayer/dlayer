<?php
/**
* Controller for image library class development
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dev_ThumbnailController extends Zend_Controller_Action
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
    * Overview action for new class
    *
    * @return void
    */
    public function indexAction()
    {
        $resizer = new Dlayer_Image_Resizer_Jpeg(10, 10);
    }
    
    /**
    * Process
    *
    * @return void
    */
    public function processAction()
    {
        
    }
    
    /**
    * Load new thumbnail
    * 
    * @return void
    */
    public function viewAction() 
    {
        
    }
}