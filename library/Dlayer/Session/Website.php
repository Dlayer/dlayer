<?php

/**
 * Custom session class for the web site module, store vars which we need to
 * manage the environment, attemping to not have visible get vars so this class
 * will deal with the values
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Session_Website extends Zend_Session_Namespace
{
	/**
	 * @param string $namespace
	 * @param bool $singleInstance
	 *
	 * @return void
	 */
	public function __construct($namespace = 'dlayer_session_website',
		$singleInstance = FALSE)
	{
		parent::__construct($namespace, $singleInstance);

		$this->setExpirationSeconds(3600);
	}

	/**
	 * Set the id for the page that the user wants to manage
	 *
	 * @todo Need to check that the page id is valid
	 *
	 * @param integer $id
	 *
	 * @return void
	 */
	public function setPageId($id)
	{
		$this->page_id = intval($id);
	}

	/**
	 * Get the id of the page that the user is currently working on
	 *
	 * @return integer|NULL
	 */
	public function pageId()
	{
		return $this->page_id;
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
	 * Clears the session values for the web site manager, these are the vars
	 * that relate to the current state of the designer, selected page,
	 * tool and tool tab.
	 *
	 * @return void
	 */
	public function clearAll($reset = FALSE)
	{
		$this->tool = NULL;
		$this->sub_tool = NULL;
		$this->tab = NULL;
		$this->page_id = NULL;
	}
}
