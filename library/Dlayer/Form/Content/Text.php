<?php

/**
 * Form for the text content item tool
 *
 * The form is used by the Text content item to allow a user to define or edit
 * a text content item, a text content item is essentially just a plain text
 * block. This form is also used by the edit version of the tool.
 *
 * @todo Work on this form and then create the base form for the module
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Form_Content_Text extends Dlayer_Form
{
	protected $tool = array();
	protected $content_type = 'text';

	/**
	 * Set the properties for the form
	 *
	 * @param array $tool Tool and environment data array
	 * @param array|NULL $options Zend form options
	 */
	public function __construct(array $tool, $options=NULL)
	{
		$this->tool = $tool;

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

		$this->addElementsToForm('heading_item', 'Form here', $this->elements);

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
		$tool->setValue('text');

		$this->elements['tool'] = $tool;

		$content_type = new Zend_Form_Element_Hidden('content_type');
		$content_type->setValue('text');

		$this->elements['content_type'] = $content_type;

		$multi_use = new Zend_Form_Element_Hidden('multi_use');
		$multi_use->setValue(1);

		$this->elements['multi_use'] = $multi_use;

		$page_id = new Zend_Form_Element_Hidden('page_id');
		$page_id->setValue(1);

		$this->elements['page_id'] = $page_id;

		$row_id = new Zend_Form_Element_Hidden('row_id');
		$row_id->setValue(1);

		$this->elements['row_id'] = $row_id;

		$column_id = new Zend_Form_Element_Hidden('column_id');
		$column_id->setValue(1);

		$this->elements['column_id'] = $column_id;

		$content_id = new Zend_Form_Element_Hidden('content_id');
		$content_id->setValue(NULL);

		$this->elements['content_id'] = $content_id;
	}

	protected function generateUserElements()
	{
		// Name
		// Text
	}

	protected function generateSubmitElement()
	{
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttribs(array('class'=>'btn btn-primary'));
		$submit->setLabel('Save');

		$this->elements['submit'] = $submit;
	}


	protected function generateFormElements()
	{
		$this->generateToolElements();

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
