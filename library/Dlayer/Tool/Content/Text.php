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
	 * @return array|FALSE Id for new environment vars or FALSE if the request failed
	 */
	protected function add()
	{
		$model_content = new Dlayer_Model_Page_Content();

		$content_id = $model_content->addContentItem($this->site_id, $this->page_id, $this->column_id, 'text',
			$this->params);

		if($content_id !== FALSE)
		{
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
					'id' => 'row',
				),
				array(
					'type' => 'content_id',
					'id' => $content_id=NULL,
					'content_type' => 'text'
				)
			);
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Edit a new content item or setting
	 *
	 * @return array|FALSE Id for new environment vars or FALSE if the request failed
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
