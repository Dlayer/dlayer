<?php
/**
* Number HTML input type, extension of Zend
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @version $Id: Number.php 1454 2014-01-24 16:49:54Z Dean.Blackborough $
*/
class Dlayer_Form_Element_Number extends Zend_Form_Element_Text 
{
	/**
     * Default form view helper to use for rendering
     * @var string
     */
    public $helper = 'formElementNumber';
}
