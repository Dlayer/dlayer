<?php
/**
* Filter form for Image library, allows the user to filter the image library 
* by category and sub category
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Form_Image_Filter extends Dlayer_Form 
{
    private $categories;
    private $sub_categories;
    private $category_id;
    private $sub_category_id;
    
	/**
    * Set the initial properties for the form
    * 
    * @param array $categories Categories for site
    * @param array $sub_categories Sub category for selected category
    * @param integer $category_id
    * @param integer $sub_category_id
    * @param array|NULL $options Zend form options data array
    * @return void
    */
    public function __construct(array $categories, array $sub_categories, 
    $category_id, $sub_category_id, $options=NULL)
    {
        $this->categories = $categories;
        $this->sub_categories = $sub_categories;
        $this->category_id = $category_id;
        $this->sub_category_id = $sub_category_id;
        
        parent::__construct($options);
    }
    
    /**
    * Initialuse the form, sers the url and submit method and then calls the
    * methods that set up the form
    *
    * @return void
    */
    public function init()
    {
        $this->setAction('/image/designer/filter');

        $this->setMethod('post');

        $this->setUpFormElements();
        
        $this->addElements($this->elements);

        $this->validationRules();
        
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
        $category = new Zend_Form_Element_Select('category_filter');
        $category->setLabel('Category');
        $category->setMultiOptions($this->categories);
        
        $this->elements['category'] = $category;
        
        $sub_category = new Zend_Form_Element_Select('sub_category_filter');
        $sub_category->setLabel('Sub category');
        $sub_category->setMultiOptions($this->sub_categories);
        
        $this->elements['sub_category'] = $sub_category;
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('class', 'submit');
        $submit->setLabel('Filter');

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
    
    /**
    * Add the default decorators to use for the form inputs
    *
    * @return void
    */
    protected function addDefaultElementDecorators()
    {
        $this->setDecorators(array('FormElements', 
        array('HtmlTag', array('tag' => 'div', 'class'=>'filter')), 
        'Form'));
        
        $this->setElementDecorators(array(array('ViewHelper',
        array('tag' => 'div', 'class'=>'input')), 
        array('Errors'), array('Label'), array('HtmlTag',
        array('tag' => 'div', 'class'=>'input'))));
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
        array('HtmlTag', array('tag' => 'div', 'class'=>'save'))));
    }
}