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

	private $debug;

	/**
	* Init the controller, run any set up code required by all the actions
	* in the controller
	*
	* @return void
	*/
	public function init()
	{
		$this->_helper->authenticate();

		/**
		 * @todo Not happy with this, needs a better name, not clear what it does
		 */
		$this->_helper->setModule();

		$this->_helper->disableLayout(FALSE);

		$this->debug = $this->getInvokeArg('bootstrap')->getOption('debug');
	}

	/**
	 * Validate the request, checks the tool is valid and the base environment params are correct. Values should be
	 * validated before they get set in session so we can simply check they match here
	 *
	 * @param Dlayer_Session_Content $session_content
	 * @todo Need to add logging so can easily see where errors occurred
	 * @return void
	 */
	private function validateRequest($session_content)
	{
		if($session_content->pageId() !== $this->_getParam('page_id')) ;
		{
			$this->returnToDesigner(FALSE);
		}

		if($session_content->tool() === FALSE || $session_content->tool()['tool'] !== $this->_getParam('tool'))
		{
			$this->returnToDesigner(FALSE);
		}

		if($session_content->rowId() !== $this->_getParam('row_id'))
		{
			$this->returnToDesigner(FALSE);
		}

		if($session_content->columnId() !== $this->_getParam('column_id', 0))
		{
			$this->returnToDesigner(FALSE);
		}

		if($session_content->columnId() !== $this->_getParam('content_id'))
		{
			$this->returnToDesigner(FALSE);
		}
	}

	/**
	 * Fetch the tool class, either returns the tool defined in the session of the tool for the posted sub tool
	 *
	 * @param string $sub_tool_model
	 * @return Dlayer_Tool_Module_Content
	 */
	private function toolClass($sub_tool_model = NULL)
	{
		$session_content = new Dlayer_Session_Content();
		if($sub_tool_model !== NULL)
		{
			$tool_class = 'Dlayer_Tool_Content_' . $sub_tool_model;
		}
		else
		{
			$tool_class = 'Dlayer_Tool_Content_' . $session_content->tool()['model'];
		}

		return new $tool_class();
	}

	/**
	 * Set the environment id
	 *
	 * @param array $environment_ids
	 * @return void
	 */
	private function setEnvironmentIds(array $environment_ids)
	{
		$session_content = new Dlayer_Session_Content();
		$session_content->clearAll();

		foreach($environment_ids as $id)
		{
			switch($id['type'])
			{
				case 'page_id':
					$session_content->setPageId($id['id']);
					$session_content->setPageSelected();
				break;

				case 'row_id':
					$session_content->setRowId($id['id']);
				break;

				case 'column_id':
					$session_content->setColumnId($id['id']);
				break;

				case 'tool':
					$session_content->setTool($id['id']);
				break;

				default:
				break;
			}
		}
	}

	/**
	 * Process method for the manual tools, manual tools are any tools where the user provides input. Assuming the
	 * environment params are correct and match the session values we simply pass the request of to the tool class.
	 * In all cases, tool success/failure the user is always returned back to the designer, the only difference being
	 * whether the state of the designer is maintained, depends on the success of the tool and validation and whether or 
	 * not the tool is a multi-use tool
	 *
	 * @todo Method on flux whilst I rework the tools, also, some tools should be auto tools (add-row), they will
	 * return to being auto tools when I confirm that everything is working correctly
	 * @return void
	 */
	public function toolAction()
	{
		$session_dlayer = new Dlayer_Session();
		$session_content = new Dlayer_Session_Content();
		$this->validateRequest($session_content);

		$tool = $this->toolClass($this->_request->getParam('sub_tool_model'));

		if($tool->validateAuto($this->_request->getParams(), $session_dlayer->siteId(), $session_content->pageId(),
				$session_content->rowId(), $session_content->columnId(), $session_content->contentId()) === TRUE)
		{
			$return_ids = $tool->processAuto();
			
			if($return_ids !== FALSE) 
			{
				$this->setEnvironmentIds($return_ids);

				$this->returnToDesigner(TRUE);
			} 
			else 
			{
				$this->returnToDesigner(FALSE);
			}
		}
	}

	/**
	 * Redirect the user back to the designer, will call the cancel tool to clear all environment variables unless the
	 * tool is marked as multi use
	 *
	 * If the debug param is set the redirect will not occur, will remain on process action so errors can be shown
	 *
	 * @todo Need to add logging, success does nothing
	 * @param boolean $success Whether or not the request should be considered successful
	 * @return void
	 */
	public function returnToDesigner($success=TRUE)
	{
		$multi_use = $this->_request->getParam('multi_use');

		if($this->debug === 1)
		{
			exit();
		}
		else if ($multi_use !== NULL && $multi_use === 1)
		{
			$this->redirect('content/design');
		}
		else
		{
			$this->redirect('content/design/set-tool/tool/cancel');
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
