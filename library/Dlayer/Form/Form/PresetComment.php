<?php
/**
* Form for the preset comment field tool
* 
* Allows the user to quickly create a comment field, the user simply needs to 
* click save, the values can be overridden later as the new field acts as per 
* a standard text area field
* 
* @todo In addition to adding the field this tool also defines some validation 
* and other settings
*  
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_Form_PresetComment extends Dlayer_Form_Module_Form
{
	/**
	* Set the initial properties for the form
	*
	* @param integer $form_id
	* @param array $field_data Field data array, either an array with all the 
	* 						   attrubutes and their current value or an array 
	* 						   with FALSE as the value for each attribute
	* @param boolean $edit_mode Is the tool currently in edit mode
	* @param integer $multi_use Multi use param for tool tab
	* @param array|NULL $options Zend form options data array
	* @return void
	*/
	public function __construct($form_id, array $field_data, $edit_mode=FALSE,
		$multi_use, $options=NULL)
	{
		$this->tool = 'preset-comment';
		$this->field_type = 'textarea';
		
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
		
		$legend = 'Add <small>Comment field</small>'; 
		$this->addElementsToForm('comment_field', $legend, $this->elements);

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

		$field_type = new Zend_Form_Element_Hidden('field_type');
		$field_type->setValue($this->field_type);

		$this->elements['field_type'] = $field_type;

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
		$label = new Zend_Form_Element_Text('label');
		$label->setBelongsTo('params');
		$label->setAttribs(array('class'=>'form-control input-sm'));
		$label->setValue('Your comment');

		$this->elements['label'] = $label;

		$description = new Zend_Form_Element_Textarea('description');
		$description->setBelongsTo('params');
		$description->setAttribs(array('class'=>'form-control input-sm', 'rows'=>5));
		$description->setValue('Please enter your comment');

		$this->elements['description'] = $description;

		$placeholder = new Zend_Form_Element_Text('placeholder');
		$placeholder->setBelongsTo('params');
		$placeholder->setAttribs(array('class'=>'form-control input-sm'));
		$placeholder->setValue('I think that it would.....');

		$this->elements['placeholder'] = $placeholder;

		$cols = new Dlayer_Form_Element_Number('cols');
		$cols->setValue(40);
		$cols->setAttribs(array('class'=>'form-control input-sm'));
		$cols->setBelongsTo('params');

		$this->elements['cols'] = $cols;

		$rows = new Dlayer_Form_Element_Number('rows');
		$rows->setValue(3);
		$rows->setAttribs(array('class'=>'form-control input-sm'));
		$rows->setBelongsTo('params');

		$this->elements['rows'] = $rows;

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttribs(array('class'=>'btn btn-primary'));
		$submit->setLabel('Add comment field');

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