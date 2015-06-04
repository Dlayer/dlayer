<?php
/**
* Form for the form actions tool
* 
* Allows a user to define the action for a form, these are the functions and 
* tasks that happen after a form is submitted
*  
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_Form_FormActions extends Dlayer_Form_Module_Form
{
	/**
	* Set the initial properties for the form
	*
	* @param integer $form_id
	* @param array $field_data Data array containing all the current values 
	* 	for the fields on the form, typically the values are set to FALSE, in 
	* 	the case of the settings form there are always values
	* @param boolean $edit_mode Is the tool currently in edit mode
	* @param integer $multi_use Multi use param for tool tab
	* @param array|NULL $options Zend form options data array
	* @return void
	*/
	public function __construct($form_id, array $field_data, $edit_mode=FALSE,
		$multi_use, $options=NULL)
	{
		$this->tool = 'form-actions';

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

		$this->addElementsToForm('form_actions', 
			'Form actions <small>Set the actions for your form</small>', 
			$this->elements);

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
		$email = new Zend_Form_Element_Select('email');
		$email->setLabel('Email');
		$email->setDescription('Would you like Dlayer to send you an 
			email after each submission?');
		$email->addMultiOptions(
			array(1=>'No thank you', 2=>'Yes please'));
		$email->setRequired();
		$email->setAttrib('class', 'form-control input-sm');
		$email->setBelongsTo('params');
		
		$this->elements['email'] = $email;
		
		$save = new Zend_Form_Element_Select('save');
		$save->setLabel('Email');
		$save->setDescription('Would you like Dlayer to save a copy of 
			each submission?');
		$save->addMultiOptions(
			array(1=>'No thank you', 2=>'Yes please'));
		$save->setRequired();
		$save->setAttrib('class', 'form-control input-sm');
		$save->setBelongsTo('params');
		
		$this->elements['save'] = $save;
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('class', 'submit');
		$submit->setAttribs(array('class'=>'btn btn-primary', 
			'disabled'=>'disabled'));
		$submit->setLabel('Save');

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