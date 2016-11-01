<?php
/**
* Layout helper class for the 'Form inline' layout mode, returns the data 
* arrays for the decorators
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_LayoutDecorator_FormInline extends Dlayer_Form_LayoutDecorator
{
	/**
	* Return the data array for the form decorator
	* 
	* @return array
	*/
	public function form() 
	{
		return array(
			'FormElements', 
			array(
				'Form', 
				array(
					'class'=>'form-inline'
				)
			)
		);
	}
	
	/**
	* Fetch the decorator array for form fields
	* 
	* @param integer $field_id Id of the current field
	* @param integer|NULL $selected_field_id Id of the field selected in the 
	* 	designer or NULL
	* @param integer $options Optional options array
	* @return array
	*/
	public function field($field_id, array $options=array()) 
	{
		$wrapper_class = 'form-group field_row row_' . $field_id;

		if($this->selected_field_id != NULL && 
			$this->selected_field_id == $field_id) {
				
			$wrapper_class .= ' selected';
		}

		if($this->preview_mode == FALSE) {
			$wrapper_id = $options['type'] . ':' . $options['tool'] . 
				':' . $field_id;
		} else {
			$wrapper_id = '';
		}
			
		return array(
			array('ViewHelper'),
			array('Errors', 
				array(
					'class'=> 'alert alert-danger'
				)
			), 
			array('Label'), 
			array('HtmlTag', 
				array(
					'tag' => 'div', 
					'class'=> $wrapper_class,
					'id'=>$wrapper_id
				)
			)
		);
	}
}
