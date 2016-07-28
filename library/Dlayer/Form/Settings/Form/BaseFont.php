<?php
/**
* Base font setings form, allows the user to define the base font to use for 
* a module, in this case the form builder module
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Form_Settings_Form_BaseFont extends Dlayer_Form_Module_App 
{
    private $font_family_id;
    private $font_families;
    
    /**
    * Pass in any values that are needed to set up the form
    * 
    * @param integer $font_family_id Id of the currently saved font family
    * @param array|NULL Options for form
    * @return void
    */
    public function __construct($font_family_id, $options=NULL)
    {
        $this->font_family_id = $font_family_id;
        
        parent::__construct($options=NULL);
    }
    
    /**
    * Initialise the form, sets the url and submit method and then calls 
    * the methods that set up the form itself
    * 
    * @return void
    */
    public function init() 
    {        
        $this->setAction('/form/settings/base-font-family');
        
        $this->setMethod('post');
        
        $this->formElementsData();
        
        $this->generateFormElements();
        
        $this->validationRules();
        
        $this->addElementsToForm('font_families', 
        'Base font family <small>Default font for text on forms</small>', 
        $this->elements);
        
        $this->addDefaultElementDecorators();
        
        $this->addCustomElementDecorators();
    }
    
    /**
    * Fetch the data for the form select menus
    * 
    * @return void Writes the data to the $this->font_familes property.
    */
    private function formElementsData() 
    {
        $model_settings = new Dlayer_Model_Settings();
        
        $this->font_families = array();
        
        foreach($model_settings->fontFamilies() as $k=>$values) {
            $this->font_families[$k] = $values['name'];
        }
    }
    
    /** 
    * Set up the form elements needed for this form
    * 
    * @return void Form elements are written to the private $this->elements 
    *              property
    */
    protected function generateFormElements()
    {
        $font_family = new Zend_Form_Element_Select('font_family');
        $font_family->setLabel('Font family:');
        $font_family->setMultiOptions($this->font_families);
        $font_family->setValue($this->font_family_id);
        $font_family->setAttribs(array('class'=>'font_families form-control'));
        $this->elements['font_family'] = $font_family;
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Save');
        $submit->setAttribs(array('class'=>'btn btn-primary'));
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
