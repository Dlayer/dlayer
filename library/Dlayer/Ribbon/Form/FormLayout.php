<?php
/**
* Form layout tool ribbon class
* 
* Returns the data for the requested tool tab ready to the passed to the view 
* script. The method needs to return an array, other than that there are no 
* specific requirements for the vuewData method.
* 
* Each view file needs to check for expected indexes, tools and tool tabs can 
* and do operate differently
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Ribbon_Form_FormLayout extends Dlayer_Ribbon_Module_Form
{
	/**
	* Instantiate and return the form to add or edit a text field
	*
	* @param integer $site_id
	* @param integer $form_id
	* @param string $tool Name of the selected tool
	* @param string $tab Name of the selected tool tab
	* @param integer $multi_use Tool tab multi use param
	* @param integer|NULL $field_id Id of the form field if in edit mode
	* @param boolean $edit_mode Is the tool tab in edit mode
	* @param return array
	*/
	public function viewData($site_id, $form_id, $tool, $tab,
	$multi_use, $field_id=NULL, $edit_mode=FALSE)
	{
		$this->writeParams($site_id, $form_id, $tool, $tab, $multi_use, 
		$field_id, $edit_mode);

		return array('form'=>new Dlayer_Form_Form_FormLayout(
			$this->form_id, $this->existingData(), $this->edit_mode, 
			$this->multi_use), 'preview_data'=>array());
	}
	
	/**
	* Fetch the existing data to preset the values on the form
	* 
	* @param integer $site_id
	* @param integer $form_id
	* @return array
	*/
	private function existingData() 
	{
		$model_layout = new Dlayer_Model_Form_Layout();
		
		$layout = $model_layout->currentValues($this->site_id, $this->form_id);
		
		if($layout != FALSE) {
			return $layout;
		} else {
			return array(
				'title'=>Dlayer_Config::FORM_DEFAULT_TITLE,
				'sub_title'=>Dlayer_Config::FORM_DEFAULT_SUB_TITLE,
				'submit_label'=>Dlayer_Config::FORM_DEFAULT_SUBMIT_LABEL, 
				'reset_label'=>Dlayer_Config::FORM_DEFAULT_RESET_LABEL, 
				'layout_id'=>Dlayer_Config::FORM_DEFAULT_LAYOUT_ID, 
				'horizontal_width_label'=>
					Dlayer_Config::FORM_DEFAULT_HORIZONTAL_WIDTH_LABEL, 
				'horizontal_width_field'=>
					Dlayer_Config::FORM_DEFAULT_HORIZONTAL_WIDTH_FIELD
			);
		}
	}
}