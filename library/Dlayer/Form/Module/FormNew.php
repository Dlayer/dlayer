<?php
/**
* Base form class for all the Form builder ribbon forms
*
* @author Dean Blackborough
* @copyright G3D Development Limited
*/

/**
 * Class Dlayer_Form_Module_FormBase class for all the forms in the Form builder, sets up the decorators for the
 * Form builder forms and contains any helper functions
 */
abstract class Dlayer_Form_Module_FormNew extends Dlayer_Form
{
	public function __construct($options=NULL)
	{
		parent::__construct($options=NULL);
	}

	/**
	* Add the default decorators to use for the form inputs
	*
	* @return void
	*/
	protected function addDefaultElementDecorators()
	{
		$this->setDecorators(array(
			'FormElements', 
			array('Form', array('class'=>'form'))));

		$this->setElementDecorators(array(
			array('ViewHelper'), 
			array('Description', array('tag' => 'p', 'class'=>'help-block')),
			array('Errors', array('class'=> 'alert alert-danger')), 
			array('Label'), 
			array('HtmlTag', array(
				'tag' => 'div', 
				'class'=> array(
					'callback' => function($decorator) {
						if($decorator->getElement()->hasErrors()) {
							return 'form-group has-error';
						} else {
							return 'form-group';
						}
				})
			))
		));

		$this->setDisplayGroupDecorators(array(
			'FormElements',
			'Fieldset',
		));
	}

	/**
	* Add any custom decorators, these are inputs where we need a little more
	* control over the html, an example being the submit button
	*
	* @return void
	*/
	protected function addCustomElementDecorators()
	{
		$this->elements['submit']->setDecorators(array(array('ViewHelper'),
			array('HtmlTag', array(
				'tag' => 'div', 
				'class'=>'form-group form-group-submit')
			)
		));
	}

	/**
	* Check field array for field value, either return assigned value or FALSE
	* if field value not set in data array
	* 
	* @param string $field
	* @return string|FALSE
	*/
	protected function fieldValue($field) 
	{
		if(array_key_exists($field, $this->field_data) == TRUE 
		&& $this->field_data[$field] != FALSE) {
			return $this->field_data[$field];
		} else {
			return FALSE;
		}
	}

	/**
	* Check field array for field attribute value, either return assigned 
	* attribute value or FALSE if field attribute value not set in data array
	* 
	* @param string $attribute
	* @return string|FALSE
	*/
	protected function fieldAttributeValue($attribute) 
	{
		if(array_key_exists('attributes', $this->field_data) == TRUE
		&& array_key_exists($attribute, $this->field_data['attributes']) == TRUE 
		&& $this->field_data['attributes'][$attribute] != FALSE) {
			return $this->field_data['attributes'][$attribute];
		} else {
			return FALSE;
		}
	}
}
