<?php
/**
* Form for the form settings tool
* 
* Allows a user to define the settings for a form, these are the settings 
* that control the make up of the form
*  
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_Form_FormSettings extends Dlayer_Form_Module_Form
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
		$this->tool = 'form-settings';

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

		$this->addElementsToForm('form_setting', 
			'Form settings <small>Set the settings for your form</small>', 
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
		$http = new Zend_Form_Element_Select('http');
		$http->setLabel('Email');
		$http->setDescription('Set the HTTP method to use for form submission');
		$http->addMultiOptions(
			array(1=>'POST', 2=>'GET'));
		$http->setRequired();
		$http->setAttrib('class', 'form-control input-sm');
		$http->setBelongsTo('params');
		
		$this->elements['http'] = $http;
		
		$url = new Zend_Form_Element_Text('url');
		$url->setLabel('Custom URL');
		$url->setAttribs(array('maxlength'=>255, 
			'placeholder'=>'e.g., https://your-url/handler', 
			'class'=>'form-control input-sm'));
		$url->setDescription('Set a custom URL to submit the form to, leave 
			blank to let Dlayer handle the submissions.');
		$url->setBelongsTo('params');
		$url->setRequired();
		
		$this->elements['url'] = $url;
		
		$lock = new Zend_Form_Element_Select('lock');
		$lock->setLabel('Lock form?');
		$lock->setDescription('If the form is locked it cannot be changed in 
			anyway.');
		$lock->addMultiOptions(
			array(1=>'Unlock', 2=>'Lock'));
		$lock->setRequired();
		$lock->setAttrib('class', 'form-control input-sm');
		$lock->setBelongsTo('params');
		
		$this->elements['lock'] = $lock;
		
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