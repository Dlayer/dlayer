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

		$this->debug = intval($this->getInvokeArg('bootstrap')->getOption('debug'));
		//$this->debug = 0;
	}

	/**
	 * Get a post param
	 *
	 * @todo Move this out of controller
	 * @param string $param
	 * @param integer|NULL $default
	 * @return integer|NULL
	 */
	private function getPostAsInteger($param, $default = NULL)
	{
		return ($this->getRequest()->getPost($param) !== '' ? intval($this->getRequest()->getPost($param)) : $default);
	}

	/**
	 * Get a post param
	 *
	 * @todo Move this out of controller
	 * @param string $param
	 * @param integer|NULL $default
	 * @return string|NULL
	 */
	private function getPostAsString($param, $default = NULL)
	{
		return $this->getRequest()->getPost($param, $default);
	}

	/**
	 * Validate the request, checks the tool is valid and the base environment params are correct. Values should be
	 * validated before they get set in session so we can simply check they match here
	 *
	 * @param Dlayer_Session_Content $session_content
	 * @todo Need to add logging so can easily see where errors occurred
	 * @return boolean
	 */
	private function validateRequest($session_content)
	{
		if($session_content->pageId() === $this->getPostAsInteger('page_id') &&
			$session_content->rowId() === $this->getPostAsInteger('row_id') &&
			$session_content->columnId() === $this->getPostAsInteger('column_id') &&
			$session_content->contentId() === $this->getPostAsInteger('content_id') &&
			$session_content->tool() !== FALSE &&
			$session_content->tool()['tool'] === $this->getPostAsString('tool'))
		{
			return TRUE;
		}
		else
		{
			// Add logging
			return FALSE;
		}
	}

	/**
	 * Fetch the tool class, either returns the tool defined in the session of the tool for the posted sub tool
	 *
	 * @param string $sub_tool_model
	 * @return Dlayer_Tool_Content
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

				case 'content_id':
					$session_content->setContentId($id['id'], $id['content_type']);
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
	 * Process method for the manual tools, manual tools are any tools where the user has to provide input which needs
	 * validating. Assuming the environment params are correct and they match the corresponding session values we
	 * simply pass the request off to the tool class.
	 * In all cases, success and failure, the user is returned back to the designer, the only difference being
	 * whether the state of the designer is maintained, that depends on the success of the request and whether the
	 * tool is multi-use or not
	 *
	 * @return void
	 */
	public function toolAction()
	{
		$session_dlayer = new Dlayer_Session();
		$session_content = new Dlayer_Session_Content();

		if($this->validateRequest($session_content) === FALSE)
		{
			$this->returnToDesigner(FALSE);
		}

		$tool = $this->toolClass($this->_request->getParam('sub_tool_model'));

		if($tool->validate($this->getRequest()->getPost('params'), $session_dlayer->siteId(),
				$session_content->pageId(), $session_content->rowId(), $session_content->columnId(),
				$session_content->contentId()) === TRUE)
		{
			$return_ids = $tool->process();

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
	 * Process method for the auto tools, auto tools affect the structure of a page and can set multiple ids after
	 * processing
	 *
	 * @return void
	 */
	public function toolAutoAction()
	{
		$session_dlayer = new Dlayer_Session();
		$session_content = new Dlayer_Session_Content();

		if($this->validateRequest($session_content) === FALSE)
		{
			$this->returnToDesigner(FALSE);
		}

		$tool = $this->toolClass($this->_request->getParam('sub_tool_model'));

		if($tool->validateAuto($this->getRequest()->getPost('params'), $session_dlayer->siteId(),
				$session_content->pageId(), $session_content->rowId(), $session_content->columnId(),
				$session_content->contentId()) === TRUE)
		{
			$return_ids = $tool->processAuto();

			if($return_ids !== FALSE)
			{
				$this->setEnvironmentIds($return_ids);

				/**
				 * Multi use does not really apply to structure tools so not calling returnToDesigner, will review
				 * that as we and more tools, may just need another param for the method
				 *
				 * @todo Review this
				 */
				$this->redirect('content/design');
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
		if($success === FALSE)
		{
			$this->redirect('content/design/set-tool/tool/cancel');
		}

		if($this->debug === 1)
		{
			exit();
		}

		$multi_use = $this->getPostAsInteger('multi_use');

		if($multi_use !== NULL && $multi_use === 1)
		{
			$this->redirect('content/design');
		}
		else
		{
			$this->redirect('content/design/set-tool/tool/cancel');
		}
	}
}
