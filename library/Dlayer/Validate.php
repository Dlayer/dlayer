<?php
/**
* Helper validation class, contains all the status calls for the custom 
* validation rules
* 
* @todo As this gets bigger we will need to move the validation methods into 
* their own classes
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Validate 
{
	/**
	* Check to see if the supplied value is a valid hex color, needs to be 
	* 7 characters with a leading hash, the remaining 6 characters should be 
	* a valid hex value
	* 
	* @param string $value Value to validate
	* @param boolean $optional Is the value optional, can it be blank?
	* @return boolean Validation passed?
	*/
	public static function colorHex($value, $optional=FALSE) 
	{
		if(strlen($value) == 0 && $optional == TRUE) {
			return TRUE;
		} else {
			$validator = new Dlayer_Validate_ColorHex();			
			return $validator->isValid($value);
		}
	}
	
	/**
	* Check to see if the given border style is valid, needs to exists in the 
	* given border styles array
	* 
	* @todo The called method needs to be in a border class and then all code 
	* 		calls those classes
	* @param string $value
	* @return boolean Validation passed
	*/
	public static function borderStyle($value) 
	{
		$model_border = new Dlayer_Model_Ribbon_Styles();
		if(array_key_exists($value, $model_border->borderStyles()) == TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	* Check to see if the given border position is valid, valid values are 
	* only top, right, bottom and left
	* 
	* @param string $value
	* @return boolean Validation passed
	*/
	public static function borderPosition($value) 
	{
		if(in_array($value, array('top', 'right', 'bottom', 'left')) == TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}