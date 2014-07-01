<?php
/**
* Base form class for all the image library ribbon forms
*
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
abstract class Dlayer_Form_Module_Image extends Dlayer_Form
{
    protected $existing_data = array();
    protected $edit_mode;
    
    /**
    * @var array Data array for any data that needs to be passed to form 
    *            fields, an example being select options
    */
    protected $elements_data;

    protected $tool;

    /**
    * Set the initial properties for the form
    * 
    * @param array $existing_data Exisitng data array for form, array values 
    *                             always preset, will have FALSE values if there 
    *                             is no existing data value
    * @param boolean $edit_mode Is the tool in edit mode
    * @param array|NULL $options Zend form options data array
    * @return void
    */
    public function __construct(array $existing_data, $edit_mode=FALSE, 
    $options=NULL)
    {
        $this->existing_data = $existing_data;
        $this->edit_mode = $edit_mode;
        $this->field_data = $field_data;

        parent::__construct($options=NULL);
    }
    
    /**
    * Add the default decorators to use for the form inputs
    *
    * @return void
    */
    protected function addDefaultElementDecorators()
    {
        $this->setElementDecorators(array(array('ViewHelper',
        array('tag' => 'div', 'class'=>'input')), array('Description'),
        array('Errors'), array('Label'), array('HtmlTag',
        array('tag' => 'div', 'class'=>'input'))));
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
        array('HtmlTag', array('tag' => 'div', 'class'=>'save'))));
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