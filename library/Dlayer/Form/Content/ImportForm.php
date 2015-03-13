<?php
/**
* Form for the import form tool
* 
* THis form is used by the import form tool to allow a user to choose a form 
* from the Form builder into the Content manager as an item, this form is also 
* used by the edit version of the tool
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_Content_ImportForm extends Dlayer_Form_Module_Content
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
		$this->tool = 'import-form';
		$this->content_type = 'form';
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
		$this->setAction('/content/process/tool');

		$this->setMethod('post');

		$this->formElementsData();

		$this->setUpFormElements();

		$this->validationRules();

		if($this->edit_mode == FALSE) {
			$legend = 'Form <small>Import a Form builder form</small>'; 
		} else {
			$legend = 'Form <small>Update details for imported form</small>';
		}

		$this->addElementsToForm('form_item', $legend, $this->elements);

		$this->addDefaultElementDecorators();

		$this->addCustomElementDecorators();
	}
	
	/**
	* Fetch the data required by the form elements
	*
	* @return void Writes the data to the $this->element_data property
	*/
	private function formElementsData()
	{
		$model_forms = new Dlayer_Model_Form();
		$session_dlayer = new Dlayer_Session();

		$this->elements_data[] = 'Choose form';

		foreach($model_forms->forms($session_dlayer->siteId()) as $form) {
			$this->elements_data[$form['id']] = $form['name'];
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
		$form = new Zend_Form_Element_Select('form_id');
		$form->setLabel('Form');
		$form->setDescription('Select the form that you would like to 
			import from the Form builder into this content row.');
		$form->setMultiOptions($this->elements_data);
		$form->setAttribs(array('class'=>'form-control input-sm'));
		$form->setBelongsTo('params');
		
		if(array_key_exists('form_id', $this->content_item) == TRUE && 
			$this->content_item['form_id'] != FALSE) {

			$form->setValue($this->content_item['form_id']);
		}

		$this->elements['form_id'] = $form;

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttribs(array('class'=>'btn btn-primary'));
		if($this->edit_mode == FALSE) {
			$submit->setLabel('Import');
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