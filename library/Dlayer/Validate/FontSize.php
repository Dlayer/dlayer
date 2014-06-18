<?php
/**
* Font size validator, checks the given value is an integer and that it is 
* between 6 and 72
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: FontSize.php 913 2013-09-16 15:57:30Z Dean.Blackborough $
*/
class Dlayer_Validate_FontSize extends Zend_Validate_Abstract 
{
    const FONT_SIZE = 'fontSize';

    protected $_messageTemplates = array(
        self::FONT_SIZE => "The supplied value should be between 6 and 72"
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
        
        $validator = new Zend_Validate_Between(array('min'=>6, 
        'max'=>72));
        
        if($validator->isValid($value) == TRUE) {
            return TRUE;
        } else {
            $this->_error(self::FONT_SIZE);
            return FALSE;
        }
    }
}
