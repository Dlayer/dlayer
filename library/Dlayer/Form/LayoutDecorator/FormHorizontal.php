<?php
/**
* Layout helper class for the 'Form horizontal' layout mode, returns the data 
* arrays for the decorators
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_LayoutDecorator_FormHorizontal extends 
Dlayer_Form_LayoutDecorator_Base
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
					'class'=>'form-horizontal'
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
		$description = FALSE;

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
		
		if(array_key_exists('description', $options) == TRUE && 
			strlen($options['description']) > 0) {
			
			$description = TRUE;
		}
		
		$view_helpers = array();
		
		$view_helpers[] = array(
			'ViewHelper'
		);
		
		if($description == TRUE) {
			$view_helpers[] = array(
				'Description', 
				array(
					'tag' => 'p', 
					'class'=>'help-block'
				)
			);
		}
		
		$view_helpers[] = array(
			array(
				'ElementWrapper' => 'HtmlTag'
			),
			array(
				'tag' => 'div', 
				'class' => $options['field_width']
			)
		);
		
		$view_helpers[] = array(
			'Label', 
			array(
				'class'=>'control-label ' . $options['label_width']
			)
		);
		
		$view_helpers[] = array('Errors', 
			array(
				'class'=> 'alert alert-danger'
			)
		);
		
		$view_helpers[] = array(
			array(
				'divWrapper' => 'HtmlTag'
			), 
			array(
				'tag' => 'div', 
				'class' => $wrapper_class,
				'id' => $wrapper_id, 
			)
		);
		
		return $view_helpers;
	}
}