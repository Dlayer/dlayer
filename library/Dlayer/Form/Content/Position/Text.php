<?php
/**
* Position form for the text tool
* 
* Allows the user to define the placement of the text content item by 
* defining the top, right, bottom and left margin
*
* @author Dean Blackborough
* @copyright G3D Development Limited
* @version $Id: Text.php 1928 2014-06-12 13:53:38Z Dean.Blackborough $
*/
class Dlayer_Form_Content_Position_Text extends Dlayer_Form_Module_Content
{
    /**
    * Set the initial properties for the form
    *
    * @param integer $page_id
    * @param integer $div_id
    * @param array $container Content container sizes, conatins all the size 
    * 						  fields relevant to the content item
    * @param array $existing_data Exisitng form data array, array values will 
    * 							  be FALSE if there is no data for the field
    * @param boolean $edit_mode Is the tool in edit mode
    * @param integer $multi_use Tool tab multi use param
    * @param array|NULL $options Zend form options data array
    * @return void
    */
    public function __construct($page_id, $div_id, array $container, 
    array $existing_data, $edit_mode=FALSE, $multi_use, $options=NULL)
    {
        $this->tool = 'text';
        $this->content_type = 'text';
        $this->sub_tool_model = 'Position_Text';

        parent::__construct($page_id, $div_id, $container, $existing_data, 
        $edit_mode, $multi_use, $options=NULL);
    }

    /**
    * Initialuse the form, sers the url and submit method and then calls the
    * methods that set up the form
    *
    * @return void
    */
    public function init()
    {
        $this->setAction('/content/process/tool');

        $this->setMethod('post');

        $this->setUpFormElements();

        $this->validationRules();

        $this->addElementsToForm('text_position', 'Container position', 
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
        $page_id = new Zend_Form_Element_Hidden('page_id');
        $page_id->setValue($this->page_id);

        $this->elements['page_id'] = $page_id;

        $div_id = new Zend_Form_Element_Hidden('div_id');
        $div_id->setValue($this->div_id);

        $this->elements['div_id'] = $div_id;

        $tool = new Zend_Form_Element_Hidden('tool');
        $tool->setValue($this->tool);

        $this->elements['tool'] = $tool;
        
        $sub_tool_model = new Zend_Form_Element_Hidden('sub_tool_model');
        $sub_tool_model->setValue($this->sub_tool_model);

        $this->elements['sub_tool_model'] = $sub_tool_model;
        
        $content_type = new Zend_Form_Element_Hidden('content_type');
        $content_type->setValue($this->content_type);

        $this->elements['content_type'] = $content_type;

        $content_id = new Zend_Form_Element_Hidden('content_id');
        $content_id->setValue($this->existing_data['content_id']);

        $this->elements['content_id'] = $content_id;

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
    	$top = new Dlayer_Form_Element_Number('top');
        $top->setLabel('Top: (Spacing above text item)');
        $top->setAttribs(array('max'=>1000, 'maxlength'=>4, 'class'=>'tinyint', 
        'min'=>0));
        $top->setDescription('Set the size of the spacing that you would like 
        above the text content item.');
        $top->setBelongsTo('params');
        
        $value = $this->existingDataValue('top');
        if($value != FALSE) {
			$top->setValue($value);
        } else {
			$top->setValue(0);
        }
        
        $this->elements['top'] = $top;
        
        $right = new Dlayer_Form_Element_Number('right');
        $right->setLabel('Right: (Spacing to right of text item)');
        $right->setAttribs(array('max'=>1000, 'maxlength'=>4, 'class'=>'tinyint', 
        'min'=>0));
        $right->setDescription('Set the size of the spacing that you would like 
        to the right of the text content item.');
        $right->setBelongsTo('params');
        
        $value = $this->existingDataValue('right');
        if($value != FALSE) {
			$right->setValue($value);
        } else {
			$right->setValue(0);
        }
        
        $this->elements['right'] = $right;
        
        $bottom = new Dlayer_Form_Element_Number('bottom');
        $bottom->setLabel('Bottom: (Spacing below text item)');
        $bottom->setAttribs(array('max'=>1000, 'maxlength'=>4, 'class'=>'tinyint', 
        'min'=>0));
        $bottom->setDescription('Set the size of the spacing that you would like 
        below the text content item.');
        $bottom->setBelongsTo('params');
        
        $value = $this->existingDataValue('bottom');
        if($value != FALSE) {
			$bottom->setValue($value);
        } else {
			$bottom->setValue(0);
        }
        
        $this->elements['bottom'] = $bottom;
        
        $left = new Dlayer_Form_Element_Number('left');
        $left->setLabel('Left: (Spacing to the left of text item)');
        $left->setAttribs(array('max'=>1000, 'maxlength'=>4, 'class'=>'tinyint', 
        'min'=>0));
        $left->setDescription('Set the size of the spacing that you would like 
        to the left of the text content item.');
        $left->setBelongsTo('params');
        
        $value = $this->existingDataValue('left');
        if($value != FALSE) {
			$left->setValue($value);
        } else {
			$left->setValue(0);
        }
        
        $this->elements['left'] = $left;
        
        // Duplicated value for params array, required by the validateData 
        // method, this is the easiest way of passing the value through 
        // without modifying the process controller and tool classes
        $content_id = new Zend_Form_Element_Hidden('content_container_id');
        $content_id->setValue($this->existing_data['content_id']);
        $content_id->setBelongsTo('params');

        $this->elements['content_container_id'] = $content_id;
                
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