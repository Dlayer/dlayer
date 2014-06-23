<?php
/**
* New page
* 
* Allows the user to create a new page for use within the current site, they 
* need to choose the template to use and set a name
*  
* @author Dean Blackborough
* @copyright G3D Development Limited
* @version $Id: NewPage.php 1724 2014-04-13 15:12:59Z Dean.Blackborough $
*/
class Dlayer_Form_Site_NewPage extends Dlayer_Form_Module_App 
{
	private $site_id;
    private $data;
	
    /**
    * Pass in any values that are needed to set up the form
    * 
    * @param integer $site_id
    * @param array $templates Array of templates for site
    * @param array|NULL Options for form
    * @return void
    */
    public function __construct($site_id, array $templates=array(), 
    $options=NULL)
    {
    	$this->site_id = $site_id;
        $this->data['templates'] = $templates;
    	
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
        $this->setAction('/content/index/new-page');
        
        $this->setMethod('post');
        
        $this->setUpFormElements();
        
        $this->validationRules();
        
        $this->addElementsToForm('new_page', 'New page', 
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
    	$name->setDescription('Enter a name for the new page, this will 
    	only display within Dlayer, not on your site.');
        $name->setAttribs(array('size'=>50, 'maxlength'=>255, 
        'placeholder'=>'e.g., News page'));
    	$this->elements['name'] = $name;
        
        $template = new Zend_Form_Element_Select('template');
        $template->setLabel('Template');
        $template->setDescription('Choose the template to use to base the 
        new page upon.');
        $template->setMultiOptions($this->data['templates']);
        $this->elements['template'] = $template;
        
        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Title');
        $title->setDescription('Enter the title for your page, this will be 
        shown in the title bar or the user\'s web browser.');
        $title->setAttribs(array('size'=>50, 'maxlength'=>255, 
        'placeholder'=>"e.g., All the news for 'My new site'"));
        $this->elements['title'] = $title;
        
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
        new Dlayer_Validate_PageNameUnique($this->site_id));
        
        $this->elements['title']->setRequired();
    }
}