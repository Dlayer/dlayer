<?php
/**
* Comment field ribbon data class
* 
* Returns the data for the requested tool tab ready top be passed directly 
* to the tool tab view. The view data method needs to return an array, other 
* than that there are no specific requirements, it is down to each view script 
* to handle the data passed to it.
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Ribbon_Form_PresetComment extends Dlayer_Ribbon_Module_Form
{
	/**
	* Instantiate and return the form along with any additional data required 
	* by the tab views
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

		return array('form'=>new Dlayer_Form_Form_PresetComment(
			$this->form_id, array(), $this->edit_mode, $this->multi_use), 
			'field_id'=>$field_id, 'preview_data'=>FALSE);
	}
}