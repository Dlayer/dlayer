<?php
/**
* Form for the textarea field tool
* 
* Allows the user to add a textarea field to their form, the user needs to 
* define the label, description, placeholder text and the width and number of 
* rows, the width and rows values will be defaulted
*  
* This form is used for the add and edit version of the tool
*
* @author Dean Blackborough
* @copyright G3D Development Limited
* @version $Id: Textarea.php 1738 2014-04-17 15:44:36Z Dean.Blackborough $
*/
class Dlayer_Form_Form_Textarea extends Dlayer_Form_Module_Form
{
    /**
    * Set the initial properties for the form
    *
    * @param integer $form_id
    * @param array $field_data Field data array, either an array with all the 
    * 						   attrubutes and their current value or an array 
    * 						   with FALSE as the value for each attribute
    * @param boolean $edit_mode Is the tool currently in edit mode
    * @param array|NULL $options Zend form options data array
    * @return void
    */
    public function __construct($form_id, array $field_data, $edit_mode=FALSE, 
    $options=NULL)
    {
        $this->tool = 'textarea';
        $this->field_type = 'textarea';

        parent::__construct($form_id, $field_data, $edit_mode, $options);
    }
    
    /**
    * Initialuse the form, sers the url and submit method and then calls the
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

        $this->addElementsToForm('textarea_field', 'Add a textarea field', 
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

        if(array_key_exists('id', $this->field_data) == TRUE 
        && $this->field_data['id'] != FALSE) {
            $field_id = new Zend_Form_Element_Hidden('field_id');
            $field_id->setValue($this->field_data['id']);
            $this->elements['field_id'] = $field_id;
        }

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
    	$label = new Zend_Form_Element_Text('label');
        $label->setLabel('Label');
        $label->setAttribs(array('maxlength'=>255, 
        'placeholder'=>'e.g., Comment'));
        $label->setDescription('Enter the label for the textarea, this will
        appear to the left of the textarea.');
        $label->setBelongsTo('params');
        
        $value = $this->fieldValue('label');
        if($value != FALSE) {
			$label->setValue($value);
        }

        $this->elements['label'] = $label;

        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('Description');
        $description->setAttribs(array('rows'=>2, 'cols'=>30, 
        'placeholder'=>'e.g., Please enter your comment'));
        $description->setDescription('Enter a description, this should indicate
        to the user what they should enter in the textarea.');
        $description->setBelongsTo('params');
        
        $value = $this->fieldValue('description');
        if($value != FALSE) {
			$description->setValue($value);
        }

        $this->elements['description'] = $description;
        
        $placeholder = new Zend_Form_Element_Text('placeholder');
        $placeholder->setLabel('Placeholder text');
        $placeholder->setAttribs(array('maxlength'=>255, 
        'placeholder'=>'e.g., I love your app, thank you :)'));
        $placeholder->setDescription('Set the help text to display in the 
        field before any user input.');
        $placeholder->setBelongsTo('params');
        
        $value = $this->fieldAttributeValue('placeholder');
        if($value != FALSE) {
			$placeholder->setValue($value);
        }
        
        $this->elements['placeholder'] = $placeholder;
        
        $cols = new Dlayer_Form_Element_Number('cols');
        $cols->setLabel('Width');
        $cols->setValue(40);
        $cols->setAttribs(array('maxlength'=>3, 'class'=>'tinyint', 
        'min'=>0));
        $cols->setDescription('Set the width of the textarea in characters,
        we default to 40 characters.');
        $cols->setBelongsTo('params');
        
        $value = $this->fieldAttributeValue('cols');
        if($value != FALSE) {
			$cols->setValue($value);
        }

        $this->elements['cols'] = $cols;

        $rows = new Dlayer_Form_Element_Number('rows');
        $rows->setLabel('Rows');
        $rows->setValue(3);
        $rows->setAttribs(array('maxlength'=>3, 'class'=>'tinyint', 
        'min'=>0));
        $rows->setDescription('Set the number of rows for the textarea,
        we default to three rows.');
        $rows->setBelongsTo('params');
        
        $value = $this->fieldAttributeValue('rows');
        if($value != FALSE) {
			$rows->setValue($value);
        }

        $this->elements['rows'] = $rows;
        
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