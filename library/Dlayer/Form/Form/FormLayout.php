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
		
		$this->getFormElementsData();

		$this->setUpFormElements();

		$this->validationRules();

		$this->addElementsToForm('form_layout', 
			'Form layout <small>Change how the form appears</small>', 
			$this->elements);

		$this->addDefaultElementDecorators();

		$this->addCustomElementDecorators();
	}
	
	/**
	* Fetch any data needed to generated the form elements, in this case the 
	* layout options for the form
	* 
	* @return void Writes the data to the $this->elements_data property
	*/
	private function getFormElementsData() 
	{
		$model_layout = new Dlayer_Model_Form_Layout();
		$this->elements_data = $model_layout->layoutOptions();
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
		$submit_label->setDescription("Enter the text for the submit button.");
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

		$this->elements['reset_label'] = $reset_label;
		
		$layout_option = new Zend_Form_Element_Select('layout_id');
		$layout_option->setLabel('Layout option');
		$layout_option->setDescription('Select the layout option for your 
			form, standard, horizontal or inline, check the help tab for a 
			description of each option.');
		$layout_option->addMultiOptions($this->elements_data);
		$layout_option->setRequired();
		$layout_option->setAttrib('class', 'form-control input-sm');
		$layout_option->setValue($this->field_data['layout_id']);
		$layout_option->setBelongsTo('params');
		
		$this->elements['layout_id'] = $layout_option;
		
		$horizontal_width_label = new Dlayer_Form_Element_Number(
			'horizontal_width_label');
		$horizontal_width_label->setAttribs(array('max'=>12, 'min'=>1, 
			'class'=>'form-control input-sm'));
		$horizontal_width_label->setLabel(
			'<span class="glyphicon glyphicon-plus toggle" 
			id="fgc-horizontal_width_label" title="Expand for more" aria-hidden="true">
			</span> Label width (Horizontal mode)');
		$horizontal_width_label->setDescription('Set the width of the label 
			when using the horizontal layout option, should be a value between 
			one and 12');
		$horizontal_width_label->setBelongsTo('params');
		$horizontal_width_label->setValue(
			$this->field_data['horizontal_width_label']);
		
		$this->elements['horizontal_width_label'] = $horizontal_width_label;
		
		$horizontal_width_field = new Dlayer_Form_Element_Number(
			'horizontal_width_field');
		$horizontal_width_field->setAttribs(array('max'=>12, 'min'=>1, 
			'class'=>'form-control input-sm'));
		$horizontal_width_field->setLabel(
			'<span class="glyphicon glyphicon-plus toggle" 
			id="fgc-horizontal_width_field" title="Expand for more" aria-hidden="true">
			</span> Field width (Horizontal mode)');
		$horizontal_width_field->setDescription('Set the width of the field 
			when using the horizontal layout option, should be a value between 
			one and 12');
		$horizontal_width_field->setBelongsTo('params');
		$horizontal_width_field->setValue(
			$this->field_data['horizontal_width_field']);
		
		$this->elements['horizontal_width_field'] = $horizontal_width_field;

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
	
	/**
	* Add any custom decorators, these are inputs where we need a little more
	* control over the html, an example being the submit button
	*
	* @return void
	*/
	protected function addCustomElementDecorators()
	{
		parent::addCustomElementDecorators();
		
		$this->elements['horizontal_width_label']->setDecorators(
			array(
				array('ViewHelper'), 
				array('Description', array('tag' => 'p', 'class'=>'help-block')),
				array('Errors', array('class'=> 'alert alert-danger')), 
				array('Label', array('escape'=>FALSE)), 
				array('HtmlTag', array(
					'tag' => 'div', 
					'class'=> array(
						'callback' => function($decorator) {
							if($decorator->getElement()->hasErrors()) {
								return 'form-group has-error';
							} else {
								return 'form-group form-group-collapsed';
							}
					})
				))
			)
		);
		
		$this->elements['horizontal_width_field']->setDecorators(
			array(
				array('ViewHelper'), 
				array('Description', array('tag' => 'p', 'class'=>'help-block')),
				array('Errors', array('class'=> 'alert alert-danger')), 
				array('Label', array('escape'=>FALSE)), 
				array('HtmlTag', array(
					'tag' => 'div', 
					'class'=> array(
						'callback' => function($decorator) {
							if($decorator->getElement()->hasErrors()) {
								return 'form-group has-error';
							} else {
								return 'form-group form-group-collapsed';
							}
					})
				))
			)
		);
	}
}