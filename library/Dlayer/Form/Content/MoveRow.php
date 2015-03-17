<?php
/**
* Form for the move control row tool
* 
* The tool is used by the move row tool to allow the user to select the content 
* area that they would like to move the content row to, it has a select menu 
* with the names of all the other content areas
*
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_Content_Text extends Dlayer_Form_Module_Content
{
	/**
	* Set the initial properties for the form
	* 
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @param array $content_row Details for the content row, used to preset 
	* 	certains values for the content item, for example which bootstrap 
	* 	column class to use
	* @param array $content_item The existing data for the content item, 
	* 	array values will be FALSE in add mode, populated in edit mode
	* @param boolean $edit_mode Is the tool in edit mode
	* @param integer $multi_use The multi use value for the tool, either 1 or 0
	* @param array|NULL $options Zend form options data array
	* @return void
	*/
	public function __construct($page_id, $div_id, $content_row_id, 
		array $content_row, array $content_item, $edit_mode=FALSE, 
		$multi_use=0, $options=NULL)
	{
		$this->tool = 'move-row';
		$this->content_type = 'row';
		$this->sub_tool_model = NULL;

		parent::__construct($page_id, $div_id, $content_row_id, $content_row, 
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
		$this->setAction('/content/process/auto-tool');

		$this->setMethod('post');

		$this->setUpFormElements();

		$this->validationRules();

		$legend = 'Move <small>Move the content row to another 
			content area</small>'; 
		$this->addElementsToForm('move_row', $legend, $this->elements);

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
			'placeholder'=>'e.g., Intro text for site', 
			'class'=>'form-control input-sm'));
		$name->setDescription('Set a name for the content item, this will allow 
			 you to easily identity the content item text if you want to re-use 
			 it on another page or this page.');
		$name->setBelongsTo('params');
		$name->setRequired();
		
		if(array_key_exists('name', $this->content_item) == TRUE 
			&& $this->content_item['name'] != FALSE) {
			
			$name->setValue($this->content_item['name']);
		}

		$this->elements['name'] = $name;

		$text = new Zend_Form_Element_Textarea('text');
		$text->setLabel('Text');
		$text->setAttribs(array('cols'=>50, 'rows'=>10, 
			'placeholder'=>'e.g., The quick brown fox jumps over...', 
			'class'=>'form-control input-sm'));
		$text->setDescription('Enter the text for your new content item.');
		$text->setBelongsTo('params');
		$text->setRequired();
		
		if(array_key_exists('text', $this->content_item) == TRUE 
			&& $this->content_item['text'] != FALSE) {
			
			$text->setValue($this->content_item['text']);
		}

		$this->elements['text'] = $text;

		$this->elements['instances'] = $this->instancesElement(
			'text', 'text item');

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttribs(array('class'=>'btn btn-primary'));
		if($this->edit_mode == FALSE) {
			$submit->setLabel('Add');
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