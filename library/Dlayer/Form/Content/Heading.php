<?php

/**
 * Form for the heading content item tool
 *
 * The form is used by the heading content item to allow a user to define or edit a heading content item, the form is
 * also used by the edit version of the tool
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Form_Content_Heading extends Dlayer_Form
{
	protected $tool = array();
	protected $content_type = 'text';
	protected $data = array();
	protected $instances = 0;
	protected $element_data = array();

	/**
	 * Set the properties for the form
	 *
	 * @param array $tool Tool and environment data array
	 * @param array $data Current data for content item
	 * @param integer $instances Instances of content data on web site
	 * @param array $element_data Data array containing data for elements (Select menu etc.)
	 * @param array|NULL $options Zend form options
	 */
	public function __construct(array $tool, array $data, $instances, array $element_data, $options=NULL)
	{
		$this->tool = $tool;
		$this->data = $data;
		$this->instances = $instances;
		$this->element_data = $element_data;

		parent::__construct($options);
	}

	/**
	 * Initialise the form, sets the action and method and then calls the elements to build the form
	 *
	 * @return void
	 */
	public function init()
	{
		$this->setAction('/content/process/tool');

		$this->setMethod('post');

		$this->generateFormElements();

		$this->addElementsToForm('heading_content_item', 'Heading', $this->elements);

		$this->addDefaultElementDecorators();

		$this->addCustomElementDecorators();
	}

	/**
	 * Set up the tool elements, these are the elements that are part of every tool and set the environment
	 * properties and tool options
	 *
	 * @todo Move this method into base class
	 * @return void The elements are written to the $this->elements private property
	 */
	protected function generateToolElements()
	{
		$tool = new Zend_Form_Element_Hidden('tool');
		$tool->setValue($this->tool['name']);

		$this->elements['tool'] = $tool;

		$content_type = new Zend_Form_Element_Hidden('content_type');
		$content_type->setValue($this->content_type);

		$this->elements['content_type'] = $content_type;

		$multi_use = new Zend_Form_Element_Hidden('multi_use');
		$multi_use->setValue($this->tool['multi_use']);

		$this->elements['multi_use'] = $multi_use;

		$page_id = new Zend_Form_Element_Hidden('page_id');
		$page_id->setValue($this->tool['page_id']);

		$this->elements['page_id'] = $page_id;

		$row_id = new Zend_Form_Element_Hidden('row_id');
		$row_id->setValue($this->tool['row_id']);

		$this->elements['row_id'] = $row_id;

		$column_id = new Zend_Form_Element_Hidden('column_id');
		$column_id->setValue($this->tool['column_id']);

		$this->elements['column_id'] = $column_id;

		$content_id = new Zend_Form_Element_Hidden('content_id');
		$content_id->setValue($this->tool['content_id']);

		$this->elements['content_id'] = $content_id;
	}

	protected function generateUserElements()
	{
		$name = new Zend_Form_Element_Text('name');
		$name->setLabel('Name');
		$name->setAttribs(array('cols'=>50, 'row'=>15, 'placeholder'=>'e.g., Page title',
			'class'=>'form-control input-sm'));
		$name->setDescription('Give the content item a name, this will allow you to recreate it again later.');
		$name->setBelongsTo('params');
		$name->setRequired();

		if(array_key_exists('name', $this->data) === TRUE && $this->data['name'] !== FALSE)
		{
			$name->setValue($this->data['name']);
		}

		$this->elements['name'] = $name;

		if($this->tool['content_id'] !== NULL && $this->instances > 1)
		{
			$instances = new Zend_Form_Element_Select('instances');
			$instances->setLabel('Update shared content?');
			$instances->setDescription("The content below is used {$this->instances} times on your web site, do you 
				want to update the text for this content item only or all content items?");
			$instances->setMultiOptions(
				array(
					1 => 'Yes - update all content items',
					0 => 'No - Please only update this item'
				)
			);
			$instances->setAttribs(array('class' => 'form-control input-sm'));
			$instances->setBelongsTo('params');

			$this->elements['instances'] = $instances;
		}

		$heading = new Zend_Form_Element_Textarea('heading');
		$heading->setLabel('Heading');
		$heading->setAttribs(array('cols'=>80, 'rows'=>2, 'placeholder'=>'e.g., Our projects',
			'class'=>'form-control input-sm'));
		$heading->setDescription('Enter your heading.');
		$heading->setBelongsTo('params');
		$heading->setRequired();

		if(array_key_exists('heading', $this->data) === TRUE && $this->data['heading'] !== FALSE)
		{
			$heading->setValue($this->data['heading']);
		}

		$this->elements['heading'] = $heading;

		$sub_heading = new Zend_Form_Element_Textarea('sub_heading');
		$sub_heading->setLabel('Sub heading');
		$sub_heading->setAttribs(array('cols'=>80, 'rows'=>2, 'placeholder'=>'e.g., What are we working on?',
			'class'=>'form-control input-sm'));
		$sub_heading->setDescription('Enter an optional sub heading.');
		$sub_heading->setBelongsTo('params');

		if(array_key_exists('sub_heading', $this->data) === TRUE && $this->data['sub_heading'] !== FALSE)
		{
			$sub_heading->setValue($this->data['sub_heading']);
		}

		$this->elements['sub_heading'] = $sub_heading;

		$heading_type = new Zend_Form_Element_Select('heading_type');
		$heading_type->setLabel('Heading type');
		if(array_key_exists('heading_type', $this->element_data) &&
			is_array($this->element_data['heading_type']) === TRUE)
		{
			$heading_type->setMultiOptions($this->element_data['heading_type']);
		}
		else
		{
			$heading_type->setMultiOptions(array());
		}
		$heading_type->setDescription('Choose a heading type.');
		$heading_type->setAttribs(array('class'=>'form-control input-sm'));
		$heading_type->setBelongsTo('params');
		$heading_type->setRequired();

		if(array_key_exists('heading_type', $this->data) === TRUE && $this->data['heading_type'] !== FALSE)
		{
			$heading_type->setValue($this->data['heading_type']);
		}

		$this->elements['heading_type'] = $heading_type;
	}

	protected function generateSubmitElement()
	{
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttribs(array('class'=>'btn btn-primary'));
		$submit->setLabel('Save');

		$this->elements['submit'] = $submit;
	}

	/**
	 * Create the form elements and assign them to $this->elements, array will be passed to
	 * Dlayer_Form::addElementsToForm()
	 *
	 * @return void
	 */
	protected function generateFormElements()
	{
		$this->generateToolElements();

		$this->generateUserElements();

		$this->generateSubmitElement();
	}

	/**
	 * Add validation rules
	 *
	 * @return void
	 */
	protected function validationRules()
	{
		// TODO: Implement validationRules() method.
	}

	/**
	 * Add the default element decorators
	 *
	 * @return void
	 */
	protected function addDefaultElementDecorators()
	{
		$this->setDecorators(array(
			'FormElements',
			array('Form', array('class'=>'form'))));

		$this->setElementDecorators(array(
			array('ViewHelper'),
			array('Description', array('tag' => 'p', 'class'=>'help-block')),
			array('Errors', array('class'=> 'alert alert-danger')),
			array('Label'),
			array('HtmlTag', array(
				'tag' => 'div',
				'class'=> array(
					'callback' => function($decorator) {
						if($decorator->getElement()->hasErrors()) {
							return 'form-group has-error';
						} else {
							return 'form-group';
						}
					})
			))
		));

		$this->setDisplayGroupDecorators(array(
			'FormElements',
			'Fieldset',
		));
	}

	protected function addCustomElementDecorators()
	{
		$this->elements['submit']->setDecorators(array(array('ViewHelper'),
			array('HtmlTag', array(
				'tag' => 'div',
				'class'=>'form-group form-group-submit')
			)
		));
	}
}
