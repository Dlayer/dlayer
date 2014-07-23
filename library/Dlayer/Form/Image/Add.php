<?php
/**
* Form for the add new image tool
* 
* Allows the user to add a new image to the library, there is an independant 
* edit version of the tool
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Form_Image_Add extends Dlayer_Form_Module_Image
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
        $this->tool = 'add';
        
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

        $this->setUpFormElements();

        $this->validationRules();
        
        $this->addElementsToForm('add', 'Add image', $this->elements);

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
        $category->setDescription('Select the base category for the new image');
        $category->setMultiOptions(array(1=>'Backgrounds', 2=>'News'));
        $category->setBelongsTo('params');
        
        $this->elements['category'] = $category;
        
        $sub_category = new Zend_Form_Element_Select('sub_category');
        $sub_category->setLabel('Sub category');
        $sub_category->setDescription('Select the sub category to use for the 
        new image');
        $sub_category->setMultiOptions(array(1=>'Pictures', 2=>'Gradients'));
        $sub_category->setBelongsTo('params');
        
        $this->elements['sub_category'] = $sub_category;
        
    	$name = new Zend_Form_Element_Text('name');
        $name->setLabel('Name');
        $name->setAttribs(array('maxlength'=>255, 
        'placeholder'=>'e.g., Site background'));
        $name->setDescription('Enter a name for the new image, this will be 
        shown when you need to choose the image from a list.');
        $name->setBelongsTo('params');
        
        $this->elements['name'] = $name;
        
        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('Description');
        $description->setAttribs(array('rows'=>3, 'cols'=>50, 
        'placeholder'=>'e.g., Site background for the news page'));
        $description->setDescription('Enter a description of the new image.');
        $description->setBelongsTo('params');
        
        $this->elements['description'] = $description;
        
        $image = new Zend_Form_Element_File('image');
        $image->setLabel('Image');
        $image->setDescription('Choose an image to add to the Image library.');
        $image->setBelongsTo('params');
        
        $this->elements['image'] = $image;
        
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
    
    /**
    * Add any custom decorators, these are inputs where we need a little more
    * control over the html, an example being the submit button
    *
    * @return void
    */
    protected function addCustomElementDecorators()
    {
        $this->elements['image']->setDecorators(array('File','Description',
        'Errors', array('Label'), array(array('row'=>'HtmlTag'), 
        array('tag'=>'div', 'class'=>'input'))));
        
        parent::addCustomElementDecorators();
    }
}