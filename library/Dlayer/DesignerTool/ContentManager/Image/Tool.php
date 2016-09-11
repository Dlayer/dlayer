<?php

/**
 * Import form tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Image_Tool extends Dlayer_Tool_Content
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

		if(array_key_exists('version_id', $params) === TRUE && array_key_exists('expand', $params) === TRUE &&
			array_key_exists('caption', $params) === TRUE)
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

		$model_image = new Dlayer_DesignerTool_ContentManager_Image_Model();

		if(intval($params['version_id']) > 0 &&
			$model_image->valid($this->site_id, $params['version_id']) === TRUE &&
			in_array($params['expand'], array(1, 0)) === TRUE && strlen(trim($params['caption'])) >= 0)
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
			'version_id' => intval($params['version_id']),
			'expand' => intval($params['expand']),
			'caption' => trim($params['caption'])
		);
	}

	/**
	 * Validate the instances param, need to see if it should exist first
	 *
	 * @param integer $site_id
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
		$data_added = FALSE;
		$content_id = $this->addContentItem('image');

		if($content_id !== FALSE)
		{
			$model_image = new Dlayer_DesignerTool_ContentManager_Image_Model();
			$data_added = $model_image->add($this->site_id, $this->page_id, $content_id, $this->params);
		}

		if($content_id !== FALSE && $data_added === TRUE)
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
		$model_image = new Dlayer_DesignerTool_ContentManager_Image_Model();

		try
		{
			$result = $model_image->edit($this->site_id, $this->page_id, $this->content_id, $this->params);
		}
		catch(Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode(), $e);
		}

		if($result === TRUE)
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
				'id' => 'image',
			),
			array(
				'type' => 'content_id',
				'id' => $this->content_id,
				'content_type' => 'image'
			)
		);
	}
}
