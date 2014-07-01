<?php
/**
* Form for the add category tool
* 
* Allows the user to add a new category to the image library
* 
* This form is only used for both the add and edit category forms
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Form_Image_Category extends Dlayer_Form_Module_Image
{
	/**
    * Set the initial properties for the form
    * 
    * @param array $existing_data Exisitng data array for form, array values 
    *                             always preset, will have FALSE values if there 
    *                             is no existing data value
    * @param boolean $edit_mode Is the tool in edit mode
    * @param array|NULL $options Zend form options data array
    * @return void
    */
    public function __construct(array $existing_data, $edit_mode)
    {
        $this->tool = 'text';
        $this->field_type = 'text';

        parent::__construct($form_id, $field_data, $options);
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

        $this->addElementsToForm('text_field', 'Add a text field', 
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
        $label->setLabel('Label *');
        $label->setAttribs(array('maxlength'=>255, 
        'placeholder'=>'e.g., Your name'));
        $label->setDescription('Enter the label for the text field, this will
        appear to the left of the text field.');
        $label->setBelongsTo('params');
        
        $value = $this->fieldValue('label');
        if($value != FALSE) {
			$label->setValue($value);
        }

        $this->elements['label'] = $label;

        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('Description *');
        $description->setAttribs(array('rows'=>2, 'cols'=>30, 
        'placeholder'=>'e.g., Please enter your name'));
        $description->setDescription('Enter a description, this should indicate
        to the user what they should enter in the text field.');
        $description->setBelongsTo('params');
        
        $value = $this->fieldValue('description');
        if($value != FALSE) {
			$description->setValue($value);
        }

        $this->elements['description'] = $description;
    	
        $placeholder = new Zend_Form_Element_Text('placeholder');
        $placeholder->setLabel('Placeholder text');
        $placeholder->setAttribs(array('maxlength'=>255, 
        'placeholder'=>'e.g., Joe Bloggs'));
        $placeholder->setDescription('Set the help text to display in the 
        field before any user input.');
        $placeholder->setBelongsTo('params');
        
        $value = $this->fieldAttributeValue('placeholder');
        if($value != FALSE) {
			$placeholder->setValue($value);
        }
        
        $this->elements['placeholder'] = $placeholder;
        
        $size = new Dlayer_Form_Element_Number('size');
        $size->setLabel('Size');
        $size->setValue(40);
        $size->setAttribs(array('maxlength'=>3, 'class'=>'tinyint', 
        'min'=>0));
        $size->setDescription('Set the size of the text field in characters,
        we default to 40 characters.');
        $size->setBelongsTo('params');
        
        $value = $this->fieldAttributeValue('size');
        if($value != FALSE) {
			$size->setValue($value);
        }

        $this->elements['size'] = $size;

        $maxlength = new Dlayer_Form_Element_Number('maxlength');
        $maxlength->setLabel('Max length');
        $maxlength->setValue(255);
        $maxlength->setAttribs(array('maxlength'=>3, 'class'=>'tinyint', 
        'min'=>0));
        $maxlength->setDescription('Set the maximum number of characters that
        can be entered into this field, we default to 255 characters.');
        $maxlength->setBelongsTo('params');
        
        $value = $this->fieldAttributeValue('maxlengh');
        if($value != FALSE) {
			$maxlength->setValue($value);
        }

        $this->elements['maxlength'] = $maxlength;
        
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