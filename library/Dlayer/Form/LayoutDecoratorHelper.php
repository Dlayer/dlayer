<?php
/**
* Layout helper decorator class, returns the correct decorators arrays based 
* on the defined layout mode
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_LayoutDecoratorHelper
{
	private $mode;
	private $horizontal_width_label;
	private $horizontal_width_field;
	private $selected_field_id;
	private $builder;
	
	private $decorator_class;
	
	/**
	* @param string $mode Layout mode class
	* @param integer $horizontal_width_label
	* @param integer $horizontal_width_field
	* @param boolean $builder Id the form in builder mode
	* @param integer|NULL $selected_field_id Id of the field currently selected 
	* 	in the designer, NULL if nothing is set
	* @return void
	*/
	public function __construct($mode, $horizontal_width_label, 
		$horizontal_width_field, $builder=false, $selected_field_id=NULL)
	{
		$this->mode = $mode;
		$this->horizontal_width_label = $horizontal_width_label;
		$this->horizontal_width_field = $horizontal_width_field;
		$this->builder = $builder;
		$this->selected_field_id = $selected_field_id;
		
		$this->decoratorClass();
	}
	
	/**
	* Select decorator class
	* 
	* @return void
	*/
	private function decoratorClass() 
	{
		switch($this->mode) {
			case 'form-inline':
				$this->decorator_class = new 
					Dlayer_Form_LayoutDecorator_FormInline(
						$this->builder, $this->selected_field_id);
			break;
			
			case 'form-horizontal':
				$this->decorator_class = new 
					Dlayer_Form_LayoutDecorator_FormHorizontal(
						$this->builder, $this->selected_field_id);
			break;
			
			default:
				$this->decorator_class = new 
					Dlayer_Form_LayoutDecorator_Form($this->builder,
						$this->selected_field_id);
			break;
		}
	}
	
	/**
	* Fetch the decorator array for the form itself
	* 
	* @return array
	*/
	public function form() 
	{
		return $this->decorator_class->form();
	}
	
	/**
	* Fetch the decorator array for form field
	* 
	* @param integer $field_id Id of the current field
	* @param array $options Optional options array
	* @return array
	*/
	public function field($field_id, array $options=array()) 
	{
		$options['label_width'] = $this->horizontal_width_label;
		$options['field_width'] = $this->horizontal_width_field;
		
		return $this->decorator_class->field($field_id, $options);
	}
}
