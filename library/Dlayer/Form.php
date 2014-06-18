<?php
/**
* Custom form class, contains base functionality and sets up the structure for 
* a form class
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
* @version $Id: Form.php 1724 2014-04-13 15:12:59Z Dean.Blackborough $
*/
abstract class Dlayer_Form extends Zend_Form 
{
    /**
    * Form elments
    * 
    * @var array
    */
    protected $elements = array();
    
    /**
    * Pass in any values that are needed to set up the form, optional
    * 
    * @param array|NULL Options for form
    * @return void
    */
    public function __construct($options=NULL)
    {
        parent::__construct($options=NULL);
    }
    
    /** 
    * Set up the form elements needed for this form
    * 
    * @return void Form elements are written to the private $this->elements 
    *              property
    */
    abstract protected function setUpFormElements();
    
    /**
    * Add the validation rules for the form elements and set the custom error 
    * messages
    * 
    * @return void
    */
    abstract protected function validationRules();
    
    /**
    * Add the default decorators to use for the form inputs
    * 
    * @return void
    */
    abstract protected function addDefaultElementDecorators();
    
    /**
    * Add any custom decorators, these are inputs where we need a little more 
    * control over the html, an example being the submit button
    * 
    * @return void
    */
    abstract protected function addCustomElementDecorators();    
    
    /** 
    * Add the elements to the form set up the fieldset/legend
    * 
    * @param string $id Fieldset id
    * @param string $label Label for fieldset
    * @param array $elements Elements to add to form and pass to display group
    * @retrun void
    */
    protected function addElementsToForm($id, $label, array $elements) 
    {
        $this->addElements($elements);
        
        $this->addDisplayGroup($elements, $id, array('legend'=>$label));
    }
}