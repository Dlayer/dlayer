<?php
/**
* Form for the edit image tool
* 
* Allows the user to define a new name, description, category or sub category 
* for the selected image, applies to all versions as these details as attached 
* to the base image
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Form_Image_Edit extends Dlayer_Form_Module_Image
{
	/**
    * Set the initial properties for the form
    * 
    * @param array $existing_data Exisitng data array for form, array values 
    *                             always preset, will have FALSE values if there 
    *                             is no existing data value
    * @param boolean $edit_mode Is the tool in edit mode
    * @param integer $multi_use Tool tab multi use param
    * @param array|NULL $options Zend form options data array
    * @return void
    */
    public function __construct(array $existing_data, $edit_mode, 
    $multi_use, $options=NULL)
    {
        $this->tool = 'edit';
        
        parent::__construct($existing_data, $edit_mode, $multi_use, $options);
    }
    
    /**
    * Initialuse the form, sers the url and submit method and then calls the
    * methods that set up the form
    *
    * @return void
    */
    public function init()
    {
        $this->setAction('/image/process/tool');

        $this->setMethod('post');
        
        $this->formElementsData();

        $this->setUpFormElements();

        $this->validationRules();
        
        $this->addElementsToForm('edit', 'Edit image', $this->elements);

        $this->addDefaultElementDecorators();

        $this->addCustomElementDecorators();
    }
    
    /**
    * Fetch the data requuired to populate the selected menu, specifically 
    * the category select as the sub category select will be populate via 
    * AJAX on category select change
    *
    * @return void Writes the data to the $this->element_data property
    */
    private function formElementsData()
    {
        $session_dlayer = new Dlayer_Session();
        $model_categories = new Dlayer_Model_Image_Categories();
        
        $this->elements_data['categories'] = $model_categories->categories(
        $session_dlayer->siteId());
        
        $this->elements_data['sub_categories'] = 
        $model_categories->subCategories($session_dlayer->siteId(), 
        $this->existing_data['category_id']);
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
        $tool = new Zend_Form_Element_Hidden('tool');
        $tool->setValue($this->tool);

        $this->elements['tool'] = $tool;
        
        $multi_use = new Zend_Form_Element_Hidden('multi_use');
        $multi_use->setValue($this->multi_use);
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
        $category = new Zend_Form_Element_Select('category');
        $category->setLabel('Category');
        $category->setDescription(' Select a new category for the image');
        $category->setMultiOptions($this->elements_data['categories']);
        $category->setBelongsTo('params');
        
        if(array_key_exists('category_id', $this->existing_data) == TRUE && 
        $this->existing_data['category_id'] != FALSE) {
            $category->setValue($this->existing_data['category_id']);
        }
        
        $this->elements['category'] = $category;
        
        $sub_category = new Zend_Form_Element_Select('sub_category');
        $sub_category->setLabel('Sub category');
        $sub_category->setDescription('Select a new sub category for the 
        image');
        $sub_category->setMultiOptions($this->elements_data['sub_categories']);
        $sub_category->setBelongsTo('params');
        
        if(array_key_exists('sub_category_id', $this->existing_data) == TRUE && 
        $this->existing_data['sub_category_id'] != FALSE) {
            $sub_category->setValue($this->existing_data['sub_category_id']);
        }
        
        $this->elements['sub_category'] = $sub_category;
        
    	$name = new Zend_Form_Element_Text('name');
        $name->setLabel('Name');
        $name->setAttribs(array('maxlength'=>255, 
        'placeholder'=>'e.g., Site background'));
        $name->setDescription('Enter a new name for the image, this will be 
        shown when you need to choose the image from a list.');        
        $name->setBelongsTo('params');
        
        if(array_key_exists('name', $this->existing_data) == TRUE && 
        $this->existing_data['name'] != FALSE) {
            $name->setValue($this->existing_data['name']);
        }
        
        $this->elements['name'] = $name;
        
        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('Description');
        $description->setAttribs(array('rows'=>6, 'cols'=>50, 
        'placeholder'=>'e.g., Site background for the news page'));
        $description->setDescription('Enter a new description of 
        the new image.');        
        $description->setBelongsTo('params');
        
        if(array_key_exists('description', $this->existing_data) == TRUE && 
        $this->existing_data['description'] != FALSE) {
            $description->setValue($this->existing_data['description']);
        }
        
        $this->elements['description'] = $description;
                
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