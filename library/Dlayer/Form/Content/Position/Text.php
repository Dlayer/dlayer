<?php
/**
* Form for the size and position tab of the text content item tool
* 
* This form allows a user to define the size and position of the currently 
* selected content item
*
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_Content_Position_Text extends Dlayer_Form_Module_Content
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
		$this->tool = 'text';
		$this->content_type = 'text';
		$this->sub_tool_model = 'Position_Text';

		parent::__construct($page_id, $div_id, $content_row_id, $content_row, 
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
			text item</small>';

		$this->addElementsToForm('text_position', $legend, $this->elements);

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
		/**
		* 
		* 
		* These two are standard elements so then need to be moved to the 
		* parent class, much like instances.
		* 
		* 
		*/
		
		
		$size = new Dlayer_Form_Element_Number('size');
		$size->setLabel('Size:');
		$size->setAttribs(array('max'=>12, 'min'=>1, 
			'class'=>'form-control input-sm'));
		$size->setDescription('Set the size for the text content item, there 
			are 12 columns to a row, the text item size can be set to any value 
			between 1 and 12');
		$size->setBelongsTo('params');
		$size->setRequired();
		
		if(array_key_exists('size', $this->content_item) == TRUE 
			&& $this->content_item['size'] != FALSE) {
			
			$size->setValue($this->content_item['size']);
		} else {
			$size->setValue(12);
		}

		$this->elements['size'] = $size;
		
		$offset = new Dlayer_Form_Element_Number('offset');
		$offset->setLabel('Offsetting:');
		$offset->setAttribs(array('max'=>12, 'min'=>0, 
			'class'=>'form-control input-sm'));
		$offset->setDescription('You can offset a item by setting the column 
			spacing to the right of the content item, the offsetting can be 
			set to any value between 0 and 12.');
		$offset->setBelongsTo('params');
		$offset->setRequired();
		
		if(array_key_exists('offset', $this->content_item) == TRUE 
			&& $this->content_item['offset'] != FALSE) {
			
			$offset->setValue($this->content_item['offset']);
		} else {
			$offset->setValue(0);
		}

		$this->elements['offset'] = $offset;
		
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