<?php

/**
 * Text content item tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Tool_Content_Text extends Dlayer_Tool_Handler_Content
{

	/**
	 * Check that the required params have been submitted, check the keys in the params array
	 *
	 * @param array $params
	 * @return boolean
	 */
	protected function paramsExist(array $params)
	{
		$valid = FALSE;
		if(array_key_exists('name', $params) === TRUE && array_key_exists('content', $params) === TRUE)
		{
			$valid = TRUE;
		}

		return $valid;
	}

	/**
	 * Check to ensure the posted params are of the correct type and optionally within range
	 *
	 * @param array $params
	 * @return boolean
	 */
	protected function paramsValid(array $params)
	{
		$valid = FALSE;
		if(strlen(trim($params['name'])) > 0 && strlen(trim($params['content'])) > 0)
		{
			$valid = TRUE;
		}
		return $valid;
	}

	/**
	 * Prepare the posted params, convert them to the required types and assign to the $this->params property
	 *
	 * @param array $params
	 * @param boolean $manual_tool Are the values to be assigned to $this->params or $this->params_auto
	 * @return void
	 */
	protected function paramsAssign(array $params, $manual_tool = TRUE)
	{
		$this->params = array(
			'name' => trim($params['name']),
			'content' => trim($params['content'])
		);
	}

	/**
	 * Add a new content item or setting
	 *
	 * @return integer|FALSE Id of the content item created or id of the content item setting belongs to
	 */
	protected function add()
	{
		// TODO: Implement add() method.
	}

	/**
	 * Edit a new content item or setting
	 *
	 * @return integer|FALSE Id of the content item being edited or id of the content item the changed setting
	 * belongs to
	 */
	protected function edit()
	{
		// TODO: Implement edit() method.
	}

	/**
	 * Make a structural change to the page
	 *
	 * @return array|FALSE An array of the environment vars to set or FALSE upon error
	 */
	protected function structure()
	{
		// Not required by manual tool
	}
}
