<?php
/**
* Form for the jumbotron content item tool
* 
* This form is used by the jumbotron tool to allow a user to define 
* or edit a jumbotron content item. A jumbotron is a heading, with a sub line 
* in a large container. This form is also used by the edit version of the tool.
*
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_Content_Jumbotron extends Dlayer_Form_Module_Content
{
	/**
	* Set the initial properties for the form
	* 
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @param array $content_item The existing data for the content item, 
	* 	array values will be FALSE in add mode, populated in edit mode
	* @param boolean $edit_mode Is the tool in edit mode
	* @param integer $multi_use The multi use value for the tool, either 1 or 0
	* @param array|NULL $options Zend form options data array
	* @return void
	*/
	public function __construct($page_id, $div_id, $content_row_id, 
		array $content_item, $edit_mode=FALSE, $multi_use=0, $options=NULL)
	{
		$this->tool = 'jumbotron';
		$this->content_type = 'jumbotron';
		$this->sub_tool_model = NULL;

		parent::__construct($page_id, $div_id, $content_row_id, 
			$content_item, $edit_mode, $multi_use, $options);
	}

	/**
	* Initialise the form, sets the url, action method and calls the functions 
	* to build the form
	*
	* @return void
	*/
	public function init()
	{
		$this->setAction('/content/process/tool');

		$this->setMethod('post');

		$this->setUpFormElements();

		$this->validationRules();

		if($this->edit_mode == FALSE) {
			$legend = 'Add <small>Add a new jumbotron content item</small>'; 
		} else {
			$legend = 'Edit <small>Edit the jumbotron content item</small>';
		}

		$this->addElementsToForm('jumbotron_item', $legend, $this->elements);

		$this->addDefaultElementDecorators();

		$this->addCustomElementDecorators();
	}

	/**
	* Set up all the form elements required by the tool, this is broekn down 
	* into two sections, the hidden elements that manage the environment and 
	* tool and the user visible elements for the user
	* 
	* @return void The form elements are written to the private 
	* 	$this->elements array
	*/
	protected function setUpFormElements()
	{
		$this->toolElements();

		$this->userElements();
	}

	/**
	* Set up all the tool and environment elements, there are all the elements 
	* that define the tool being used and the environment/session values 
	* currently set in the designer
	*
	* @return void The form elements are written to the private 
	* 	$this->elements array
	*/
	private function toolElements()
	{
		$page_id = new Zend_Form_Element_Hidden('page_id');
		$page_id->setValue($this->page_id);

		$this->elements['page_id'] = $page_id;

		$div_id = new Zend_Form_Element_Hidden('div_id');
		$div_id->setValue($this->div_id);

		$this->elements['div_id'] = $div_id;
		
		$content_row_id = new Zend_Form_Element_Hidden('content_row_id');
		$content_row_id->setValue($this->content_row_id);

		$this->elements['content_row_id'] = $content_row_id;

		$tool = new Zend_Form_Element_Hidden('tool');
		$tool->setValue($this->tool);

		$this->elements['tool'] = $tool;

		$content_type = new Zend_Form_Element_Hidden('content_type');
		$content_type->setValue($this->content_type);

		$this->elements['content_type'] = $content_type;

		if(array_key_exists('id', $this->content_item) == TRUE 
		&& $this->content_item['id'] != FALSE) {
			$content_id = new Zend_Form_Element_Hidden('content_id');
			$content_id->setValue($this->content_item['id']);

			$this->elements['content_id'] = $content_id;
		}

		$multi_use = new Zend_Form_Element_Hidden('multi_use');
		$multi_use->setValue($this->multi_use);
		$multi_use->setBelongsTo('params');

		$this->elements['multi_use'] = $multi_use;
	}

	/**
	* Set up the user elements, these are the fields that the user interacts 
	* with
	* 
	* @return void The form elements are written to the private 
	* 	$this->elements array
	*/
	private function userElements()
	{
		$name = new Zend_Form_Element_Text('name');
		$name->setLabel('Name');
		$name->setAttribs(array('size'=>50, 'maxlength'=>255, 
			'placeholder'=>'e.g., Site masthead', 
			'class'=>'form-control input-sm'));
		$name->setDescription('Set a name, it should describe the text that you 
			define for this jumbotron. Later, you can re-use the text to create 
			another jumbotron content item on this content page or another.');
		$name->setBelongsTo('params');
		$name->setRequired();
		
		if(array_key_exists('name', $this->content_item) == TRUE 
			&& $this->content_item['name'] != FALSE) {
			
			$name->setValue($this->content_item['name']);
		}

		$this->elements['name'] = $name;

		$title = new Zend_Form_Element_Text('title');
		$title->setLabel('Title');
		$title->setAttribs(array('size'=>50, 'maxlength'=>255, 
			'placeholder'=>'e.g., Welcome to my site', 
			'class'=>'form-control input-sm'));
		$title->setDescription('Enter the text for your title.');
		$title->setBelongsTo('params');
		$title->setRequired();
		
		if(array_key_exists('title', $this->content_item) == TRUE 
			&& $this->content_item['title'] != FALSE) {
			
			$title->setValue($this->content_item['title']);
		}

		$this->elements['title'] = $title;
		
		$sub_title = new Zend_Form_Element_Textarea('sub_title');
		$sub_title->setLabel('Sub title');
		$sub_title->setAttribs(array('cols'=>50, 'rows'=>10, 
			'placeholder'=>'e.g., Short description of what you will find on my site', 
			'class'=>'form-control input-sm'));
		$sub_title->setDescription('Enter your sub text, this appears below the 
			title in a much smaller font.');
		$sub_title->setBelongsTo('params');
		$sub_title->setRequired();
		
		if(array_key_exists('sub_title', $this->content_item) == TRUE 
			&& $this->content_item['sub_title'] != FALSE) {
			
			$sub_title->setValue($this->content_item['sub_title']);
		}

		$this->elements['sub_title'] = $sub_title;
		
		$button_label = new Zend_Form_Element_Text('button_label');
		$button_label->setLabel('Button label');
		$button_label->setAttribs(array('size'=>50, 'maxlength'=>255,  
			'placeholder'=>'e.g., Download the specification', 
			'class'=>'form-control input-sm'));
		$button_label->setDescription('You can optionally add a button to the 
			jumbotron, enter the label here. (Currently no way to add a link)');
		$button_label->setBelongsTo('params');
		
		if(array_key_exists('button_label', $this->content_item) == TRUE 
			&& $this->content_item['button_label'] != FALSE) {
			
			$button_label->setValue($this->content_item['button_label']);
		}

		$this->elements['button_label'] = $button_label;

		$this->elements['instances'] = $this->instancesElement(
			'jumbotron text', 'jumbotron');

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttribs(array('class'=>'btn btn-primary'));
		if($this->edit_mode == FALSE) {
			$submit->setLabel('Insert');
		} else {
			$submit->setLabel('Save');
		}

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