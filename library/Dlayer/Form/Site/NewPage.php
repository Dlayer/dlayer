<?php
/**
 * Create a new content page
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Form_Site_NewPage extends Dlayer_Form_Module_App 
{
	/**
	 * @var integer
	 */
	private $site_id;

	/**
	 * Dlayer_Form_Site_NewPage constructor. Pass in anything needed to set up the form and set options
	 *
	 * @param null $site_id
	 * @param array|NULL $options
	 * @return void
	 */
	public function __construct($site_id, array $options=NULL)
	{
		$this->site_id = $site_id;

		parent::__construct($options=NULL);
	}

	/**
	 * Initialise the form, set the process uri and method and then call the setup methods which create the form
	 *
	 * @return void
	 */
	public function init() 
	{        
		$this->setAction('/content/index/new-page');

		$this->setMethod('post');

		$this->setUpFormElements();

		$this->validationRules();

		$this->addElementsToForm('content_page', 'Content page <small>Create a new content page</small>', $this->elements);

		$this->addDefaultElementDecorators();

		$this->addCustomElementDecorators();
	}

	/**
	 * Create the form elements and assign them to $this->elements, array will be passed to
	 * Dlayer_Form::addElementsToForm()
	 *
	 * @return void
	 */
	protected function setUpFormElements() 
	{
		$name = new Zend_Form_Element_Text('name');
		$name->setLabel('Page name');
		$name->setDescription('Enter a name for the new content page, this 
			will only display within Dlayer, not anywhere on your site.');
		$name->setAttribs(array('size'=>50, 'maxlength'=>255, 
			'placeholder'=>'e.g., News page', 'class'=>'form-control'));
		$this->elements['name'] = $name;
		
		$title = new Zend_Form_Element_Text('title');
		$title->setLabel('Page title');
		$title->setDescription("Enter a title for the new content page, 
			this will be shown in the title bar of the user's web browser.");
		$title->setAttribs(array('size'=>50, 'maxlength'=>255, 
			'placeholder'=>"e.g., All the news for 'My new site'", 
			'class'=>'form-control'));
		$this->elements['title'] = $title;

		$description = new Zend_Form_Element_Textarea('description');
		$description->setLabel('Page description');
		$description->setDescription('Enter a description for the new content 
			page, this will be used to populate the description meta tag.');
		$description->setAttribs(array('cols'=>50, 'rows'=>4, 
			'placeholder'=>'e.g., Displays the top five news items', 
			'class'=>'form-control'));

		$this->elements['description'] = $description;

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Save');
		$submit->setAttribs(array('class'=>'btn btn-primary'));
		$this->elements['submit'] = $submit;
	}

	/**
	 * Add validation rules
	 *
	 * @return void
	 */
	protected function validationRules() 
	{
		$this->elements['name']->setRequired();
		$this->elements['name']->addValidator(new Dlayer_Validate_PageNameUnique($this->site_id));
		$this->elements['description']->setRequired();
		$this->elements['title']->setRequired();
	}
}
