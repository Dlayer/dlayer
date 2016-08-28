<?php

/**
 * Import form tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Tool_Content_Form extends Dlayer_Tool_Content
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

		if(array_key_exists('form_id', $params) === TRUE)
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

		$model_forms = new Dlayer_Model_Page_Content_Items_Form();

		if(intval($params['form_id']) > 0 && $model_forms->valid($this->site_id, $params['form_id']) === TRUE)
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
			'form_id' => intval($params['form_id'])
		);
	}

	/**
	 * Validate the instances param, need to see if it should exist first
	 *
	 * @param integer site_id
	 * @param integer $content_id
	 * @return boolean
	 */
	protected function validateInstances($site_id, $content_id)
	{
		return FALSE;
	}

	/**
	 * Add a new content item or setting
	 *
	 * @return array|FALSE Ids for new environment vars or FALSE if the request failed
	 */
	protected function add()
	{
		$model_content = new Dlayer_Model_Page_Content();

		$content_id = $model_content->addContentItem($this->site_id, $this->page_id, $this->column_id, 'form',
			$this->params);

		if($content_id !== FALSE)
		{
			return $this->returnIds($content_id);
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Edit a new content item or setting
	 *
	 * @return array|FALSE Ids for new environment vars or FALSE if the request failed
	 * @throws Exception
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
		// TODO: Implement structure() method.
	}

	/**
	 * Generate the return ids array
	 *
	 * @param integer|NULL Set content id or use the class property
	 * @return array
	 */
	protected function returnIds($content_id = NULL)
	{
		if($content_id !== NULL)
		{
			$this->content_id = $content_id;
		}

		return array(
			array(
				'type' => 'page_id',
				'id' => $this->page_id,
			),
			array(
				'type' => 'row_id',
				'id' => $this->row_id,
			),
			array(
				'type' => 'column_id',
				'id' => $this->column_id,
			),
			array(
				'type' => 'tool',
				'id' => 'import-form',
			),
			array(
				'type' => 'content_id',
				'id' => $this->content_id,
				'content_type' => 'form'
			)
		);
	}
}
