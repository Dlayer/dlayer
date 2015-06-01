<?php
/**
* Layout helper class for the 'Form horizontal' layout mode, returns the data 
* arrays for the decorators
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_LayoutDecorator_FormHorizontal 
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
}