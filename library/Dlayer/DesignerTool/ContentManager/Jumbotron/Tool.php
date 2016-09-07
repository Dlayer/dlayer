<?php

/**
 * Jumbotron content item tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Jumbotron_Tool extends Dlayer_Tool_Content
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

		if(array_key_exists('name', $params) === TRUE && array_key_exists('title', $params) === TRUE &&
			array_key_exists('intro', $params) === TRUE && array_key_exists('button_label', $params) === TRUE)
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
		if(strlen(trim($params['name'])) > 0 && strlen(trim($params['title'])) > 0 &&
			strlen(trim($params['intro'])) >= 0 && strlen(trim($params['button_label'])) >= 0)
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
			'title' => trim($params['title']),
			'intro' => trim($params['intro']),
			'button_label' => $params['button_label']
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
		$model_jumbotron = new Dlayer_DesignerTool_ContentManager_Jumbotron_Model();
		$instances = $model_jumbotron->instancesOfData($site_id, $content_id);

		if($instances > 1)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Add a new content item or setting
	 *
	 * @return array|FALSE Ids for new environment vars or FALSE if the request failed
	 */
	protected function add()
	{
		$content_id = $this->addContentItem('jumbotron');

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
		$model_content_jumbotron = new Dlayer_DesignerTool_ContentManager_Jumbotron_Model();

		try
		{
			$edit = $model_content_jumbotron->edit($this->site_id, $this->page_id, $this->content_id, $this->params);
		}
		catch(Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode(), $e);
		}

		if($edit === TRUE)
		{
			return $this->returnIds();
		}
		else
		{
			return FALSE;
		}
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
				'id' => 'jumbotron',
			),
			array(
				'type' => 'content_id',
				'id' => $this->content_id,
				'content_type' => 'jumbotron'
			)
		);
	}
}
