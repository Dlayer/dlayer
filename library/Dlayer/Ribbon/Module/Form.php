<?php
/**
* The ribbon classes return all the data required to generate the view for the
* selected ribbon tab. Some of these classes are very simple, some are much
* more completed, by extending this abstract class we ensure some consistency
* as the complexity of the application grows.
*
* Ribbon models only have one public method, viewData(), this should return
* either an array containing the required data or FALSE is there is no data,
* the format of the data depends on both tghe requested tool and the requested
* tabl, all we require is an array or FALSE, the view script works out
* what it needs to do with the array
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
abstract class Dlayer_Ribbon_Module_Form
{
	protected $site_id;
	protected $form_id;
	protected $tool;
	protected $tab;
	protected $multi_use;
	protected $field_id;
	protected $edit_mode;

	/**
	* Data method for the form builder ribbons, returns the data
	* required by the view for the requested tool and tab.
	*
	* @param integer $site_id
	* @param integer $form_id
	* @param string $tool Name of the selected tool
	* @param string $tab Name of the selected tool tab
	* @param integer $multi_use Tool tab multi use param
	* @param integer|NULL $field_id Selected form field
	* @param boolean $edit_mode Is the tool tab in edit mode
	* @return array|FALSE
	*/
	abstract public function viewData($site_id, $form_id, $tool, $tab,
	$multi_use, $field_id=NULL, $edit_mode=FALSE);

	/**
	* Take the supplied params and write them to the private properties
	*
	* @param integer $site_id
	* @param integer $form_id
	* @param string $tool Name of the selected tool
	* @param string $tab Name of the selected tool tab
	* @param integer $multi_use Tool tab multi use param
	* @param integer|NULL $field_id Selected form field
	* @param boolean $edit_mode Is the tool tab in edit mode
	* @return array|FALSE
	*/
	protected function writeParams($site_id, $form_id, $tool, $tab, 
	$multi_use, $field_id, $edit_mode)
	{
		$this->site_id = $site_id;
		$this->form_id = $form_id;
		$this->tool = $tool;
		$this->tab = $tab;
		$this->multi_use = $multi_use;
		$this->field_id = $field_id;
		$this->edit_mode = $edit_mode;
	}

	/**
	* Fetchs the existing data for a form field, both the base properties and 
	* all the attributes. If the tool is in add mode and array will be returned 
	* with FALSE as a value for each of the keys, this is so we can easily 
	* define preset values as an array is always returned
	* 
	* @return array
	*/
	protected function fieldData()
	{
		$model_form_field = new Dlayer_Model_Form_Field();
		
		$field = array('id'=>FALSE, 'label'=>FALSE, 'desription'=>FALSE);
		$attributes = $model_form_field->attributes($this->tool);
				
		if($this->field_id != NULL) {
			$set_field_data = $model_form_field->field($this->field_id, 
			$this->site_id, $this->form_id, $this->tool);
			
			if($set_field_data != FALSE) {
				$field = $set_field_data;
				$attributes = $model_form_field->assignedAttributes(
				$this->field_id, $this->site_id, $this->form_id);
			}
		}
		
		$field['attributes'] = $attributes;
		
		return $field;
	}
	
	/**
	* Fetch the data required for the javascript preview methods 
	* 
	* @return array
	*/
	protected function previewData() 
	{
		$model_form_field = new Dlayer_Model_Form_Field();
		
		return array(
			'preview_js'=>$model_form_field->previewMethods($this->site_id, $this->form_id, $this->field_id),
			'field'=>$model_form_field->field($this->field_id, $this->site_id, $this->form_id, $this->tool));
	}
}
