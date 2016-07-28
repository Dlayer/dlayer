<?php
/**
 * Create or update a form
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Form_Site_Form extends Dlayer_Form_Module_App
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
	private $form_id;

	/**
	 * Dlayer_Form_Site_NewPage constructor. Pass in anything needed to set up the form and set options
	 *
	 * @param string $post_uri Uri to post to
	 * @param integer $site_id
	 * @param integer|NULL $form_id Form id if we are editing
	 * @param array|NULL $options
	 */
	public function __construct($post_uri, $site_id, $form_id=NULL, $options=NULL)
	{
		$this->post_uri = $post_uri;
		$this->site_id = $site_id;
		$this->form_id = $form_id;

		$this->elements_data = array(
			'name' => NULL,
			'title' => NULL,
			'sub_title' => NULL,
			'email' => NULL,
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

		$this->generateFormElements();

		$this->validationRules();

		if($this->form_id === NULL)
		{
			$legend = ' <small>Create a new form</small>';
		}
		else
		{
			$legend = ' <small>Edit form details</small>';
		}
		$this->addElementsToForm('form_page', 'Form' . $legend, $this->elements);

		$this->addDefaultElementDecorators();

		$this->addCustomElementDecorators();
	}

	/**
	 * Fetch the data for the set form id
	 *
	 * @return void
	 */
	protected function elementsData()
	{
		if($this->form_id !== NULL)
		{
			$model_forms = new Dlayer_Model_Form();
			$form = $model_forms->form($this->form_id, $this->site_id);

			if($form !== false)
			{
				$this->elements_data['name'] = $form['name'];
				$this->elements_data['email'] = $form['email'];
			}
		}
	}

	/**
	 * Create the form elements and assign them to $this->elements, array will be passed to
	 * Dlayer_Form::addElementsToForm()
	 *
	 * @return void
	 */
	protected function generateFormElements()
	{
		$name = new Zend_Form_Element_Text('name');
		$name->setLabel('Form name');
		$name->setDescription('Enter a name for your form, this will only display within Dlayer, not anywhere on your 
		    web site.');
		$name->setAttribs(array(
			'size'=>50, 'maxlength'=>255, 'placeholder'=>'e.g., Contact form', 'class'=>'form-control')
		);
		$name->setValue($this->elements_data['name']);

		$this->elements['name'] = $name;

		if($this->form_id === NULL)
		{
			$title = new Zend_Form_Element_Text('title');
			$title->setLabel('Form title');
			$title->setDescription('Enter a title for your form, it will be display above the form.');
			$title->setAttribs(array(
					'size' => 50, 'maxlength' => 255, 'placeholder' => 'e.g., Contact us', 'class' => 'form-control'
				)
			);
			$title->setValue($this->elements_data['title']);

			$this->elements['title'] = $title;
		}

		if($this->form_id === NULL)
		{
			$sub_title = new Zend_Form_Element_Text('sub_title');
			$sub_title->setLabel('Form sub title');
			$sub_title->setDescription('Enter an optional sub title, this displays in a smaller/ligther font after the 
			    main title.');
			$sub_title->setAttribs(array(
					'size' => 50, 'maxlength' => 255, 'placeholder' => 'e.g., and we will get back to you a.s.a.p',
					'class' => 'form-control'
				)
			);
			$sub_title->setValue($this->elements_data['sub_title']);

			$this->elements['sub_title'] = $sub_title;
		}
		
		$email = new Dlayer_Form_Element_Email('email');
		$email->setLabel('Email');
		$email->setDescription('Enter the email address that you would like a copy of submissions to be emailed to, 
		    Dlayer defaults to not sending copies of submissions, the option needs to be turned on in form settings');
		$email->setAttribs(array(
			'size'=>50, 'maxlength'=>255, 'placeholder'=>'e.g., email@email.com', 'class'=>'form-control')
		);
		$email->setValue($this->elements_data['email']);

		$this->elements['email'] = $email;

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Save');
		$submit->setAttribs(array('class'=>'btn btn-primary'));
		$this->elements['submit'] = $submit;
	}

	/**
	 * Add the validation rules for the form elements and set the custom error messages
	 *
	 * @return void
	 */
	protected function validationRules()
	{
		$this->elements['name']->setRequired();
		$this->elements['name']->addValidator(new Dlayer_Validate_FormNameUnique($this->site_id, $this->form_id));
		if($this->form_id === NULL)
		{
			$this->elements['title']->setRequired();
		}
		$this->elements['email']->setRequired();
		$this->elements['email']->addValidator(new Zend_Validate_EmailAddress());
	}
}
