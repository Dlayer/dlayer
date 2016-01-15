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
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
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

		$this->_helper->disableLayout(FALSE);

		$this->debug = $this->getInvokeArg('bootstrap')->getOption('debug');

		$this->session_dlayer = new Dlayer_Session();
		$this->session_content = new Dlayer_Session_Content();
	}

	/**
	* Process method for all the manual tools, tools where the user will be 
	* supplying data.
	* 
	* We initially check to ensure that all the posted environment params 
	* match what is in the session and also that all the posted values are 
	* valid
	* 
	* Once the posted required has been confirmed as valid the submitted params 
	* are validated by the tool class, initially to ensure the correct 
	* fields have been posted and then to ensure that the posted values 
	* are valid or within the expected range
	* 
	* Assuming all the posted data is valid the process method for the tool is 
	* called, the process method handles all database changes
	* 
	* In all cases the user is returned back to the designer, the only 
	* difference in whether state is maintained, that depends both on whether 
	* the request was valid and the multi use param for the tool
	*
	* @return void Redirect the user back to the designer
	*/
	public function toolAction()
	{
		$site_id = $this->session_dlayer->siteId();

		$page_id = $this->validatePageId($_POST['page_id']);
		$div_id = $this->validateDivId($_POST['div_id'], $page_id);
		$content_row_id = $this->validateContentRowId($page_id, $div_id, 
			$_POST['content_row_id']);
		$tool = $this->validateTool($_POST['tool']);
		$content_id = $this->contentId($site_id, $page_id, $div_id, 
			$content_row_id, $_POST);
			
		// Instantiate the tool class, checks to see if we are instantiating 
		// a base tool or sub tool
		$model_tools = new Dlayer_Model_Tool();

		if(array_key_exists('sub_tool_model', $_POST) == TRUE 
			&& $model_tools->subToolValid($this->getRequest()->getModuleName(),
				$tool['tool'], $_POST['sub_tool_model']) == TRUE) {
				$tool_class = 'Dlayer_Tool_Content_' . $_POST['sub_tool_model'];
		} else {
			$tool_class = 'Dlayer_Tool_Content_' . $tool['model'];
		}

		$this->tool_class = new $tool_class();
		
		if($this->tool_class->validate($_POST['params'], $site_id, $page_id, 
			$div_id, $content_row_id, $content_id) == TRUE) {
				
			$content_id = $this->tool_class->process($site_id, $page_id,
				$div_id, $content_row_id, $content_id);
				
			$this->session_content->setContentId($content_id, 
				$_POST['content_type']);

			$this->returnToDesigner(TRUE);
		} else {
			$this->returnToDesigner(FALSE);
		}
	}
	
	/**
	* Check for a content id in the posted data array, if found check that it 
	* is valid.
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id 
	* @param integer $content_row_id
	* @param array $post Posted data array
	* @return integer|NULL The content id or NULL
	*/
	private function contentId($site_id, $page_id, $div_id, $content_row_id, 
		$post) 
	{
		if(array_key_exists('content_id', $post) == FALSE) {
			$content_id = NULL;
		} else {
			$content_id = $this->validateContentId($site_id, $page_id, $div_id,
				$content_row_id, $post['content_id'], $post['content_type']);
		}
		
		return $content_id;
	}

	/**
	* Process method for the auto tools.
	* 
	* Simpler than the standard tool action because the auto tool action tools 
	* don't take into account any user input, the tools don't also manage 
	* items so there is no concept of an edit mode.
	* 
	* Typical uses in the content manager are the structure tools.
	*
	* @return void
	*/
	public function autoToolAction()
	{
		$site_id = $this->session_dlayer->siteId();

		$page_id = $this->validatePageId($_POST['page_id']);
		$div_id = $this->validateDivId($_POST['div_id'], $page_id);		
		$tool = $this->validateTool($_POST['tool']);
		
		$content_row_id = NULL;
		
		// Validate and set content row id if set
		if(array_key_exists('content_row_id', $_POST) == TRUE) {
			$content_row_id = intval($_POST['content_row_id']);
		}

		// Instantiate the tool class, checks to see if we are instantiating 
		// a base tool or sub tool
		$model_tools = new Dlayer_Model_Tool();

		if(array_key_exists('sub_tool_model', $_POST) == TRUE 
			&& $model_tools->subToolValid($this->getRequest()->getModuleName(),
				$tool['tool'], $_POST['sub_tool_model']) == TRUE) {
				$tool_class = 'Dlayer_Tool_Content_' . $_POST['sub_tool_model'];
		} else {
			$tool_class = 'Dlayer_Tool_Content_' . $tool['model'];
		}

		$this->tool_class = new $tool_class();
		
		/**
		* Run the validation meton on the requested tool, if the result comes 
		* back as TRUE process the request
		*/
		if($this->tool_class->autoValidate($_POST['params'], $site_id, 
		$page_id, $div_id, $content_row_id) == TRUE) {

			/**
			* Auto tool can return multiple ids, session values are 
			* cleared and then returned values are set
			*/
			$return_ids = $this->tool_class->autoProcess($site_id, 
				$page_id, $div_id, $content_row_id);

			// Clear session vars
			$this->session_content->clearAll();

			// Set new vars
			foreach($return_ids as $id) {
				
				switch($id['type']) {
					case 'div_id':
						$this->session_content->setDivId($id['id']);
						break;

					case 'content_row_id':
						$this->session_content->setContentRowId($id['id']);
						break;
						
					case 'content_id':
						$this->session_content->setContentId($id['id'], 
							$id['content_type']);
						break;
						
					case 'tool':
						$this->session_content->setTool($id['id']);
						break;
						
					case 'tab':
						$this->session_content->setRibbonTab($id['id']);
						break;
						
					default:
						break;
				}
			}

			$this->returnToDesigner(TRUE, FALSE);
		} else {
			$this->returnToDesigner(FALSE);
		}
	}

	/**
	* Redirect the user back to the designer
	* 
	* The redirect will call the cancel tool to clear session values for
	* most redirects but this can be overridden by the clear paramn
	* 
	* If the debug param is set this method will not redirect the user leaving 
	* it on the process page, useful for debugging
	* 
	* @param boolean $success Whether the request is considered successful
	* @param boolean $clear Do we want to clear params, only called by certain 
	* 	single use tools, example being content row, we want to clear all 
	* 	params but we set a couple before returning the user to the designer
	* @return void
	*/
	public function returnToDesigner($success=TRUE, $clear=TRUE)
	{
		$multi_use = FALSE;

		if(array_key_exists('params', $_POST) == TRUE &&
		array_key_exists('multi_use', $_POST['params']) == TRUE
		&& $_POST['params']['multi_use'] == 1) {
			$multi_use = TRUE;
		}
		
		if($this->debug == 0) {
			if($multi_use == FALSE) {
				if($clear==TRUE) {
					$this->_redirect('content/design/set-tool/tool/cancel');
				} else {
					$this->_redirect('content/design/');	
				}
			} else {
				$this->_redirect('content/design/');			
			}
		}
	}

	/**
	* Check to ensure that the posted tools matches the tool defined in the 
	* session
	* 
	* @param string $tool_name Name of posted tool
	* @return array|void Either returns the tool data array or redirtects the 
	* 	user back to the designer after calling the cancel tool
	*/
	private function validateTool($name) 
	{
		$tool = $this->session_content->tool();

		if($tool != FALSE && $tool['tool'] == $name) {
			return $tool;
		} else {
			$this->returnToDesigner(FALSE);
		}
	}

	/**
	* Check to make sure the supplied page id is valid, session value needs 
	* to match the posted value and the page id needs to belong to the site id 
	* stored in the session
	*
	* @param integer $page_id
	* @return integer|void Either returns the intval for the currently set 
	* 	page id or redirects the user back to the designer after calling the 
	* 	cancel tool
	*/
	private function validatePageId($page_id)
	{
		$model_page = new Dlayer_Model_Page();

		if($this->session_content->pageId() == $page_id && 
			$model_page->valid($page_id, 
				$this->session_dlayer->siteId()) == TRUE) {

				return intval($page_id);
		} else {
			$this->returnToDesigner(FALSE);
		}
	}

	/**
	* Check to make sure that the posted div id matches the value stored in 
	* the session and also belongs to the requested page and site
	* 
	* @param integer $div_id
	* @param integer $page_id
	* @return integer|void Either returns the intval for the supplied div id 
	* 	or redirects the user back to the designer after calling the cancel
	* 	tool
	*/
	private function validateDivId($div_id, $page_id)
	{
		$model_page = new Dlayer_Model_Page();

		if($this->session_content->divId() == $div_id && 
		$model_page->divValid($div_id, $page_id) == TRUE) {

			return intval($div_id);
		} else {
			$this->returnToDesigner(FALSE);
		}
	}

	/**
	* Validate the posted content row id, needs to match the value stored in 
	* the session and also belong to the page, div_id and lastly site
	* 
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @return integer|void Either returns the intval for the content row id 
	* 	or redirects the user back to the designer after calling the cancel 
	* 	tool
	*/
	private function validateContentRowId($page_id, $div_id, $content_row_id) 
	{
		$model_content = new Dlayer_Model_Page_Content();
		
		if($this->session_content->contentRowId() == $content_row_id && 
			$model_content->validContentRowId($this->session_dlayer->siteId(), 
				$page_id, $div_id, $content_row_id) == TRUE) {
			
			return intval($content_row_id);
		} else {
			$this->returnToDesigner(FALSE);
		}
	}

	/**
	* Check to see if the content id valid, it needs to belong to the 
	* content row id, div id, page and site
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @param integer $content_id
	* @param string $content_type
	* @return integer|void Either retruns the content id or redirects the 
	* 	user back to the designer after calling the cancel tool
	*/
	private function validateContentId($site_id, $page_id, $div_id, 
		$content_row_id, $content_id, $content_type)
	{
		$model_page = new Dlayer_Model_Page();
		
		if($model_page->contentIdValid($site_id, $page_id, $div_id, 
			$content_row_id, $content_id, $content_type) == TRUE) {
				
			return intval($content_id);
		} else {
			$this->returnToDesigner(FALSE);
		}
	}
}