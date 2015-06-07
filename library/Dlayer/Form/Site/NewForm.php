<?php
/**
* Allows the user to create a new form for use within the current site
*  
* @author Dean Blackborough
* @copyright G3D Development Limited
* @version $Id: NewForm.php 1724 2014-04-13 15:12:59Z Dean.Blackborough $
*/
class Dlayer_Form_Site_NewForm extends Dlayer_Form_Module_App 
{
	private $site_id;

	/**
	* Pass in any values that are needed to set up the form
	* 
	* @param integer $site_id
	* @param array|NULL Options for form
	* @return void
	*/
	public function __construct($site_id, $options=NULL)
	{
		$this->site_id = $site_id;

		parent::__construct($options=NULL);
	}

	/**
	* Initialise the form, sets the url and submit method and then calls 
	* the methods that set up the form itself
	* 
	* @return void
	*/
	public function init() 
	{        
		$this->setAction('/form/index/new-form');

		$this->setMethod('post');

		$this->setUpFormElements();

		$this->validationRules();

		$this->addElementsToForm('new_form', 
			'New form <small>Create new form</small>', 
			$this->elements);

		$this->addDefaultElementDecorators();

		$this->addCustomElementDecorators();
	}

	/** 
	* Set up the form elements needed for this form
	* 
	* @return void Form elements are written to the private $this->elements 
	*              property
	*/
	protected function setUpFormElements() 
	{
		$name = new Zend_Form_Element_Text('name');
		$name->setLabel('Name');
		$name->setDescription('Enter a name for your new form, this name will 
			only appear within Dlayer, specifically the management pages and 
			the form picker.');
		$name->setAttribs(array('size'=>50, 'maxlength'=>255, 
			'placeholder'=>'e.g., Contact form', 'class'=>'form-control'));
		$name->setRequired();

		$this->elements['name'] = $name;
		
		$title = new Zend_Form_Element_Text('title');
		$title->setLabel('Title');
		$title->setDescription('Enter a title for your new form, this can be 
			changed later in the Form builder using the settings tools.');
		$title->setAttribs(array('size'=>50, 'maxlength'=>255, 
			'placeholder'=>'e.g., Contact us', 'class'=>'form-control'));
		$title->setRequired();
		
		$this->elements['title'] = $title;
		
		$email = new Dlayer_Form_Element_Email('email');
		$email->setLabel('Email');
		$email->setDescription('Enter the email address that submissions will 
			be sent to, Dlayer defaults to not sending through submissions, 
			the option needs to be turned on.');
		$email->setAttribs(array('size'=>50, 'maxlength'=>255, 
			'placeholder'=>'e.g., email@email.com us', 'class'=>'form-control'));
		$email->setRequired();

		$this->elements['email'] = $email;

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Save');
		$submit->setAttribs(array('class'=>'btn btn-primary'));
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
		$this->elements['name']->addValidator(
			new Dlayer_Validate_FormNameUnique($this->site_id));
			
		$this->elements['email']->addValidator(
			new Zend_Validate_EmailAddress());
	}
}