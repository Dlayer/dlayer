<?php
/**
* Styling sub tool form for the Form builder email tool, allows the user 
* to define the style values for the field row and field itself
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
* @version $Id: Email.php 1826 2014-05-12 20:50:19Z Dean.Blackborough $
*/
class Dlayer_Form_Form_Styling_Email extends Dlayer_Form_Module_Form
{
	/**
    * Set the initial properties for the form
    *
    * @param integer $form_id
    * @param array $field_data Field data array, either an array with all the 
    * 						   attrubutes and their current value or an array 
    * 						   with FALSE as the value for each attribute
    * @param array|NULL $options Zend form options data array
    * @return void
    */
    public function __construct($form_id, array $field_data, $options=NULL)
    {
        $this->tool = 'email';
        $this->field_type = 'text';
        $this->sub_tool_model = 'Styling_Email';

        parent::__construct($form_id, $field_data, $options);
    }
    
    /**
    * Initialuse the form, sets the url and submit method and then calls the
    * methods that set up the form
    *
    * @return void
    */
    public function init()
    {
        $this->setAction('/form/process/tool');

        $this->setMethod('post');

        $this->setUpFormElements();

        $this->validationRules();

        $this->addElementsToForm('email_styling', 'Field styling', 
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
        $form_id = new Zend_Form_Element_Hidden('form_id');
        $form_id->setValue($this->form_id);

        $this->elements['form_id'] = $form_id;

        $tool = new Zend_Form_Element_Hidden('tool');
        $tool->setValue($this->tool);

        $this->elements['tool'] = $tool;
        
        $sub_tool_model = new Zend_Form_Element_Hidden('sub_tool_model');
        $sub_tool_model->setValue($this->sub_tool_model);

        $this->elements['sub_tool_model'] = $sub_tool_model;

        $field_id = new Zend_Form_Element_Hidden('field_id');
        $field_id->setValue($this->field_data['field_id']);
        
        $this->elements['field_id'] = $field_id;
        
        $field_type = new Zend_Form_Element_Hidden('field_type');
        $field_type->setValue($this->field_type);

        $this->elements['field_type'] = $field_type;

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
        $background_color->setLabel('Row background colour');
        $background_color->setDescription('Choose a background colour for 
        form field row, to clear the background colour use the clear link.');
        $background_color->setBelongsTo('params');
        $background_color->addClearLink();
        $background_color->setRequired();
        if(array_key_exists('background_color', $this->field_data) == TRUE 
        && $this->field_data['background_color'] != FALSE) {
            $background_color->setValue(
            $this->field_data['background_color']);
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