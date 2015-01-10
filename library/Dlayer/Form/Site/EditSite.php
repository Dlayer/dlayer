<?php
/**
* Allows a user to edit the details for the selected web site
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_Site_EditSite extends Dlayer_Form_Module_App 
{
	private $identity_id;
	private $site_id;
	private $data = array();

	/**
	* Pass in any values that are needed to set up the form
	* 
	* @param integer $identity_id
	* @param integer $site_id
	* @param array|NULL Options for form
	* @return void
	*/
	public function __construct($identity_id, $site_id, $options=NULL)
	{
		$this->identity_id = $identity_id;
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
		$this->setAction('/dlayer/index/edit-site');

		$this->setMethod('post');

		$this->formElementsData();

		$this->setUpFormElements();

		$this->validationRules();

		$this->addElementsToForm('edit_site', 
			'Edit web site <small>Edit selected web site</small>', 
			$this->elements);

		$this->addDefaultElementDecorators();

		$this->addCustomElementDecorators();
	}

	/**
	* Fetch the current data for the site, gets assigned to the form 
	* fields
	* 
	* @return void Writes the data to the $this->data property
	*/
	private function formElementsData() 
	{
		$model_sites = new Dlayer_Model_Site();
		$data = $model_sites->site($this->site_id);

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
		$name->setDescription('Enter the new name for your site, this will 
		only display within Dlayer.');
		$name->setAttribs(array('size'=>50, 'maxlength'=>255, 
			'class'=>'form-control'));
		if(array_key_exists('name', $this->data) == TRUE) {
			$name->setValue($this->data['name']);
		}
		$this->elements['name'] = $name;

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttribs(array('class'=>'btn btn-primary'));
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
		$this->elements['name']->setRequired();
		$this->elements['name']->addValidator(
			new Dlayer_Validate_SiteNameUnique($this->identity_id, 
				$this->site_id));
	}
}