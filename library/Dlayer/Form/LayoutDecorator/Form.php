<?php
/**
* Layout helper class for the 'Form' layout mode, returns the data arrays 
* for the decorators
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_LayoutDecorator_Form extends Dlayer_Form_LayoutDecorator
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
					'class'=>'form',
                    'autocomplete' => 'off'
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
			'Errors', 
			array(
				'class'=> 'alert alert-danger'
			)
		);
		
		$view_helpers[] = array(
			'Label'
		);
		
		$view_helpers[] = array(
			'HtmlTag', 
			array(
				'tag' => 'div', 
				'class'=> $wrapper_class,
				'data-id' => $field_id,
                'data-tool' => $options['type']
			)
		);
		
		return $view_helpers;
	}
}
