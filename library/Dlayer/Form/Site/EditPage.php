<?php
/**
* Edit page
* 
* Allows the user to edit the details for the currently selected site page
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_Site_EditPage extends Dlayer_Form_Module_App 
{
	private $site_id;
	private $page_id;
	private $data = array();

	/**
	* Pass in any values that are needed to set up the form
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param array|NULL Options for form
	* @return void
	*/
	public function __construct($site_id, $page_id, $options=NULL)
	{
		$this->site_id = $site_id;
		$this->page_id = $page_id;

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
		$this->setAction('/content/index/edit-page');

		$this->setMethod('post');

		$this->formElementsData();

		$this->setUpFormElements();

		$this->validationRules();

		$this->addElementsToForm('edit_page', 
			'Edit content page <small>Edit selected page</small>', 
			$this->elements);

		$this->addDefaultElementDecorators();

		$this->addCustomElementDecorators();
	}

	/**
	* Fetch the current data for the page so that the values can be 
	* assigned to the form fields, also fetches any data required to populate 
	* the form fields
	* 
	* @return void Writes the data to the $this->data property
	*/
	private function formElementsData() 
	{
		$model_pages = new Dlayer_Model_Page();
		$model_templates = new Dlayer_Model_Template();

		$this->data['templates'] = $model_templates->templateNames(
			$this->site_id);
		$this->data['data'] = array();

		$data = $model_pages->page($this->page_id, $this->site_id);

		if($data != FALSE) {
			$this->data['data'] = $data;
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
		$name->setLabel('Page name');
		$name->setDescription('Enter the new name for this content page, 
			this will only display within Dlayer, not anywehre on your site.');
		$name->setAttribs(array('size'=>50, 'maxlength'=>255, 
			'class'=>'form-control'));
		if(array_key_exists('name', $this->data['data']) == TRUE) {
			$name->setValue($this->data['data']['name']);
		}

		$this->elements['name'] = $name;

		$title = new Zend_Form_Element_Text('title');
		$title->setLabel('Page title');
		$title->setDescription("Enter the new title for this content page, this 
			will be shown in the title bar of the user's web browser");
		$title->setAttribs(array('size'=>50, 'maxlength'=>255, 
			'class'=>'form-control'));
		if(array_key_exists('title', $this->data['data']) == TRUE) {
			$title->setValue($this->data['data']['title']);
		}

		$this->elements['title'] = $title;

		$description = new Zend_Form_Element_Textarea('description');
		$description->setLabel('Page description');
		$description->setDescription('Enter the new description, this will be 
			used to populate the description meta tag.');
		$description->setAttribs(array('cols'=>50, 'rows'=>4, 
			'placeholder'=>'e.g., Displays the top five news items', 
			'class'=>'form-control'));
		if(array_key_exists('description', $this->data['data']) == TRUE) {
			$description->setValue($this->data['data']['description']);
		}

		$this->elements['description'] = $description;

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
			new Dlayer_Validate_PageNameUnique($this->site_id, $this->page_id));

		$this->elements['title']->setRequired();
	}
}