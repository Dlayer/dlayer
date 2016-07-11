<?php

/**
 * Add a new row to the selected page or column, new row will be appended to the end of any existing rows
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Tool_Content_AddRow extends Dlayer_Tool_Module_Content
{
	/**
	 * Check that all the required keys exists in the params array
	 *
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

	protected function structure()
	{
		$model_content = new Dlayer_Model_Page_Content();
	}

	/**
	 * Add a new content row to the page div id, gets added after any existing
	 * content rows
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $div_id
	 * @param integer|NULL $content_row_id
	 * @return array Return an array of the ids that you would like to be set
	 *    after the request has processed
	 */
	/*protected function structure($site_id, $page_id, $div_id,
		$content_row_id = NULL)
	{
		$model_content = new Dlayer_Model_Page_Content();

		if($this->params_auto['rows'] == 1)
		{
			$content_row_id = $model_content->addContentRow($site_id, $page_id,
				$div_id);
		}
		else
		{
			$content_row_id = $model_content->addContentRows($site_id,
				$page_id, $div_id, $this->params_auto['rows']);
		}

		return array(
			array('type' => 'div_id', 'id' => $div_id),
			array('type' => 'content_row_id', 'id' => $content_row_id),
			array('type' => 'tool', 'id' => 'content-row'),
		);
	}*/
}
