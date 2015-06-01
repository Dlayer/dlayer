<?php
/**
* Layout helper decorator class, returns the correct decorators arrays based 
* on the defined layout mode
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_LayoutDecorator 
{
	private $mode;
	private $horizontal_width_label;
	private $horizontal_width_field;
	
	private $decorator_class;
	
	/**
	* @param string $mode Layout mode class
	* @param integer $horizontal_width_label
	* @param integer $horizontal_width_field
	* @return void
	*/
	public function __construct($mode, $horizontal_width_label, 
		$horizontal_width_field) 
	{
		$this->mode = $mode;
		$this->horizontal_width_label = $horizontal_width_label;
		$this->horizontal_width_field = $horizontal_width_field;
		
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
					Dlayer_Form_LayoutDecorator_FormInline();
			break;
			
			case 'form-horizontal':
				$this->decorator_class = new 
					Dlayer_Form_LayoutDecorator_FormHorizontal();
			break;
			
			default:
				$this->decorator_class = new 
					Dlayer_Form_LayoutDecorator_Form();
			break;
		}
	}
	
	
	public function form() 
	{
		return $this->decorator_class->form();
	}
}