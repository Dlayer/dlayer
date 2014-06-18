<?php
/**
* Check to see if the supplied value is a valid hex color, needs to be 
* 7 characters with a leading hash, the remaining 6 characters should be 
* a valid hex value
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: ColorHex.php 817 2013-08-27 23:51:09Z Dean.Blackborough $
*/
class Dlayer_Validate_ColorHex extends Zend_Validate_Abstract 
{
    const COLOR_HEX = 'colorHex';

    protected $_messageTemplates = array(
        self::COLOR_HEX => "The supplied color hex is not valid, please re-open 
        the color picker and choose a new color"
    );
       
    /**
    * Sets validator options
    *
    * @param array $options
    * @return void
    */
    public function __construct($options = array())
    {
        
    }

    /**
    * Run the validation
    * 
    * @param string $value
    * @return boolean
    */
    public function isValid($value)
    {
        $this->_setValue($value);
        
        $validator = new Zend_Validate_Hex();
        
        if(strlen($value) == 7) {
            if($validator->isValid(ltrim($value, '#')) == TRUE) {
                return TRUE;
            } else {
                $this->_error(self::COLOR_HEX);
                return FALSE;
            }
        } else {
            $this->_error(self::COLOR_HEX);
            return FALSE;
        }
    }
}
