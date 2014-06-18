<?php
/**
* Color picker input, includes a hidden element to store the selected value 
* and then a div to invoke the color picker, extension of Zend
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @version $Id: ColorPicker.php 1685 2014-03-16 20:48:23Z Dean.Blackborough $
*/
class Dlayer_Form_Element_ColorPicker extends Zend_Form_Element_Text 
{
	/**
     * Default form view helper to use for rendering
     * @var string
     */
    public $helper = 'formElementColorPicker';
    
    /**
     * Initialize object; used by extending classes
     *
     * @return void
     */
    public function init()
    {
    	$this->clear_link = FALSE;
    }
    
    /**
    * Add clear link after the color selector, defaults to hidden, only shows 
    * when this method is called
    * 
    * @return Dlayer_Form_Element_ColorPicker
    */
    public function addClearLink()
    {
        $this->clear_link = TRUE;
        
        return $this;
    }
}
