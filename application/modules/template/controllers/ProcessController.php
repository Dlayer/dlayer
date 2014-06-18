<?php
/**
* The process controller is where all the tools $_POST their data. 
* 
* The controller checks to see that the submitted tool is valid and then calls 
* the tool class. The validate method is called on the tool class to check 
* the submitted data. 
* 
* If the submitted data is valid the $_POST array is passed to the individial 
* tool class which does all the heaving lifting.
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: ProcessController.php 1228 2013-11-13 13:08:41Z Dean.Blackborough $
*/
class Template_ProcessController extends Zend_Controller_Action
{
    /**
    * Type hinting for action helpers, hints the property to the code
    * hinting class which exists in the library
    *
    * @var Dlayer_Action_CodeHinting
    */
    protected $_helper;

    private $session_dlayer;
    private $session_template;

    private $debug;

    /**
    * @var Dlayer_Tool_Module_Template
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
    	
    	$this->_helper->validateTemplateId();
    	
        $this->_helper->disableLayout(FALSE);

        $this->debug = $this->getInvokeArg('bootstrap')->getOption('debug');

        $this->session_dlayer = new Dlayer_Session();
        $this->session_template = new Dlayer_Session_Template();
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
        $id = $this->checkDivIdValid($this->getRequest()->getParam('id'));

        $tool = $this->session_template->tool();

        // Check posted tool matches the tool currently set in the session
        if($tool == FALSE || ($_POST['tool'] != $tool['tool'])) {
            $this->returnToDesigner(FALSE);
        }

        $tool_class = 'Dlayer_Tool_Template_' . $tool['model'];
        $this->tool_class = new $tool_class();

        if($this->tool_class->validate($_POST['params']) == TRUE) {
            $this->tool_class->process($this->session_dlayer->siteId(),
            $this->session_template->templateId(), $id);
            $this->returnToDesigner(TRUE);
        } else {
            $this->returnToDesigner(FALSE);
        }
    }

    /**
    * Check for div, converts the given string, pulling out what should be the
    * id for the div and then checks the database to see if the div exists
    * and belongs to this template.
    *
    * @param string $div_id
    * @return integer|void Either returns the id of the div or redirects the
    *                      user cancelling the request
    */
    private function checkDivIdValid($div_id)
    {
        $id = Dlayer_Helper::convertDivIdStringToId($div_id);

        if($id !== FALSE) {
            $model_template = new Dlayer_Model_View_Template();
            if($model_template->divExists($id,
            $this->session_template->templateId()) == TRUE) {
                return $id;
            } else {
                $this->returnToDesigner(FALSE);
            }
        } else {
            $this->returnToDesigner(FALSE);
        }
    }

    /**
    * Process method for the auto tools.
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
    public function autoToolAction()
    {
        $id = $this->checkDivIdValid($this->getRequest()->getParam('id'));

        $tool = $this->session_template->tool();

        if($tool == FALSE) {
            $this->returnToDesigner(FALSE);
        }

        $tool_class = 'Dlayer_Tool_Template_' . $tool['model'];
        $this->tool_class = new $tool_class();

        if($this->tool_class->autoValidate($_POST['params']) == TRUE) {
            $this->tool_class->autoProcess($this->session_dlayer->siteId(),
            $this->session_template->templateId(), $id);
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
                $this->_redirect('template/design/set-tool/tool/cancel');
            } else {
                $this->_redirect('template/design/');
            }
        }
    }
}