<?php
/**
* Allows the user to edit the details for the currently selected site form
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_Site_EditForm extends Dlayer_Form_Module_App 
{
	private $site_id;
	private $form_id;
	private $data = array();

	/**
	* Pass in any values that are needed to set up the form
	* 
	* @param integer $site_id
	* @param integer $form_id
	* @param array|NULL Options for form
	* @return void
	*/
	public function __construct($site_id, $form_id, $options=NULL)
	{
		$this->site_id = $site_id;
		$this->form_id = $form_id;

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
		$this->setAction('/form/index/edit-form');

		$this->setMethod('post');

		$this->formElementsData();

		$this->setUpFormElements();

		$this->validationRules();

		$this->addElementsToForm('edit_form', 'Edit form', 
			$this->elements);

		$this->addDefaultElementDecorators();

		$this->addCustomElementDecorators();
	}

	/**
	* Fetch the current data for the template so that the values can be 
	* assigned to the form fields
	* 
	* @return void Writes the data to the $this->data property
	*/
	private function formElementsData() 
	{
		$model_forms = new Dlayer_Model_Form();
		$data = $model_forms->form($this->form_id, $this->site_id);

		if($data != FALSE) {
			$this->data = $data;
		}
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
		$name->setDescription('Enter the new name for your form, this will 
		only display within Dlayer');
		$name->setAttribs(array('size'=>50, 'maxlength'=>255, 
			'class'=>'form-control'));
		if(array_key_exists('name', $this->data) == TRUE) {
			$name->setValue($this->data['name']);
		}
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
			new Dlayer_Validate_FormNameUnique($this->site_id, $this->form_id));
	}
}