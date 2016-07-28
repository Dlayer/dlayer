<?php
/**
* Form for the import text content tool
* 
* Allows a user to add a new text content item using an existing piece of 
* text from the system, the user simply selects the text and the form is 
* updated with the data
* 
* There is no edit version of the import text tool, once added the text item 
* behaves as a standard text content item
*
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_Content_ImportText extends Dlayer_Form_Module_Content
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
		$this->tool = 'import-text';
		$this->content_type = 'text';
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
		
		$this->formElementsData();

		$this->generateFormElements();

		$this->validationRules();

		$legend = 'Import <small>Add a new text content item using 
			existing data</small>';
		$this->addElementsToForm('import_text_item', $legend, $this->elements);

		$this->addDefaultElementDecorators();

		$this->addCustomElementDecorators();
	}
	
	/**
	* Fetch any data required by the form inputs,
	* 
	* Fetch the text data from the text content table
	*
	* @return void Writes the data to the $this->element_data property
	*/
	private function formElementsData()
	{
		$model_text_data = new Dlayer_Model_Page_Content_Items_Text();
		$session_dlayer = new Dlayer_Session();
		
		$this->elements_data[0] = 'Select text to import';
		
		foreach($model_text_data->existingTextContentNames(
			$session_dlayer->siteId()) as $options) {
			
			$this->elements_data[$options['id']] = $options['name'];
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

		$content_type = new Zend_Form_Element_Hidden('content_type');
		$content_type->setValue($this->content_type);

		$this->elements['content_type'] = $content_type;

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
		$name = new Zend_Form_Element_Hidden('name');
		$name->setBelongsTo('params');

		$this->elements['name'] = $name;
		
		$import = new Zend_Form_Element_Select('select_imported_text');
		$import->setLabel('Select the text to import');
		$import->setDescription('Select the text from an earlier text content 
			item, a preview of the imported text will display below.');
		$import->setMultiOptions($this->elements_data);
		$import->setAttribs(array('class'=>'form-control input-sm'));
		$import->setRequired();
		
		$this->elements['select_imported_text'] = $import;
		
		$text = new Zend_Form_Element_Textarea('text');
		$text->setLabel('Text');
		$text->setAttribs(array('cols'=>50, 'rows'=>10, 
			'class'=>'form-control input-sm'));
		$text->setDescription('Once you make a selection above a preview of 
			the imported text will display here.');
		$text->setBelongsTo('params');
		$text->setRequired();

		$this->elements['text'] = $text;
				
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttribs(array('class'=>'btn btn-primary'));
		$submit->setLabel('Import');

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
