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
* @version $Id: ProcessController.php 1831 2014-05-12 21:44:14Z Dean.Blackborough $
*/
class Form_ProcessController extends Zend_Controller_Action
{
    /**
    * Type hinting for action helpers, hints the property to the code
    * hinting class which exists in the library
    *
    * @var Dlayer_Action_CodeHinting
    */
    protected $_helper;

    private $session_dlayer;
    private $session_form;

    private $debug;

    /**
    * @var Dlayer_Tool_Module_Form
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

    	$this->_helper->validateFormId();

        $this->_helper->disableLayout(FALSE);

        $this->debug = $this->getInvokeArg('bootstrap')->getOption('debug');

        $this->session_dlayer = new Dlayer_Session();
        $this->session_form = new Dlayer_Session_Form();
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
        $form_id = $this->checkFormIdValid($_POST['form_id']);

        $tool = $this->session_form->tool();

        // Check posted tool matches the tool currently set in the session
        if($tool == FALSE || ($_POST['tool'] != $tool['tool'])) {
            $this->returnToDesigner(FALSE);
        }

        // Check to see if we are in edit mode
        if(array_key_exists('field_id', $_POST) == FALSE) {
            $field_id = NULL;
        } else {
            $field_id = $this->checkFormFieldIdValid($_POST['field_id'],
            $_POST['form_id'], $_POST['field_type']);
        }
        
        // Instantiate base tool or sub tool
        $model_tools = new Dlayer_Model_Tool();
        
        if(array_key_exists('sub_tool_model', $_POST) == TRUE 
        && $model_tools->subToolValid($this->getRequest()->getModuleName(),
        $tool['tool'], $_POST['sub_tool_model']) == TRUE) {
			$tool_class = 'Dlayer_Tool_Form_' . $_POST['sub_tool_model'];
        } else {
			$tool_class = 'Dlayer_Tool_Form_' . $tool['model'];
        }
                        
        $this->tool_class = new $tool_class();

        if($this->tool_class->validate($_POST['params']) == TRUE) {
            $field_id = $this->tool_class->process(
            $this->session_dlayer->siteId(), $this->session_form->formId(),
            $field_id);
            
            if($field_id != NULL) {
                $this->session_form->setFieldId($field_id, 
                $_POST['field_type']);
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
                $this->_redirect('form/design/set-tool/tool/cancel');
            } else {
                $this->_redirect('form/design/');
            }
        }
    }

    /**
    * Check the form id, checks the database to ensure that the form id
    * exists and that it belongs to the given site
    *
    * @param string $form_id
    * @return integer|void Either returns the id of the form or redirects the
    *                      user cancelling the request
    */
    private function checkFormIdValid($form_id)
    {
        $model_form = new Dlayer_Model_Form();
        if($model_form->valid($form_id,
        $this->session_dlayer->siteId()) == TRUE) {
            return intval($form_id);
        } else {
            $this->returnToDesigner(FALSE);
        }
    }

    /**
    * Check to ensure that the id given is not only valid but belongs to the
    * given form and is of the requested type
    *
    * @param integer $field_id Id of the form field
    * @param integer $form_id Id of the form
    * @param string $field_type Field type that the id should relate to, for
    * 							example 'text'
    * @return integer|void Either returns the valid form field if or redirects
    *                      the user cancelling the request
    */
    private function checkFormFieldIdValid($field_id, $form_id, $field_type)
    {
        $model_form_field = new Dlayer_Model_Form_Field();
        if($model_form_field->valid($field_id,
        $this->session_dlayer->siteId(), $form_id, $field_type) == TRUE) {
            return intval($field_id);
        } else {
            $this->returnToDesigner(FALSE);
        }
    }
}