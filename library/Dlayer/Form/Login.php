<?php
/**
* Login form
* 
* Captures the username and password for the user attempting to log in
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
* @version $Id: Login.php 1724 2014-04-13 15:12:59Z Dean.Blackborough $
*/
class Dlayer_Form_Login extends Dlayer_Form 
{
    /**
    * Pass in any values that are needed to set up the form
    * 
    * @param array|NULL Options for form
    * @return void
    */
    public function __construct($options=NULL)
    {
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
        $this->setAction('/dlayer/index/index');
        
        $this->setMethod('post');
        
        $this->setUpFormElements();
        
        $this->validationRules();
        
        $this->addElementsToForm('login_form', 'Start building a web site', 
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
    	$identity = new Zend_Form_Element_Text('identity');
    	$identity->setLabel('Username');
    	$identity->setDescription('Please enter a username, try one of the 
        combinations below.');
        $identity->setAttribs(array('size'=>30, 'maxlength'=>255, 
        'placeholder'=>'e.g., user-1@dlayer.com', 'class'=>'form-control'));
    	$this->elements['identity'] = $identity;
        
        $credentials = new Zend_Form_Element_Password('credentials');
        $credentials->setLabel('Passsword');
        $credentials->setDescription('Please enter a password, try one of the 
        combinations below.');
        $credentials->setAttribs(array('placeholder'=>'********', 
        'class'=>'form-control'));
        $this->elements['credentials'] = $credentials;
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Login');
        $submit->setAttribs(array('class'=>'btn btn-primary', 
        'disabled'=>'disabled'));
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
    	$this->elements['identity']->setRequired();
    	$this->elements['identity']->addvalidator(
    	new Zend_Validate_EmailAddress());
        $this->elements['credentials']->setRequired();
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
        array('HtmlTag', array('tag' => 'div', 'class'=>'form-group'))));
    }
    
    /**
    * Add the default decorators to use for the form inputs
    *
    * @return void
    */
    protected function addDefaultElementDecorators()
    {
    	$this->setDecorators(array('FormElements',array('Form', array('class'=>'form'))));
    	
        $this->setElementDecorators(array(
        array('ViewHelper', array('tag' => 'div', 'class'=>'form-group')), 
        array('Description', array('tag' => 'p', 'class'=>'help-block')),
        array('Errors'), 
        array('Label'), 
        array('HtmlTag', array('tag' => 'div', 'class'=>'form-group'))));
    }
}