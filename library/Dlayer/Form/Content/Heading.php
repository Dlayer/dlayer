<?php
/**
* Form for the heading content item tool
* 
* The form allows a user to add a heading content item to the content row, it 
* is also used by the edit versions of the tool 
*
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_Content_Heading extends Dlayer_Form_Module_Content
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
		$this->tool = 'heading';
		$this->content_type = 'heading';
		$this->sub_tool_model = NULL;

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

		$this->formElementsData();

		$this->setUpFormElements();

		$this->validationRules();
		
		if($this->edit_mode == FALSE) {
			$legend = 'Add <small>Add a new heading content item</small>'; 
		} else {
			$legend = 'Edit <small>Edit the heading content item</small>';
		}
		
		$this->addElementsToForm('heading_item', $legend, $this->elements);

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
		$model_settings = new Dlayer_Model_Settings();

		foreach($model_settings->headingStyles() as $k=>$values) {
			$this->elements_data[$k] = $values['name'];
		}
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
		$page_id = new Zend_Form_Element_Hidden('page_id');
		$page_id->setValue($this->page_id);

		$this->elements['page_id'] = $page_id;

		$div_id = new Zend_Form_Element_Hidden('div_id');
		$div_id->setValue($this->div_id);

		$this->elements['div_id'] = $div_id;

		$tool = new Zend_Form_Element_Hidden('tool');
		$tool->setValue($this->tool);

		$this->elements['tool'] = $tool;

		$content_type = new Zend_Form_Element_Hidden('content_type');
		$content_type->setValue('heading');

		$this->elements['content_type'] = $content_type;

		if(array_key_exists('id', $this->content_item) == TRUE 
		&& $this->content_item['id'] != FALSE) {
			$content_id = new Zend_Form_Element_Hidden('content_id');
			$content_id->setValue($this->existing_data['id']);

			$this->elements['content_id'] = $content_id;
		}

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
		$name = new Zend_Form_Element_Text('name');
		$name->setLabel('Name');
		$name->setAttribs(array('size'=>50, 'maxlength'=>255, 
			'placeholder'=>'e.g., Page title', 
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

		$heading = new Zend_Form_Element_Textarea('heading');
		$heading->setLabel('Heading');
		$heading->setAttribs(array('cols'=>50, 'rows'=>4, 
			'placeholder'=>'e.g., Page heading!', 
			'class'=>'form-control input-sm'));
		$heading->setDescription('Enter the text for the new heading content 
			item.');
		$heading->setBelongsTo('params');
		$heading->setRequired();
		
		if(array_key_exists('heading', $this->content_item) == TRUE 
		&& $this->content_item['heading'] != FALSE) {
			$heading->setValue($this->content_item['heading']);
		}

		$this->elements['heading'] = $heading;

		/**
		* @todo This needs to be moved into the base method, no need to 
		* duplicate the code in each of the forms
		*/
		if($this->edit_mode == TRUE && 
		array_key_exists('id', $this->content_item) == TRUE && 
		array_key_exists('instances', $this->content_item) == TRUE && 
		$this->content_item['id'] != FALSE && 
		$this->content_item['instances'] > 1) {
			$instances = new Zend_Form_Element_Select('instances');
			$instances->setLabel('Update all instances');
			$instances->setDescription('There are ' . 
				$this->content_item['instances'] . '  instances of the 
				heading text in your site, to update all insances please 
				select yes, otherwise select no and only the text for this 
				content item will be updated.');
			$instances->setMultiOptions(array(1=>'Yes - Update all instances', 
				0=>'No - Only update this heading'));
			$instances->setAttribs(array('class'=>'form-control input-sm'));
			$instances->setBelongsTo('params');
		} else {
			$instances = new Zend_Form_Element_Hidden('instances');
			$instances->setValue(0);
			$instances->setBelongsTo('params');
		}

		$this->elements['instances'] = $instances;

		$heading_type = new Zend_Form_Element_Select('heading_type');
		$heading_type->setLabel('Heading type');
		$heading_type->setMultiOptions($this->elements_data);
		$heading_type->setDescription('Choose the type for the new heading.');
		$heading_type->setAttribs(array('class'=>'form-control input-sm'));
		$heading_type->setBelongsTo('params');
		
		if(array_key_exists('heading_id', $this->content_item) == TRUE 
		&& $this->content_item['heading_id'] != FALSE) {
			$heading_type->setValue($this->content_item['heading_id']);
		}

		$this->elements['heading_type'] = $heading_type;

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