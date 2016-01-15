<?php
/**
* Add a new text area field to a form or edit an existing one
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Tool_Form_Textarea extends Dlayer_Tool_Module_Form
{
	protected $field_type = 'textarea';
	protected $tool = 'textarea';

	private $model_field;

	/**
	* Add a new textarea field or edit the selected text field. Uses the data
	* in the params array for the request, this data will have already been
	* both prepared and validated by the tool class
	*
	* @param integer $site_id Site id
	* @param integer $form_id Form id
	* @param integer|NULL $field_id If in edit mode the id of the field being
	*                               edited
	* @return integer Field id
	*/
	public function process($site_id, $form_id, $field_id=NULL)
	{
		if($this->validated == TRUE) {

			$this->model_field = new Dlayer_Model_Form_Field();

			if($field_id == NULL) {
				$field_id = $this->addFormField($site_id, $form_id);
			} else {
				$this->editFormField($site_id, $form_id, $field_id);
			}

			return array(
				array('type'=>'field', 'id'=>$field_id), 
				array('type'=>'tool', 'id'=>$this->tool)
			);
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
	* params array, another method will validate the values themselves
	*
	* @param array $params Params array to check
	* @return boolean TRUE if the required values exists in the array
	*/
	private function validateValues(array $params = array())
	{
		if(array_key_exists('label', $params) == TRUE &&
		array_key_exists('description', $params) == TRUE &&
		array_key_exists('cols', $params) == TRUE &&
		array_key_exists('rows', $params) == TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	* Check that the submitted data values are all in the correct format
	*
	* @param array $params Params array to check
	* @return boolean TRUE if the values are valid
	*/
	private function validateData(array $params = array())
	{
		if(strlen(trim($params['label'])) > 0 &&
		strlen(trim($params['description'])) >= 0 &&
		intval($params['cols']) > 0 && intval($params['rows']) > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	* Prepare the data, converts all the array values to the required data
	* type and trims and string values, called after the data has been
	* validated
	*
	* @param array $params Params array to prepare
	* @return array Prepared data array
	*/
	protected function prepare(array $params)
	{
		return array('label'=>trim($params['label']),
					 'description'=>trim($params['description']),
					 'placeholder'=>trim($params['placeholder']),
					 'cols'=>intval($params['cols']),
					 'rows'=>intval($params['rows']));
	}

	/**
	* Add the text field and all the field attributes
	*
	* @param integer $site_id
	* @param integer $form_id
	* @return void
	*/
	private function addFormField($site_id, $form_id)
	{
		$insert_id = $this->model_field->addFormField($site_id, $form_id,
		$this->field_type, $this->tool, $this->params);

		$this->model_field->addFieldAttributes($site_id, $form_id, $insert_id,
		array('cols', 'rows', 'placeholder'), $this->params, 
		$this->field_type);

		return $insert_id;
	}

	/**
	* Edit the text field and all the field attributes
	*
	* @param integer $site_id
	* @param integer $form_id
	* @param integer $field_id
	* @return void
	*/
	private function editFormField($site_id, $form_id, $field_id)
	{
		$this->model_field->editFormField($site_id, $form_id, $field_id,
		$this->params);

		$this->model_field->editFieldAttributes($site_id, $form_id,
		$field_id, array('cols', 'rows', 'placeholder'), $this->params,
		$this->field_type);
	}
}