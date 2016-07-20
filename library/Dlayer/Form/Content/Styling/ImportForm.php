<?php
/**
* Form for the styling tab of the import form tool
* 
* This form allows a user to define styling options for the selected content 
* item
*
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_Content_Styling_ImportForm extends 
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
		$this->tool = 'import-form';
		$this->content_type = 'form';
		$this->sub_tool_model = 'Styling_ImportForm';

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

		$this->generateFormElements();

		$this->validationRules();

		$legend = 'Styling <small>Set the styles for the imported 
			form</small>';

		$this->addElementsToForm('form_styling', $legend, $this->elements);

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
		// Content container background colour
		$container_background_color = new Dlayer_Form_Element_ColorPicker(
			'container_background_color');
		$container_background_color->setLabel('Form container background 
			colour');
		$container_background_color->setDescription('Choose a background 
			colour for the form container, to clear the background colour 
			use the clear link.');
		$container_background_color->setBelongsTo('params');
		$container_background_color->addClearLink();
		$container_background_color->setRequired();
		
		if(array_key_exists('container_background_color', 
			$this->content_item) == TRUE 
			&& $this->content_item['container_background_color'] != FALSE) {
			
			$container_background_color->setValue(
				$this->content_item['container_background_color']);
		}

		$this->elements['container_background_color'] = 
			$container_background_color;
			
		// Content item background colour	
		$item_background_color = new Dlayer_Form_Element_ColorPicker(
			'item_background_color');
		$item_background_color->setLabel('Form background colour');
		$item_background_color->setDescription('Choose a background 
			colour for the form, to clear the background colour use the 
			clear link.');
		$item_background_color->setBelongsTo('params');
		$item_background_color->addClearLink();
		$item_background_color->setRequired();
		
		if(array_key_exists('item_background_color', 
			$this->content_item) == TRUE 
			&& $this->content_item['item_background_color'] != FALSE) {
			
			$item_background_color->setValue(
				$this->content_item['item_background_color']);
		}

		$this->elements['item_background_color'] = $item_background_color;
		
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
