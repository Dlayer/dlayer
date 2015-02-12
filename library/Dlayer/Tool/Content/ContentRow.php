<?php
/**
* Add a new content row to a content area, new content row is added after all 
* existing content rows
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Tool_Content_Text extends Dlayer_Tool_Module_Content
{
	protected $content_type = '';

	/**
	* Not used by the this tool
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer|NULL $content_id
	* @return 
	*/
	public function process($site_id, $page_id, $div_id,
		$content_id=NULL)
	{
		// Not used by this tool
	}

	/**
	* Not used by this tool
	* 
	* @param array $params Params $_POST array
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @return boolean TRUE if requested is valid, also sets the $this->params
	*                 property and set $this->validated to TRUE
	*/
	public function validate(array $params = array(), $site_id, $page_id,
		$div_id)
	{
		// Not used by this tool

		return FALSE;
	}

	/**
	* Validate the submitted data, if valid the tool processes the request
	* 
	* @param array $params Params $_POST array
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @return boolean TRUE if requested is valid, also sets the 
	* 	$this->params_auto property and sets $this->validated_auto to TRUE
	*/
	public function autoValidate(array $params = array())
	{
		// Not currently used by tool, may be used by the presets later
		return FALSE;
	}

	public function autoProcess($site_id, $page_id, $div_id, $content_id=NULL)
	{
		// Not currently used by tool, may be used by the presets later
	}

	/**
	* Check to ensure that the required values have been posted in the params 
	* array. Check the data exists fiorst and then another methods checks the 
	* data itself
	*
	* @param array $params $_POSTed params data array
	* @return boolean TRUE if the required values are in array
	*/
	private function validateValues(array $params = array())
	{
		// No data in the params array for this tool
		return TRUE;
	}

	/**
	* Check that the submitted data is of the correct format
	*
	* @param array $params Params array to validte
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @return boolean TRUE if the values are valid
	*/
	private function validateData(array $params = array(), $site_id, $page_id,
		$div_id)
	{
		// No additional data to validate
		return TRUE;
	}

	/**
	* Prepare the data, convert the values to the correct data types and trim
	* any string values
	*
	* @param array $params Params array to prepare
	* @return array Prepared data array
	*/
	protected function prepare(array $params)
	{
		return array();
	}
}