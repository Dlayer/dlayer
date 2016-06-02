<?php
/**
 * Create or update a site
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Form_Site_Site extends Dlayer_Form_Module_App
{
	/**
	 * @var string
	 */
	private $post_uri;

	/**
	 * @var integer|NULL
	 */
	private $site_id;

	/**
	 * Dlayer_Form_Site_Site constructor. Pass in anything needed to set up the form and set options
	 *
	 * @param string $post_uri Uri to post to
	 * @param integer|NULL $site_id Site id if we are editing
	 * @param array|NULL $options
	 */
	public function __construct($post_uri, $site_id = NULL, $options = NULL)
	{
		$this->post_uri = $post_uri;
		$this->site_id = $site_id;

		$this->elements_data = array(
			'name' => NULL,
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

		if($this->form_id === NULL)
		{
			$legend = ' <small>Create a new web site</small>';
		}
		else
		{
			$legend = ' <small>Edit web site details details</small>';
		}
		$this->addElementsToForm('form_site', 'Web site' . $legend, $this->elements);

		$this->addDefaultElementDecorators();

		$this->addCustomElementDecorators();
	}


	/**
	 * Fetch the data for the set site id
	 *
	 * @return void
	 */
	protected function elementsData()
	{
		if($this->site_id !== NULL)
		{
			$model_sites = new Dlayer_Model_Site();
			$site = $model_sites->site($this->site_id);

			if($site !== false)
			{
				$this->elements_data['name'] = $site['name'];
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
		$name->setLabel('Name');
		$name->setDescription('Enter a name for your new web site, this will only display within Dlayer, not anywhere 
		    on your web site.');
		$name->setAttribs(array('size'=>50, 'maxlength'=>255, 'placeholder'=>'e.g., My new site',
			'class'=>'form-control'));
		$name->setValue($this->elements_data['name']);

		$this->elements['name'] = $name;

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
		$session_dlayer = new Dlayer_Session();

		$this->elements['name']->setRequired();
		$this->elements['name']->addValidator(new Dlayer_Validate_SiteNameUnique($session_dlayer->identityId()));
	}
}
