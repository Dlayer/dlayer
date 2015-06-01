<?php
/**
* Layout helper class for the 'Form' layout mode, returns the data arrays 
* for the decorators
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_LayoutDecorator_Form 
{
	/**
	* Return the data array for the form decorator
	* 
	* @return array
	*/
	public static function form() 
	{
		return array(
			'FormElements', 
			array(
				'Form', 
				array(
					'class'=>'form'
				)
			)
		);
	}
}