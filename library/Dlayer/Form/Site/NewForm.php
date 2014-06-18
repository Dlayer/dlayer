<?php
/**
* New form
* 
* Allows the user to create a new form for use within the current site
*  
* @author Dean Blackborough
* @copyright G3D Development Limited
* @version $Id: NewForm.php 1724 2014-04-13 15:12:59Z Dean.Blackborough $
*/
class Dlayer_Form_Site_NewForm extends Dlayer_Form_Module_App 
{
	private $site_id;
	
    /**
    * Pass in any values that are needed to set up the form
    * 
    * @param integer $site_id
    * @param array|NULL Options for form
    * @return void
    */
    public function __construct($site_id, $options=NULL)
    {
    	$this->site_id = $site_id;
    	
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
        $this->setAction('/form/index/new-form');
        
        $this->setMethod('post');
        
        $this->setUpFormElements();
        
        $this->validationRules();
        
        $this->addElementsToForm('new_form', 'New form', 
        $this->elements);
        
        $this->addDefaultElementDecorators();
        
        $this->addCustomElementDecorators();
    }
    
    /** 
    * Set up the form elements needed for this form
    * 
    * @return void Form elements are written to the private $this->elements 
    *              property
    */
    protected function setUpFormElements() 
    {
    	$name = new Zend_Form_Element_Text('name');
    	$name->setLabel('Name');
    	$name->setDescription('Enter a name for the new form, this will 
    	only display within Dlayer, not on your site.');
        $name->setAttribs(array('size'=>50, 'maxlength'=>255, 
        'placeholder'=>'e.g., Contact form'));
    	$this->elements['name'] = $name;
        
        $submit = new Zend_Form_Element_Submit('submit');
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
    	$this->elements['name']->setRequired();
        $this->elements['name']->addValidator(
        new Dlayer_Validate_FormNameUnique($this->site_id));
    }
}