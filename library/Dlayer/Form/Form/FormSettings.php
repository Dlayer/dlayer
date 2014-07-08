<?php
/**
* Form for the form settings
* 
* Allows the user to define settings for the form, these settings all work 
* at the form level, where relevant they can be overridden at the form 
* field level.
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_Form_FormSettings extends Dlayer_Form_Module_Form
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
        $this->tool = 'form-settings';

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

        $this->addElementsToForm('form_settings', 'Form settings', 
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
        $width = new Dlayer_Form_Element_Number('width');
        $width->setLabel('Minimum width');
        $width->setDescription('Set the minimum display width for the form, 
        the form will not be able to be imported into any container smaller 
        than the set minimum width');
        $width->setAttribs(array('maxlength'=>3, 'class'=>'tinyint', 
        'min'=>0));
        $width->setValue($this->field_data['width']);
        $width->setBelongsTo('params');

        $this->elements['width'] = $width;
        
        $legend = new Zend_Form_Element_Text('legend');
        $legend->setLabel('Legend');
        $legend->setDescription('Set the legend text for the form fieldset.');
        $legend->setAttribs(array('maxlength'=>255, 'size'=>50));
        $legend->setValue($this->field_data['legend']);
        $legend->setBelongsTo('params');

        $this->elements['legend'] = $legend;
        
        $button = new Zend_Form_Element_Text('button');
        $button->setLabel('Button text');
        $button->setDescription("Set the text for the submit button, the 
        default value is 'save'.");
        $button->setAttribs(array('maxlength'=>255, 'size'=>50));
        $button->setValue($this->field_data['button']);
        $button->setBelongsTo('params');

        $this->elements['button'] = $button;
        
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