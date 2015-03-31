<?php
/**
* Form for the size and position tab of the heading content item tool
* 
* This form allows a user to define the size and position of the currently 
* selected content item
*
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_Content_Position_Heading extends Dlayer_Form_Module_Content
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
		$this->tool = 'heading';
		$this->content_type = 'heading';
		$this->sub_tool_model = 'Position_Heading';

		parent::__construct($page_id, $div_id, $content_row_id, 
			$content_item, $edit_mode, $multi_use, $options);
	}

	/**
	* Initialuse the form, sers the url and submit method and then calls the
	* methods that set up the form
	*
	* @return void
	*/
	public function init()
	{
		$this->setAction('/content/process/tool');

		$this->setMethod('post');

		$this->setUpFormElements();

		$this->validationRules();

		$legend = 'Size & position <small>Set the size and position for the 
			heading item</small>';

		$this->addElementsToForm('heading_position', $legend, $this->elements);

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
		
		$sub_tool_model = new Zend_Form_Element_Hidden('sub_tool_model');
		$sub_tool_model->setValue($this->sub_tool_model);

		$this->elements['sub_tool_model'] = $sub_tool_model;

		$content_type = new Zend_Form_Element_Hidden('content_type');
		$content_type->setValue($this->content_type);

		$this->elements['content_type'] = $content_type;

		$content_id = new Zend_Form_Element_Hidden('content_id');
		$content_id->setValue($this->content_item['id']);

		$this->elements['content_id'] = $content_id;

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
		$this->elements['size'] = $this->sizeElement('heading');
		
		$this->elements['offset'] = $this->offsetElement();
		
		$submit = new Zend_Form_Element_Submit('submit');
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