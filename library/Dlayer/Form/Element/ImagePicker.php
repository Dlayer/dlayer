<?php
/**
* Image picker input, includes a hidden element st store the selected 
* version id, the input itself is a text value initially with text saying 
* 'Click to choose image' and then later the name
* 
* @author Dean Blackborough <dean@g3d-development.com>
*/
class Dlayer_Form_Element_ImagePicker extends Zend_Form_Element_Text 
{
	/**
	 * Default form view helper to use for rendering
	 * @var string
	 */
	public $helper = 'formElementImagePicker';
	
	/**
	 * Initialize object; used by extending classes
	 *
	 * @return void
	 */
	public function init()
	{
		
	}
}
