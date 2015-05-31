<?php
/**
* Manage the form layout options
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Tool_Form_FormLayout extends Dlayer_Tool_Module_Form
{
	protected $tool = 'form-layout';

	/**
	* Update the layout options for the form, Uses the data in the params 
	* array, this data will have already been both validated and prepared
	*
	* @param integer $site_id Site id
	* @param integer $form_id Form id
	* @param integer|NULL $field_id Not used by this tool
	* @return integer|NULL Field id
	*/
	public function process($site_id, $form_id, $field_id=NULL)
	{
		if($this->validated == TRUE) {            
			$this->saveSettings($site_id, $form_id);
			
			return NULL;
		}
	}

	/**
	* Check to see if the information supplied is valid. If all the values
	* are valid the values are written to the $this->params property
	*
	* @param array $params Params post array
	* @return boolean
	*/
	public function validate(array $params = array())
	{
		if($this->validateValues($params) == TRUE &&
		$this->validateData($params) == TRUE) {
			$this->params = $this->prepare($params);
			$this->validated = TRUE;
			return TRUE;
		} else {
			return FALSE;
		}

		return FALSE;
	}

	public function autoValidate(array $params = array())
	{
		// Not currently used by tool, may be used by the presets later
		return FALSE;
	}

	public function autoProcess($site_id, $form_id, $field_id=NULL)
	{
		// Not currently used by tool, may be used by the presets later
	}

	/**
	* Check that the required values have been sent through as part of the
	* params array, another method will validate the values themselves, we only 
	* do that is all the expected values exist
	*
	* @param array $params Params array to check
	* @return boolean TRUE if the required values exists in the array
	*/
	private function validateValues(array $params = array())
	{
		if(array_key_exists('title', $params) == TRUE && 
			array_key_exists('sub_title', $params) == TRUE && 
			array_key_exists('submit_label', $params) == TRUE && 
			array_key_exists('reset_label', $params) == TRUE && 
			array_key_exists('layout_id', $params) == TRUE && 
			array_key_exists('horizontal_width_label', $params) == TRUE && 
			array_key_exists('horizontal_width_field', $params) == TRUE) {
							
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	* Check that the submitted data values are all in the correct format, 
	* the validateValues() method will have already been run so we know all 
	* the indexes exist
	*
	* @param array $params Params array to check
	* @return boolean TRUE if the values are valid
	*/
	private function validateData(array $params = array())
	{
		if(strlen(trim($params['title'])) > 0 && 
			strlen(trim($params['sub_title'])) >= 0 && 
			strlen(trim($params['submit_label'])) > 0 && 
			strlen(trim($params['reset_label'])) >= 0 && 
			in_array(intval($params['layout_id']), array(1,2,3)) == TRUE && 
			(intval($params['horizontal_width_label']) >= 1 && 
				intval($params['horizontal_width_label']) <= 12) && 
			(intval($params['horizontal_width_field']) >= 1 && 
				intval($params['horizontal_width_field']) <= 12) && 
			(intval($params['horizontal_width_field']) + 
				intval($params['horizontal_width_label'])) == 12) {

			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	* Prepare the data, converts all the array values to the required data 
	* types and trims any string values, called after both the validateValues() 
	* and validateData() have run
	*
	* @param array $params Params array to prepare
	* @return array Prepared data array
	*/
	protected function prepare(array $params)
	{
		return array(
			'title'=>trim($params['title']),
			'sub_title'=>trim($params['sub_title']),
			'submit_label'=>trim($params['submit_label']),
			'reset_label'=>trim($params['reset_label']), 
			'layout_id'=>intval($params['layout_id']),
			'horizontal_width_label'=>intval($params['horizontal_width_label']), 
			'horizontal_width_field'=>intval($params['horizontal_width_field'])
		);
	}
	
	/**
	* Save the setting values, all the calls are updates because we know there 
	* will be values for all the settings, defaults entered when the form is 
	* initially created
	* 
	* @param integer $site_id
	* @param integer $form_id
	* @return void
	*/
	private function saveSettings($site_id, $form_id) 
	{
		$model_layout = new Dlayer_Model_Form_Layout();
		
		$model_layout->saveTitles($site_id, $form_id, $this->params['title'], 
			$this->params['sub_title']);
			
		$model_layout->saveButtonLabels($site_id, $form_id, 
			$this->params['submit_label'], $this->params['reset_label']);
			
		$model_layout->saveLayout($site_id, $form_id, 
			$this->params['layout_id'], 
			$this->params['horizontal_width_label'], 
			$this->params['horizontal_width_field']);
	}
}