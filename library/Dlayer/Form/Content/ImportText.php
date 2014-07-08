<?php
/**
* Form for the import text content tool
* 
* Allows the user to add a text content item using an existing piece of data, 
* the user needs to choose the text to use and set all the other options as 
* per the text tool.
* 
* The width and padding will be defaulted with sensible values based upon the 
* page block the content item is being added to.
* 
* There is no edit version of the import text tool, this tool is used only 
* from creating a new content item.
*
* @author Dean Blackborough
* @copyright G3D Development Limited
* @version $Id: ImportText.php 1942 2014-06-15 12:52:34Z Dean.Blackborough $
*/
class Dlayer_Form_Content_ImportText extends Dlayer_Form_Module_Content
{
    /**
    * Set the initial properties for the form
    *
    * @param integer $page_id
    * @param integer $div_id
    * @param array $container Content container sizes, contains all the size 
    * 						  fields relevant to the content item
    * @param array $existing_data Exisitng form data array, array values will 
    * 							  be FALSE if there is no data for the field
    * @param boolean $edit_mode Is the tool in edit mode
    * @param integer $multi_use Tool tab multi use param
    * @param array|NULL $options Zend form options data array
    * @return void
    */
    public function __construct($page_id, $div_id, array $container,
    array $existing_data, $edit_mode=FALSE, $multi_use, $options=NULL)
    {
        $this->tool = 'import-text';
        $this->content_type = 'text';
        $this->sub_tool_model = NULL;

        parent::__construct($page_id, $div_id, $container, $existing_data, 
        $edit_mode, $multi_use, $options=NULL);
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

        $this->addElementsToForm('import_text', 'Import text', $this->elements);

        $this->addDefaultElementDecorators();

        $this->addCustomElementDecorators();
    }
    
    /**
    * Fetch the data required by the import selected menu
    * 
    * @return void Writes the data to the $this->element_data property
    */
    private function formElementsData()
    {
    	$model_text_data = new Dlayer_Model_Page_Content_Items_Text();
    	$session_dlayer = new Dlayer_Session();
    	
    	$this->elements_data[0] = 'Select text to import';
    	
    	foreach($model_text_data->importDataOptions(
    	$session_dlayer->siteId()) as $options) {
            $this->elements_data[$options['id']] = $options['name'];
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
        $content_type->setValue('text');

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
        $import->setLabel('Select text to import');
        $import->setDescription('Select some existing text data to import, 
        a preview of the imported text will display below.');
        $import->setMultiOptions($this->elements_data);
        
    	$this->elements['select_imported_text'] = $import;
    	
    	$text = new Zend_Form_Element_Textarea('content');
        $text->setLabel('Text');
        $text->setAttribs(array('cols'=>50, 'rows'=>10, 
        'placeholder'=>'A preview of the imported text will display here.'));
        $text->setDescription('Select an existing text item using the select
        menu above.');
        $text->setBelongsTo('params');
        $text->setRequired();

        $this->elements['text'] = $text;
        
        $width = new Dlayer_Form_Element_Number('width');
        $width->setLabel('Width');
        $width->setAttribs(array('maxlength'=>4, 'class'=>'mediumint', 
        'min'=>0));
        $width->setDescription('Set the width for the text block container, it
        can be no larger than the page block it sits in, the submitted value
        will be checked by the tool.');
        $width->setBelongsTo('params');
        $width->setValue($this->container['width']);

        $this->elements['width'] = $width;

        $padding = new Dlayer_Form_Element_Number('padding');
        $padding->setLabel('Padding');
        $padding->setAttribs(array('maxlength'=>3, 'class'=>'tinyint', 
        'min'=>0, 'max'=>99));
        $padding->setDescription('Set the padding for the text, this much space
        will be left around the outside of the text.');
        $padding->setBelongsTo('params');
        $padding->setValue($this->container['padding']);

        $this->elements['padding'] = $padding;
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('class', 'submit');
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