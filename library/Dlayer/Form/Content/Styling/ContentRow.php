<?php
/**
* Form for the content row styling sub tool
* 
* The tool is used by the styling tab of the content row tool to allow a user 
* to define the background colour for the row
*
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_Content_Styling_ContentRow extends 
Dlayer_Form_Module_Content
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
		$this->tool = 'content-row';
		$this->content_type = 'row';
		$this->sub_tool_model = 'Styling_ContentRow';

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
		$this->setAction('/content/process/auto-tool');

		$this->setMethod('post');
		
		$this->generateFormElements();

		$this->validationRules();

		$legend = 'Styling <small>Set the styles for the content row</small>'; 
		$this->addElementsToForm('styling_content_row', $legend, 
			$this->elements);

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
	protected function generateFormElements()
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
		$row_background_color = new Dlayer_Form_Element_ColorPicker(
			'row_background_color');
		$row_background_color->setLabel('Content row background colour');
		$row_background_color->setDescription('Choose a background 
			colour for the content row, to clear the background colour use the 
			clear link.');
		$row_background_color->setBelongsTo('params');
		$row_background_color->addClearLink();
		$row_background_color->setRequired();
		
		if(array_key_exists('row_background_color', 
			$this->content_item) == TRUE 
			&& $this->content_item['row_background_color'] != FALSE) {
			
			$row_background_color->setValue(
				$this->content_item['row_background_color']);
		}

		$this->elements['row_background_color'] = $row_background_color;
		
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
