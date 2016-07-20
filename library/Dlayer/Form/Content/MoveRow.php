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
class Dlayer_Form_Content_MoveRow extends Dlayer_Form_Module_Content
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
		$this->tool = 'move-row';
		$this->content_type = 'row';
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
		$this->setAction('/content/process/auto-tool');

		$this->setMethod('post');
		
		$this->formElementsData();

		$this->generateFormElements();

		$this->validationRules();

		$legend = 'Move <small>Move the content row to another 
			content area</small>'; 
		$this->addElementsToForm('move_row', $legend, $this->elements);

		$this->addDefaultElementDecorators();

		$this->addCustomElementDecorators();
	}
	
	/**
	* Fetch any data required by the form inputs,
	* 
	* Fetch the defined heading styles.
	*
	* @return void Writes the data to the $this->element_data property
	*/
	private function formElementsData()
	{
		$model_page = new Dlayer_Model_Page();		
		$session_dlayer = new Dlayer_Session();
		
		$areas = $model_page->useablePageContentAreas($session_dlayer->site_id, 
			$this->page_id, $this->div_id);
			
		$this->elements_data['content_area_id'][0] = 'Select content area';
		
		foreach($areas as $k=>$v) {
			$this->elements_data['content_area_id'][$k] = 'Content area ' . $v;	
		}
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
		$content_area = new Zend_Form_Element_Select('content_area_id');
		$content_area->setLabel('Content area');
		$content_area->setMultiOptions($this->elements_data['content_area_id']);
		$content_area->setDescription('Choose the content area that you would 
			like to move the row to, each area will highlight when it is 
			selected in the menu.');
		$content_area->setAttribs(array('class'=>'form-control input-sm'));
		$content_area->setBelongsTo('params');
		$content_area->setRequired();
		
		$this->elements['content_area_id'] = $content_area;
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttribs(array('class'=>'btn btn-primary'));
		$submit->setLabel('Move');

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
