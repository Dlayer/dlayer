<?php
/**
* Controller for crop image development
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dev_CropController extends Zend_Controller_Action
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
            $copper = new Dlayer_Image_Crop_Jpeg(601, 0, 300, 300, 100);
            $copper->loadImage('test.jpg', 'images/testing/crop/');
            $copper->crop('-cropped');
        } catch (Exception $e) {
            $error = $e->getMessage();
        } 
        
        $this->view->error = $error;
    }
    
    /**
    * Delete the thumbnail
    * 
    * @return void
    */
    public function deleteAction() 
    {
        $error = "None";
        
        if(file_exists(
        'images/testing/crop/test-cropped.jpg') == TRUE) {
            $result = unlink(
            'images/testing/crop/test-cropped.jpg');
            
            if($result == TRUE) {
                $this->_redirect('/dev/crop/index');
            } else {
                 $error = "Delete failed";
            }
        } else {
            $error = "File doesn't exist, expected 
            ''images/testing/crop/test-cropped.jpg''";
        }
        
        $this->view->error = $error;
    }
}