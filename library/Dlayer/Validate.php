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
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
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
}
