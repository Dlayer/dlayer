<?php

/**
 * Add a new row to the selected page or column, new row will be appended to the end of any existing rows
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_AddRow_Tool extends Dlayer_Tool_Content
{
	/**
	 * Check that all the required keys exists in the params array
	 *
	 * @param array $params
	 * @return boolean
	 */
	protected function paramsExist(array $params)
	{
		$valid = FALSE;
		if(array_key_exists('rows', $params) === TRUE)
		{
			$valid = TRUE;
		}

		return $valid;
	}

	/**
	 * Check to ensure that the posted params are of the correct type and within the expected range
	 *
	 * @param array $params
	 * @return boolean
	 */
	protected function paramsValid(array $params)
	{
		$valid = FALSE;
		if(intval($params['rows']) >= 1 && intval($params['rows']) <= 10)
		{
			$valid = TRUE;
		}

		return $valid;
	}

	/**
	 * Assign the params to the property
	 *
	 * @param array $params
	 * @param boolean $manual_tool
	 * @return boolean
	 */
	protected function paramsAssign(array $params, $manual_tool = TRUE)
	{
		if($manual_tool === FALSE)
		{
			$this->params_auto = array(
				'rows' => intval($params['rows']),
			);
		}
	}

	protected function add()
	{

	}

	protected function edit()
	{

	}

	/**
	 * @return array
	 */
	protected function structure()
	{
		$model_content = new Dlayer_DesignerTool_ContentManager_AddRow_Model();

		$row_id = $model_content->addRows($this->params_auto['rows'], $this->site_id, $this->page_id, $this->column_id);

        Dlayer_Helper::sendToInfoLog('Form added to site id: '. $this->site_id . ' page id: ' . $this->page_id .
            ' row id: ' . $this->row_id . ' column id: ' . $this->column_id);

		return array(
			array(
				'type' => 'page_id',
				'id' => $this->page_id,
			),
			array(
				'type' => 'row_id',
				'id' => $row_id,
			),
			array(
				'type' => 'column_id',
				'id' => $this->column_id,
			),
			array(
				'type' => 'tool',
				'id' => 'row',
			)
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
		// TODO: Implement validateInstances() method.
	}
}
