<?php
/**
* Allows a user to create a new web site
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_Site_NewSite extends Dlayer_Form_Module_App 
{
	private $identity_id;

	/**
	* Pass in any values that are needed to set up the form
	* 
	* @param integer $identity_id
	* @param array|NULL Options for form
	* @return void
	*/
	public function __construct($identity_id, $options=NULL)
	{
		$this->identity_id = $identity_id;

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
		$this->setAction('/dlayer/index/new-site');

		$this->setMethod('post');

		$this->setUpFormElements();

		$this->validationRules();

		$this->addElementsToForm('new_site', 'New site', 
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
		$name->setDescription('Enter a name for your site, this will only 
			display within Dlayer, you can define the URL and other details 
		later.');
		$name->setAttribs(array('size'=>50, 'maxlength'=>255, 
			'placeholder'=>'e.g., My new site', 'class'=>'form-control'));
		$this->elements['name'] = $name;

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
		$this->elements['name']->setRequired();
		$this->elements['name']->addValidator(
			new Dlayer_Validate_SiteNameUnique($this->identity_id));
	}
}