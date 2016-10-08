<?php

/**
 * Custom session class for the content module, stores all the vars that we
 * need to manager the environment, attempting to not have any visible get vars
 * which may confused the user.
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Session_Content extends Zend_Session_Namespace
{
	/**
	 * @param string $namespace
	 * @param bool $singleInstance
	 * @return void
	 */
	public function __construct($namespace = 'dlayer_session_content',
		$singleInstance = FALSE)
	{
		parent::__construct($namespace, $singleInstance);

		$this->setExpirationSeconds(3600);
	}

	/**
	 * Set the id for the selected page
	 *
	 * @todo This should check validity
	 * @param integer $id
	 * @return void
	 */
	public function setPageId($id)
	{
		$this->page_id = intval($id);
	}

	/**
	 * Get the id of the page the user is working on
	 *
	 * @return integer|NULL
	 */
	public function pageId()
	{
		return $this->page_id;
	}

	/**
	 * Set a var to signify that the page is selected in the Content manager, when we set the page as selected we
	 * also set the selected column to 0, rows can be added to columns and the base page container so we use 0 to
	 * signify the page container
	 *
	 * @return void
	 */
	public function setPageSelected()
	{
		$this->page_selected = true;

		$this->setColumnId(0);
	}

	/**
	 * Check to see if the page is selected
	 *
	 * @todo Not keen on this returning TRUE|NULL, should be TRUE|FALSE based on method name although other methods return INT|NULL, review later
	 * @return TRUE|NULL
	 */
	public function pageSelected()
	{
		return $this->page_selected;
	}

	/**
	 * Set the id for the selected row. By default the id of any previously selected content will be cleared
	 *
	 * @todo This should check validity
	 * @param integer $id
	 * @param boolean $clear_content_id Clear the id of any previously selected content ids
	 * @return void
	 */
	public function setRowId($id, $clear_content_id = TRUE)
	{
		$this->row_id = intval($id);

		if($clear_content_id === TRUE)
		{
			$this->content_id = NULL;
		}
	}

	/**
	 * Get the id of the selected row
	 *
	 * @return integer|NULL
	 */
	public function rowId()
	{
		return $this->row_id;
	}

	/**
	 * Set the id for the selected column
	 *
	 * @todo This should check validity
	 * @param integer $id
	 * @return void
	 */
	public function setColumnId($id)
	{
		$this->column_id = intval($id);
	}

	/**
	 * Get the id of the selected column
	 *
	 * @return integer|NULL
	 */
	public function columnId()
	{
		return $this->column_id;
	}

	/**
	 * Clear the currently set content id value, content_id is set to NULL
	 *
	 * @return void
	 */
	public function clearContentId()
	{
		$this->content_id = NULL;
	}

	/**
	 * Set the id of the content item being selected aftre checking to ensure it the supplied params are valid
	 *
	 * @param integer $content_id
	 * @param string $content_type
	 * @return boolean
	 */
	public function setContentId($content_id, $content_type)
	{
		$session_dlayer = new Dlayer_Session();
		$model_content = new Dlayer_Model_Page_Content();

		if($model_content->validItem($content_id, $session_dlayer->siteId(), $this->pageId(), $this->columnId(),
			$content_type) === TRUE)
		{
			$this->content_id = intval($content_id);

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Get the id of the selected content block
	 *
	 * @return integer|NULL
	 */
	public function contentId()
	{
		return $this->content_id;
	}

	/**
	 * Set the selected tool, before setting we check to see if the requested tool is valid, a tool is a
	 * combination of a tool model, an option sub tool model and the tab itself
	 *
	 * @param string $tool Tool model name
	 * @return boolean
	 */
	public function setTool($tool)
	{
		$session_dlayer = new Dlayer_Session();
		$model_tool = new Dlayer_Model_Tool();

		$tool = $model_tool->toolAndDefaultTab($session_dlayer->module(), $tool);

		if($tool !== FALSE)
		{
			$this->tool = $tool['tool'];
			$this->setRibbonTab($tool['tab'], $tool['sub_tool']);

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Set the tool tab
	 *
	 * @param string $tab
	 * @param string|NULL $sub_tool
	 * @return void
	 */
	public function setRibbonTab($tab, $sub_tool=NULL)
	{
		$this->tab = $tab;
		$this->sub_tool = $sub_tool;
	}

	/**
	 * Returns the data array for the currently selected tool, if no tool is set the method returns FALSE, a tool is
	 * the combination of the tool itself and the selected tab
	 *
	 * @return array|FALSE
	 */
	public function tool()
	{
		if($this->tool !== NULL && $this->tab !== NULL)
		{
			return array(
				'tool' => $this->tool,
				'sub_tool' => $this->sub_tool, // Sub tool model can be NULL
				'tab' => $this->tab
			);
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Clears the session values for the content manager, these are the vars
	 * that relate to the current state of the designer, selected div,
	 * content row, content item, tool and tab.
	 *
	 * The page id and template id are left set, essentially the state of the
	 * designer is reset back to default
	 *
	 * @param boolean $reset If set to TRUE all the content session values are
	 *    cleared, this will include the page id and then template id
	 * @return void
	 */
	public function clearAll($reset = FALSE)
	{
		$this->page_selected = NULL;
		$this->column_id = NULL;
		$this->row_id = NULL;
		$this->content_id = NULL;

		$this->tool = NULL;
		$this->sub_tool = NULL;
		$this->tab = NULL;

		if($reset == TRUE)
		{
			$this->page_id = NULL;
		}
	}
}
