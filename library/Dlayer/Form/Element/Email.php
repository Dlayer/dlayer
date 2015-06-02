<?php
/**
* Email HTML input type, extension of Zend
* 
* @author Dean Blackborough <dean@g3d-development.com>
*/
class Dlayer_Form_Element_Email extends Zend_Form_Element_Text 
{
	/**
	 * Default form view helper to use for rendering
	 * @var string
	 */
	public $helper = 'formElementEmail';
}