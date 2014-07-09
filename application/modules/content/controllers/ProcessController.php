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
* @version $Id: ProcessController.php 1738 2014-04-17 15:44:36Z Dean.Blackborough $
*/
class Content_ProcessController extends Zend_Controller_Action
{
    /**
    * Type hinting for action helpers, hints the property to the code
    * hinting class which exists in the library
    *
    * @var Dlayer_Action_CodeHinting
    */
    protected $_helper;

    private $session_dlayer;
    private $session_content;

    private $debug;

    /**
    * @var Dlayer_Tool_Module_Content
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
    	
    	$this->_helper->validateTemplateId(TRUE);
    	
    	$this->_helper->validateContentId();
    	
        $this->_helper->disableLayout(FALSE);

        $this->debug = $this->getInvokeArg('bootstrap')->getOption('debug');

        $this->session_dlayer = new Dlayer_Session();
        $this->session_content = new Dlayer_Session_Content();
    }

    /**
    * Process method for all manuakl tools, tools for which the user needs to 
    * supply data.
    * 
    * First check to ensure the posted tool and environment values are correct, 
    * tool is then validated and a check is also made to see if a sub tool is 
    * being used.
    * 
    * Once the tool has been confirmed to be valid the submitted params are 
    * validated, first check ensures the correct values are posted, second 
    * check looks at the values themselves and where necessary the data.
    * 
    * Assuming all the submitted data is valid the data is passed to the tool 
    * and then the process method is called.
    * 
    * In all cases the user is returned back the designer, how depends on 
    * whether the request is valid and the return params for the tool.
    *
    * @return void
    */
    public function toolAction()
    {
        $page_id = $this->checkPageIdValid($_POST['page_id']);
        $div_id = $this->checkDivIdValid($_POST['div_id'], $page_id);

        $tool = $this->session_content->tool();

        // Check posted tool matches the tool currently set in the session
        if($tool == FALSE || ($_POST['tool'] != $tool['tool'])) {
            $this->returnToDesigner(FALSE);
        }
        
        // Check to see if we are in edit mode, if so we will have a content id
        if(array_key_exists('content_id', $_POST) == FALSE) {
            $content_id = NULL;
        } else {
            $content_id = $this->checkContentIdValid($_POST['content_id'],
            $page_id, $div_id, $_POST['content_type']);
        }
        
        // Instantiate base tool or sub tool
        $model_tools = new Dlayer_Model_Tool();
        
        if(array_key_exists('sub_tool_model', $_POST) == TRUE 
        && $model_tools->subToolValid($this->getRequest()->getModuleName(),
        $tool['tool'], $_POST['sub_tool_model']) == TRUE) {
			$tool_class = 'Dlayer_Tool_Content_' . $_POST['sub_tool_model'];
        } else {
			$tool_class = 'Dlayer_Tool_Content_' . $tool['model'];
        }
                        
        $this->tool_class = new $tool_class();
        
        // Run the tool if validation passes
        if($this->tool_class->validate($_POST['params'], 
        $this->session_dlayer->siteId(), $page_id, $div_id) == TRUE) {
            $content_id = $this->tool_class->process(
            $this->session_dlayer->siteId(), $page_id, $div_id, $content_id);
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
    * @todo Maybe update this for when we don't want to keep everything 
    * selected, maybe just the selected div
    *
    * @param boolean $success Whether the request is considered successful
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
                $this->_redirect('content/design/set-tool/tool/cancel');
            } else {
                $this->_redirect('content/design/');
            }
        }
    }

    /**
    * Check the page id
    *
    * Check that the page id is valid and belongs to the given site
    *
    * @param integer $page_id
    * @return integer|void Either returns the valid id or redirects the user
    *                      cancelling their request.
    */
    private function checkPageIdValid($page_id)
    {
        $model_page = new Dlayer_Model_Page();
        if($model_page->valid($page_id,
        $this->session_dlayer->siteId()) == TRUE) {
            return intval($page_id);
        } else {
            $this->returnToDesigner(FALSE);
        }
    }

    /**
    * Check the div id
    *
    * Check that the div id is valid and belongs to the given page and
    * template
    *
    * @param integer $div_id
    * @param integer $page_id
    * @return integer|void Either returns the valid id or redirects the user
    *                      cancelling their request.
    */
    private function checkDivIdValid($div_id, $page_id)
    {
        $model_page = new Dlayer_Model_Page();
        if($model_page->divValid($div_id, $page_id) == TRUE) {
            return intval($div_id);
        } else {
            $this->returnToDesigner(FALSE);
        }
    }

    /**
    * Check to see if the content id is valid. The content id has to
    * belong to the requested page, be for the requested div and also be the
    * correct type of content
    *
    * @param integer $content_id
    * @param integer $page_id
    * @param integer $div_id
    * @param string $content_type
    * @return integer|void Returns the valid content id or redirects the user
    *                      cancelling their request
    */
    private function checkContentIdValid($content_id, $page_id, $div_id,
    $content_type)
    {
        $model_page = new Dlayer_Model_Page();
        if($model_page->contentValid($content_id, $page_id, $div_id,
        $content_type) == TRUE) {
            return intval($content_id);
        } else {
            $this->returnToDesigner(FALSE);
        }
    }
}