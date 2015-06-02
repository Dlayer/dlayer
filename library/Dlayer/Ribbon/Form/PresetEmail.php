<?php
/**
* Email field ribbon data class.
* 
* Returns the data for the requested tool tab ready to be passed to the view
* script. The methods needs to return an array, other than that there are no
* specific requirements for ribbon tool data classes.
*
* Each view file needs to check for the expected indexes, tools and tool tabs
* can and do operate differently
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Ribbon_Form_PresetEmail extends Dlayer_Ribbon_Module_Form
{
	/**
	* Instantiate and return the form to add or edit an email field
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

		return array('form'=>new Dlayer_Form_Form_PresetEmail(
			$this->form_id,$this->fieldData(), $this->edit_mode, 
			$this->multi_use), 'field_id'=>$field_id, 
			'preview_data'=>FALSE);
	}
}