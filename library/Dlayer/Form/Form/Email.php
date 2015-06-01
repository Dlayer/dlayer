<?php
/**
* Form for the email field tool
* 
* Allows the user to quickly add an email field to the form, the user simply 
* needs to click save, they can still override the preset values if they want, 
* 
* @todo In addition to adding the field this tool also defines some validation 
* and other settings
*  
* This form is used for the add and edit version of the tool
*
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_Form_Email extends Dlayer_Form_Module_Form
{
	/**
	* Set the initial properties for the form
	*
	* @param integer $form_id
	* @param array $field_data Field data array, either an array with all the 
	* 						   attrubutes and their current value or an array 
	* 						   with FALSE as the value for each attribute
	* @param boolean $edit_mode Is the tool currently in edit mode
	* @param integer $multi_use Multi use param for tool tab
	* @param array|NULL $options Zend form options data array
	* @return void
	*/
	public function __construct($form_id, array $field_data, $edit_mode=FALSE,
		$multi_use, $options=NULL)
	{
		$this->tool = 'text';
		$this->field_type = 'text';

		parent::__construct($form_id, $field_data, $edit_mode, $multi_use, 
			$options);
	}

	/**
	* Initialuse the form, sers the url and submit method and then calls the
	* methods that set up the form
	*
	* @return void
	*/
	public function init()
	{
		$this->setAction('/form/process/tool');

		$this->setMethod('post');

		$this->setUpFormElements();

		$this->validationRules();
		
		if($this->edit_mode == FALSE) {
			$legend = 'Add <small>Add a preset email field</small>'; 
		} else {
			$legend = 'Edit <small>Edit the email field</small>';
		}

		$this->addElementsToForm('email_field', $legend, $this->elements);
					
		$this->addDefaultElementDecorators();

		$this->addCustomElementDecorators();
	}

	/**
	* Set up all the elements required for the form, these are broken down 
	* into two sections, hidden elements for the tool and then visible 
	* elements for the user
	*
	* @return void The form elements are written to the private $this->elemnets
	* 			   array
	*/
	protected function setUpFormElements()
	{
		$this->toolElements();

		$this->userElements();
	}

	/**
	* Set up the tool elements, these are the elements that define the tool and 
	* store the session values for the designer
	*
	* @return void Writes the elements to the private $this->elements array
	*/
	private function toolElements()
	{
		$form_id = new Zend_Form_Element_Hidden('form_id');
		$form_id->setValue($this->form_id);

		$this->elements['form_id'] = $form_id;

		$tool = new Zend_Form_Element_Hidden('tool');
		$tool->setValue($this->tool);

		$this->elements['tool'] = $tool;

		if(array_key_exists('id', $this->field_data) == TRUE 
		&& $this->field_data['id'] != FALSE) {
			$field_id = new Zend_Form_Element_Hidden('field_id');
			$field_id->setValue($this->field_data['id']);
			$this->elements['field_id'] = $field_id;
		}

		$field_type = new Zend_Form_Element_Hidden('field_type');
		$field_type->setValue($this->field_type);

		$this->elements['field_type'] = $field_type;

		$multi_use = new Zend_Form_Element_Hidden('multi_use');
		$multi_use->setValue($this->multi_use);
		$multi_use->setBelongsTo('params');

		$this->elements['multi_use'] = $multi_use;
	}

	/**
	* Set up the user elements, these are the elements that the user interacts 
	* with to use the tool
	* 
	* @return void Writes the elements to the private $this->elements array
	*/
	private function userElements()
	{
		$label = new Zend_Form_Element_Text('label');
		$label->setLabel('Label');
		$label->setAttribs(array('maxlength'=>255, 
			'placeholder'=>'Your email', 'class'=>'form-control input-sm'));
		$label->setDescription("Enter the label for the email field, defaulted 
			to 'Your email'.");
		$label->setBelongsTo('params');

		$value = $this->fieldValue('label');
		if($value != FALSE) {
			$label->setValue($value);
		} else {
			$label->setValue('Your email');
		}

		$this->elements['label'] = $label;

		$description = new Zend_Form_Element_Textarea('description');
		$description->setLabel('Description');
		$description->setAttribs(array('rows'=>2, 'cols'=>30, 
			'placeholder'=>'Please enter your email', 
			'class'=>'form-control input-sm'));
		$description->setDescription("Enter the description for the email 
			field, defaulted to 'Please enter your email address'.");
		$description->setBelongsTo('params');

		$value = $this->fieldValue('description');
		if($value != FALSE) {
			$description->setValue($value);
		} else {
			$description->setValue('Please enter your email address');
		}

		$this->elements['description'] = $description;

		$placeholder = new Zend_Form_Element_Text('placeholder');
		$placeholder->setLabel('Placeholder text');
		$placeholder->setAttribs(array('maxlength'=>255, 
			'placeholder'=>'Enter your email', 
			'class'=>'form-control input-sm'));
		$placeholder->setDescription("Set the help text to display for the 
			email field, defaulted to 'Enter you email'.");
		$placeholder->setBelongsTo('params');

		$value = $this->fieldAttributeValue('placeholder');
		if($value != FALSE) {
			$placeholder->setValue($value);
		} else {
			$placeholder->setValue('Enter your email');
		}

		$this->elements['placeholder'] = $placeholder;

		$size = new Dlayer_Form_Element_Number('size');
		$size->setLabel('Size');
		$size->setValue(40);
		$size->setAttribs(array('maxlength'=>3, 'min'=>0, 
			'class'=>'form-control input-sm'));
		$size->setDescription('Set the size of the email field in characters,
			we default to 40 characters.');
		$size->setBelongsTo('params');

		$value = $this->fieldAttributeValue('size');
		if($value != FALSE) {
			$size->setValue($value);
		}

		$this->elements['size'] = $size;

		$maxlength = new Dlayer_Form_Element_Number('maxlength');
		$maxlength->setLabel('Max length');
		$maxlength->setValue(255);
		$maxlength->setAttribs(array('maxlength'=>3, 'min'=>0, 
			'class'=>'form-control input-sm'));
		$maxlength->setDescription('Set the maximum number of characters that
			can be entered into the email field, we default to 255 characters.');
		$maxlength->setBelongsTo('params');

		$value = $this->fieldAttributeValue('maxlengh');
		if($value != FALSE) {
			$maxlength->setValue($value);
		}

		$this->elements['maxlength'] = $maxlength;

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('class', 'submit');
		$submit->setAttribs(array('class'=>'btn btn-primary'));
		if($this->edit_mode == FALSE) {
			$submit->setLabel('Add');
		} else {
			$submit->setLabel('Save');
		}

		$this->elements['submit'] = $submit;
	}

	/**
	* Add the validation rules for the form elements and set the custom error
	* messages
	*
	* @return void
	*/
	protected function validationRules()
	{

	}
}