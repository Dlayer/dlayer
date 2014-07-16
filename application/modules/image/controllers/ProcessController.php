<?php
/**
* The process controller is where all the tools $_POST their data.
*
* The controller checks to see that the submitted tool is valid and then calls
* the tool class. The validate method is called on the tool class to check
* the submitted data.
*
* If the submitted data is valid the $_POST array is passed to the individial
* tool class which does all the heavy lifting.
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Image_ProcessController extends Zend_Controller_Action
{
    /**
    * Type hinting for action helpers, hints the property to the code
    * hinting class which exists in the library
    *
    * @var Dlayer_Action_CodeHinting
    */
    protected $_helper;

    private $session_dlayer;
    private $session_image;

    private $debug;

    /**
    * @var Dlayer_Tool_Module_Image
    */
    private $tool_class;

    /**
    * Init the controller, run any set up code required by all the actions
    * in the controller
    *
    * @return void
    */
    public function init()
    {
        $this->_helper->authenticate();

        $this->_helper->setModule();

        $this->_helper->validateSiteId();

        $this->_helper->disableLayout(FALSE);

        $this->debug = $this->getInvokeArg('bootstrap')->getOption('debug');

        $this->session_dlayer = new Dlayer_Session();
        $this->session_image = new Dlayer_Session_Image();
    }

    /**
    * Process method for the manual tools.
    *
    * Checks to see if the posted tool matches the tool that is set in the
    * session. If the posted tool is valid the tool class is instantiated.
    *
    * The $_POSTED values are then validated and prepared by the class. The
    * prepare method converts the data types once they values have been
    * confirmed
    *
    * @return void
    */
    public function toolAction()
    {
        $tool = $this->session_image->tool();

        // Check posted tool matches the tool currently set in the session
        if($tool == FALSE || ($_POST['tool'] != $tool['tool'])) {
            $this->returnToDesigner(FALSE);
        }
        
        $image_id = NULL;
        $category_id = NULL;
        $sub_category_id = NULL;
        
        // Check to see if any of the id params exist, if so pass them into 
        // the tool 
        if(array_key_exists('image_id', $_POST) == TRUE) {
            $image_id = $_POST['image_id'];
        }
        if(array_key_exists('category_id', $_POST) == TRUE) {
            $category_id = $_POST['category_id'];
        }
        if(array_key_exists('sub_category_id', $_POST) == TRUE) {
            $sub_category_id = $_POST['sub_category_id'];
        }
        if(array_key_exists('version_id', $_POST) == TRUE) {
            $version_id = $_POST['version_id'];
        }
        
        // Instantiate base tool or sub tool
        $model_tools = new Dlayer_Model_Tool();
        
        if(array_key_exists('sub_tool_model', $_POST) == TRUE 
        && $model_tools->subToolValid($this->getRequest()->getModuleName(),
        $tool['tool'], $_POST['sub_tool_model']) == TRUE) {
            $tool_class = 'Dlayer_Tool_Image_' . $_POST['sub_tool_model'];
        } else {
            $tool_class = 'Dlayer_Tool_Image_' . $tool['model'];
        }
                        
        $this->tool_class = new $tool_class();
        
        if($this->tool_class->validate($_POST['params'], 
        $this->session_dlayer->siteId(), $category_id, $sub_category_id, 
        $image_id) == TRUE) {
            
            $return_id = $this->tool_class->process();
            
            if(is_array($return_id) && 
            array_key_exists('id', $return_id) == TRUE && 
            array_key_exists('type', $return_id) == TRUE) {
                $this->session_image->setImageId($return_id['id'], 
                $return_id['type']);
            }

            $this->returnToDesigner(TRUE);
        } else {            
            $this->returnToDesigner(FALSE);
        }
    }

    /**
    * Redirect the user, were we redirect depends upon whether the previous
    * request was successful. The redirect method is mainly for the auto tools,
    * the manual tools just need to clear the session values
    *
    * @todo Put in error redirect, need to log messages
    *
    * @param boolean $success
    * @return void
    */
    public function returnToDesigner($success=TRUE)
    {
        $multi_use = FALSE;

        if(array_key_exists('params', $_POST) == TRUE &&
        array_key_exists('multi_use', $_POST['params']) == TRUE
        && $_POST['params']['multi_use'] == 1) {
            $multi_use = TRUE;
        }

        if($this->debug == 0) {
            if($multi_use == FALSE) {
                $this->_redirect('image/design/set-tool/tool/cancel');
            } else {
                $this->_redirect('image/design/');
            }
        }
    }
}