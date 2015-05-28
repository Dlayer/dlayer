<?php
/**
* Form for the form layout tool
* 
* Allows a user to define the layout of the form, this is the layout of 
* label and fields as well as the titles and button labels
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_Form_FormLayout extends Dlayer_Form_Module_Form
{
	/**
	* Set the initial properties for the form
	*
	* @param integer $form_id
	* @param array $field_data Data array containing all the current values 
	* 	for the fields on the form, typically the values are set to FALSE, in 
	* 	the case of the settings form there are always values
	* @param boolean $edit_mode Is the tool currently in edit mode
	* @param integer $multi_use Multi use param for tool tab
	* @param array|NULL $options Zend form options data array
	* @return void
	*/
	public function __construct($form_id, array $field_data, $edit_mode=FALSE,
		$multi_use, $options=NULL)
	{
		$this->tool = 'form-layout';

		parent::__construct($form_id, $field_data, $edit_mode, $multi_use, 
			$options);
	}

	/**
	* Initialuse the form, sers the url and submit method and then calls the
	* methods that set up the form
	*
	* @return void
	*/
	public function init()
	{
		$this->setAction('/form/process/tool');

		$this->setMethod('post');

		$this->setUpFormElements();

		$this->validationRules();

		$this->addElementsToForm('form_layout', 
			'Form layout <small>Change how the form appears</small>', 
			$this->elements);

		$this->addDefaultElementDecorators();

		$this->addCustomElementDecorators();
	}

	/**
	* Set up all the elements required for the form, these are broken down 
	* into two sections, hidden elements for the tool and then visible 
	* elements for the user
	*
	* @return void The form elements are written to the private $this->elemnets
	* 			   array
	*/
	protected function setUpFormElements()
	{
		$this->toolElements();

		$this->userElements();
	}

	/**
	* Set up the tool elements, these are the elements that define the tool and 
	* store the session values for the designer
	*
	* @return void Writes the elements to the private $this->elements array
	*/
	private function toolElements()
	{
		$form_id = new Zend_Form_Element_Hidden('form_id');
		$form_id->setValue($this->form_id);

		$this->elements['form_id'] = $form_id;

		$tool = new Zend_Form_Element_Hidden('tool');
		$tool->setValue($this->tool);

		$this->elements['tool'] = $tool;

		$multi_use = new Zend_Form_Element_Hidden('multi_use');
		$multi_use->setValue($this->multi_use);
		$multi_use->setBelongsTo('params');

		$this->elements['multi_use'] = $multi_use;
	}

	/**
	* Set up the user elements, these are the elements that the user interacts 
	* with to use the tool
	* 
	* @return void Writes the elements to the private $this->elements array
	*/
	private function userElements()
	{
		$title = new Zend_Form_Element_Text('title');
		$title->setLabel('Title');
		$title->setDescription('Enter a title for the form, this will appear 
			above the form.');
		$title->setAttribs(array('maxlength'=>255, 'size'=>50, 
			'class'=>'form-control input-sm'));
		$title->setValue($this->field_data['title']);
		$title->setBelongsTo('params');
		$title->setRequired();

		$this->elements['title'] = $title;
		
		$sub_title = new Zend_Form_Element_Text('sub_title');
		$sub_title->setLabel('Sub title');
		$sub_title->setDescription('Enter an optional sub title, this appear 
			to the right of the title in a smaller and light font.');
		$sub_title->setAttribs(array('maxlength'=>255, 'size'=>50, 
			'class'=>'form-control input-sm'));
		$sub_title->setValue($this->field_data['sub_title']);
		$sub_title->setBelongsTo('params');

		$this->elements['sub_title'] = $sub_title;
		
		$submit_label = new Zend_Form_Element_Text('submit_label');
		$submit_label->setLabel('Button label');
		$submit_label->setDescription("Enter the text for the submit button, 
			the default value is 'send'.");
		$submit_label->setAttribs(array('maxlength'=>255, 'size'=>50, 
			'class'=>'form-control input-sm'));
		$submit_label->setValue($this->field_data['submit_label']);
		$submit_label->setBelongsTo('params');
		$submit_label->setRequired();

		$this->elements['submit_label'] = $submit_label;
		
		$reset_label = new Zend_Form_Element_Text('reset_label');
		$reset_label->setLabel('Reset label');
		$reset_label->setDescription("If you would like your form to have 
			a reset button please enter the name for the button here, if left 
			blank the form will not have a reset button.");
		$reset_label->setAttribs(array('maxlength'=>255, 'size'=>50, 
			'class'=>'form-control input-sm'));
		$reset_label->setValue($this->field_data['reset_label']);
		$reset_label->setBelongsTo('params');
		$reset_label->setRequired();

		$this->elements['reset_label'] = $reset_label;

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('class', 'submit');
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

	}
}