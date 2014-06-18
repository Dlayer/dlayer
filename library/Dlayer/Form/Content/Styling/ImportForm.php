<?php
/**
* Styling form for the import form tool
* 
* Allows the user to define the background color for an imported form
* 
* @todo This needs to also support border, will add that once I can confirm 
* that this approach is working
*
* @author Dean Blackborough
* @copyright G3D Development Limited
* @version $Id: ImportForm.php 1928 2014-06-12 13:53:38Z Dean.Blackborough $
*/
class Dlayer_Form_Content_Styling_ImportForm extends Dlayer_Form_Module_Content
{
    /**
    * Set the initial properties for the form
    *
    * @param integer $page_id
    * @param integer $div_id
    * @param array $container Content container sizes, conatins all the size 
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
        $this->tool = 'import-form';
        $this->content_type = 'form';
        $this->sub_tool_model = 'Styling_ImportForm';

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

        $this->setUpFormElements();

        $this->validationRules();

        $this->addElementsToForm('import_form_styling', 'Container styling', 
        $this->elements);

        $this->addDefaultElementDecorators();

        $this->addCustomElementDecorators();
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
        
        $sub_tool_model = new Zend_Form_Element_Hidden('sub_tool_model');
        $sub_tool_model->setValue($this->sub_tool_model);

        $this->elements['sub_tool_model'] = $sub_tool_model;
        
        $content_type = new Zend_Form_Element_Hidden('content_type');
        $content_type->setValue($this->content_type);

        $this->elements['content_type'] = $content_type;

        $content_id = new Zend_Form_Element_Hidden('content_id');
        $content_id->setValue($this->existing_data['content_id']);

        $this->elements['content_id'] = $content_id;

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
		$background_color = new Dlayer_Form_Element_ColorPicker(
        'background_color');
        $background_color->setLabel('Background colour');
        $background_color->setDescription('Choose a background colour for the 
        form container, to clear the background colour use the clear link.');
        $background_color->setBelongsTo('params');
        $background_color->addClearLink();
        $background_color->setRequired();
        if(array_key_exists('background_color', $this->existing_data) == TRUE 
        && $this->existing_data['background_color'] != FALSE) {
            $background_color->setValue(
            $this->existing_data['background_color']);
        }

        $this->elements['background_color'] = $background_color;
        
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