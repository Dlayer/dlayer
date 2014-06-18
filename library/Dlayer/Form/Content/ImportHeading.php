<?php
/**
* Form for the import heading content tool
* 
* Allows the user to add a heading content item using an existing piece of 
* data, the user needs to choose the text to use and set all the other 
* options as per the heading tool.
* 
* The width and padding values will be defaulted with sensible values based 
* upon the page block the content item is being added to.
* 
* There is no edit version of the import heading tool, this tool is used only 
* from creating a new content item.
*
* @author Dean Blackborough
* @copyright G3D Development Limited
* @version $Id: ImportHeading.php 1949 2014-06-16 00:34:49Z Dean.Blackborough $
*/
class Dlayer_Form_Content_ImportHeading extends Dlayer_Form_Module_Content
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
    * @param array|NULL $options Zend form options data array
    * @return void
    */
    public function __construct($page_id, $div_id, array $container, 
    array $existing_data, $edit_mode=FALSE, $options=NULL)
    {
        $this->tool = 'heading';
        $this->content_type = 'heading';
        $this->sub_tool_model = NULL;

        parent::__construct($page_id, $div_id, $container, $existing_data, 
        $edit_mode, $options=NULL);
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

        $this->addElementsToForm('import_heading', 'Import heading', 
        $this->elements);

        $this->addDefaultElementDecorators();

        $this->addCustomElementDecorators();
    }

    /**
    * Fetch the data requuired by the form select menus
    *
    * @return void Writes the data to the $this->element_data property
    */
    private function formElementsData()
    {
        $model_settings = new Dlayer_Model_Settings();

        foreach($model_settings->headingStyles() as $k=>$values) {
            $this->elements_data['headings'][$k] = $values['name'];
        }
        
        $model_text_data = new Dlayer_Model_Page_Content_Items_Heading();
    	$session_dlayer = new Dlayer_Session();
    	
    	$this->elements_data['import'][0] = 'Select text to import';
    	
    	foreach($model_text_data->importDataOptions(
    	$session_dlayer->siteId()) as $options) {
            $this->elements_data['import'][$options['id']] = $options['name'];
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

        $multi_use = new Zend_Form_Element_Hidden('multi_use');
        $multi_use->setValue(1);
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
        $import->setMultiOptions($this->elements_data['import']);
        
    	$this->elements['select_imported_text'] = $import;
    	
    	$heading = new Zend_Form_Element_Textarea('heading');
        $heading->setLabel('Heading');
        $heading->setAttribs(array('cols'=>50, 'rows'=>4, 
        'placeholder'=>'e.g., Page heading!'));
        $heading->setDescription('Enter the text for the new heading.');
        $heading->setBelongsTo('params');
        $heading->setRequired();

        $this->elements['heading'] = $heading;
            	
        $heading_type = new Zend_Form_Element_Select('heading_type');
        $heading_type->setLabel('Heading type');
        $heading_type->setMultiOptions($this->elements_data['headings']);
        $heading_type->setDescription('Choose the type for the new heading.');
        $heading_type->setBelongsTo('params');

        $this->elements['heading_type'] = $heading_type;

        $padding_top = new Dlayer_Form_Element_Number('padding_top');
        $padding_top->setLabel('Top padding');
        $padding_top->setAttribs(array('maxlength'=>3, 'class'=>'tinyint', 
        'min'=>0));
        $padding_top->setDescription('Set the spacing above the title.');
        $padding_top->setBelongsTo('params');
        $padding_top->setValue(12);
        
        $this->elements['padding_top'] = $padding_top;

        $padding_bottom = new Dlayer_Form_Element_Number('padding_bottom');
        $padding_bottom->setLabel('Bottom padding');
        $padding_bottom->setAttribs(array('maxlength'=>3, 'class'=>'tinyint',
        'min'=>0));
        $padding_bottom->setDescription('Set the spacing below the title.');
        $padding_bottom->setBelongsTo('params');
        $padding_bottom->setValue(12);

        $this->elements['padding_bottom'] = $padding_bottom;

        $padding_left = new Dlayer_Form_Element_Number('padding_left');
        $padding_left->setLabel('Left padding');
        $padding_left->setAttribs(array('maxlength'=>3, 'class'=>'tinyint', 
        'min'=>0));
        $padding_left->setDescription('Set the spacing to the left of the
        title.');
        $padding_left->setBelongsTo('params');
        $padding_left->setValue($this->container['padding_left']);

        $this->elements['padding_left'] = $padding_left;

        $width = new Dlayer_Form_Element_Number('width');
        $width->setLabel('Width');
        $width->setAttribs(array('maxlength'=>4, 'class'=>'mediumint', 
        'min'=>0));
        $width->setDescription('Set the width for the heading content
        conatiner.');
        $width->setBelongsTo('params');
        $width->setValue($this->container['width']);

        $this->elements['width'] = $width;
                
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

    /**
    * Add any custom decorators, these are inputs where we need a little more
    * control over the html, an example being the submit button
    *
    * @return void
    */
    protected function addCustomElementDecorators()
    {
        $this->elements['submit']->setDecorators(array(array('ViewHelper'),
        array('HtmlTag', array('tag' => 'div', 'class'=>'save'))));

        $this->elements['padding_top']->setDecorators(
        array(array('ViewHelper', array('tag' => 'div', 'class'=>'input')),
        array('Description'), array('Errors'), array('Label'),
        array('HtmlTag', array('tag' => 'div', 'class'=>'input_50'))));

        $this->elements['padding_bottom']->setDecorators(
        array(array('ViewHelper', array('tag' => 'div', 'class'=>'input')),
        array('Description'), array('Errors'), array('Label'),
        array('HtmlTag', array('tag' => 'div', 'class'=>'input_50'))));

        $this->elements['padding_left']->setDecorators(
        array(array('ViewHelper', array('tag' => 'div', 'class'=>'input')),
        array('Description'), array('Errors'), array('Label'),
        array('HtmlTag', array('tag' => 'div', 'class'=>'input_50'))));

        $this->elements['width']->setDecorators(
        array(array('ViewHelper', array('tag' => 'div', 'class'=>'input')),
        array('Description'), array('Errors'), array('Label'),
        array('HtmlTag', array('tag' => 'div', 'class'=>'input_50'))));
    }
}