<?php
/**
* Controller for image library class development
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dev_ThumbnailAdvancedController extends Zend_Controller_Action
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
        // Add in code to see if thumbnail exists
    }
    
    /**
    * Process
    *
    * @return void
    */
    public function processAction()
    {
        $error = "None";
        
        try {
            $resizer = new Dlayer_Image_AdvancedResizer_Jpeg(200, 120, 100, 
            array('r'=>0, 'g'=>0, 'b'=>255));
            $resizer->loadImage('test.jpg', 
            'images/testing/thumbnail-advanced/');
            $resizer->resize();
        } catch (Exception $e) {
            $error = $e->getMessage();
        } 
        
        $this->view->error = $error;
    }
    
    /**
    * Load new thumbnail
    * 
    * @return void
    */
    public function deleteAction() 
    {
        $error = "None";
        
        if(file_exists(
        'images/testing/thumbnail-advanced/test-thumb.jpg') == TRUE) {
            $result = unlink(
            'images/testing/thumbnail-advanced/test-thumb.jpg');
            
            if($result == TRUE) {
                $this->_redirect('/dev/thumbnail-advanced/index');
            } else {
                 $error = "Delete failed";
            }
        } else {
            $error = "File doesn't exist, expected 
            'images/testing/thumbnail-advanced/test-thumb.jpg'";
        }
        
        $this->view->error = $error;
    }
}