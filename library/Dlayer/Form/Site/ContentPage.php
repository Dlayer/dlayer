<?php
/**
 * Create or update a content page
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Form_Site_ContentPage extends Dlayer_Form_Module_App 
{
	/**
	 * @var string
	 */
	private $post_uri;

	/**
	 * @var integer
	 */
	private $site_id;

	/**
	 * @var integer|NULL
	 */
	private $page_id;

	/**
	 * Dlayer_Form_Site_NewPage constructor. Pass in anything needed to set up the form and set options
	 *
	 * @param string $post_uri Uri to post to
	 * @param integer $site_id
	 * @param integer|NULL $page_id Page id if we are editing
	 * @param array|NULL $options
	 */
	public function __construct($post_uri, $site_id, $page_id=NULL, array $options=NULL)
	{
		$this->post_uri = $post_uri;
		$this->site_id = $site_id;
		$this->page_id = $page_id;

		$this->elementsData = array(
			'name' => NULL,
			'title' => NULL,
			'description' => NULL,
		);

		parent::__construct($options=NULL);
	}

	/**
	 * Initialise the form, set the process uri and method and then call the setup methods which create the form
	 *
	 * @return void
	 */
	public function init() 
	{        
		$this->setAction($this->post_uri);

		$this->setMethod('post');

		$this->elementsData();

		$this->setUpFormElements();

		$this->validationRules();

		if($this->page_id === NULL)
		{
			$legend = '<small>Create a new content page</small>';
		}
		else
		{
			$legend = '<small>Edit content page details</small>';
		}
		$this->addElementsToForm('content_page', 'Content page' . $legend, $this->elements);

		$this->addDefaultElementDecorators();

		$this->addCustomElementDecorators();
	}

	/**
	 * Fetch the data for the current page
	 *
	 * @return void
	 */
	protected function elementsData()
	{
		if($this->page_id != NULL)
		{
			$model_pages = new Dlayer_Model_Page();
			$page = $model_pages->page($this->page_id);

			if($page !== false)
			{
				$this->elementsData['name'] = $page['name'];
				$this->elementsData['title'] = $page['title'];
				$this->elementsData['description'] = $page['description'];
			}
		}
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
		$name->setDescription('Enter a name for your content page, this will only display within Dlayer, not anywhere 
			on your web site.');
		$name->setAttribs(array('size'=>50, 'maxlength'=>255, 'placeholder'=>'e.g., News page', 'class'=>'form-control'));
		$name->setValue($this->elementsData['name']);
		$this->elements['name'] = $name;
		
		$title = new Zend_Form_Element_Text('title');
		$title->setLabel('Page title');
		$title->setDescription("Enter a title your content page, this will be shown in the title bar of the user's 
			web browser.");
		$title->setAttribs(array('size'=>50, 'maxlength'=>255, 'placeholder'=>"e.g., All the news for 'My new site'",
			'class'=>'form-control'));
		$title->setValue($this->elementsData['description']);
		$this->elements['title'] = $title;

		$description = new Zend_Form_Element_Textarea('description');
		$description->setLabel('Page description');
		$description->setDescription('Enter a description for your content page, this will be used to populate the 
			description meta tag.');
		$description->setAttribs(array('cols'=>50, 'rows'=>4, 'placeholder'=>'e.g., Displays the top five news items',
			'class'=>'form-control'));
		$description->setValue($this->elementsData['description']);
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
		$this->elements['name']->addValidator(new Dlayer_Validate_PageNameUnique($this->site_id, $this->page_id));
		$this->elements['description']->setRequired();
		$this->elements['title']->setRequired();
	}
}
