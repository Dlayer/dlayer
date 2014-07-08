<?php
/**
* Form for the heading content tool
* 
* Allows the user to add a heading as a content item, when adding a heading 
* item the user needs to define the heading style, margin and width values in 
* addition to the heading text itself.
* 
* The width and margin values will be defaulted with sensible values based 
* upon the page block the content item is being added to
* 
* This form is used for the add and edit version of the tool
*
* @author Dean Blackborough
* @copyright G3D Development Limited
* @version $Id: Heading.php 1928 2014-06-12 13:53:38Z Dean.Blackborough $
*/
class Dlayer_Form_Content_Heading extends Dlayer_Form_Module_Content
{
    /**
    * Set the initial properties for the form
    *
    * @param integer $page_id
    * @param integer $div_id
    * @param array $container Content container sizes, contains all the size 
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
        $this->tool = 'heading';
        $this->content_type = 'heading';
        $this->sub_tool_model = NULL;

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

        $this->formElementsData();
        
        $this->setUpFormElements();

        $this->validationRules();

        $this->addElementsToForm('heading_text', 'Add heading', 
        $this->elements);

        $this->addDefaultElementDecorators();

        $this->addCustomElementDecorators();
    }

    /**
    * Fetch the data requuired by the form select menus
    *
    * @return void Writes the data to the $this->element_data property
    */
    private function formElementsData()
    {
        $model_settings = new Dlayer_Model_Settings();

        foreach($model_settings->headingStyles() as $k=>$values) {
            $this->elements_data[$k] = $values['name'];
        }
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
        
        $content_type = new Zend_Form_Element_Hidden('content_type');
        $content_type->setValue('heading');

        $this->elements['content_type'] = $content_type;

        if(array_key_exists('id', $this->existing_data) == TRUE 
        && $this->existing_data['id'] != FALSE) {
            $content_id = new Zend_Form_Element_Hidden('content_id');
            $content_id->setValue($this->existing_data['id']);

            $this->elements['content_id'] = $content_id;
        }

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
    	$name = new Zend_Form_Element_Text('name');
        $name->setLabel('Name');
        $name->setAttribs(array('size'=>50, 'maxlength'=>255, 
        'placeholder'=>'e.g., Page title'));
        $name->setDescription('Set a name for the content, this will allow you 
        to easily identify it when you want to re-use the heading text.');
        $name->setBelongsTo('params');
        $name->setRequired();
        if(array_key_exists('name', $this->existing_data) == TRUE 
        && $this->existing_data['name'] != FALSE) {
            $name->setValue($this->existing_data['name']);
        }

        $this->elements['name'] = $name;
    	
    	$heading = new Zend_Form_Element_Textarea('heading');
        $heading->setLabel('Heading');
        $heading->setAttribs(array('cols'=>50, 'rows'=>4, 
        'placeholder'=>'e.g., Page heading!'));
        $heading->setDescription('Enter the text for the new heading.');
        $heading->setBelongsTo('params');
        $heading->setRequired();
        if(array_key_exists('heading', $this->existing_data) == TRUE 
        && $this->existing_data['heading'] != FALSE) {
            $heading->setValue($this->existing_data['heading']);
        }

        $this->elements['heading'] = $heading;
        
        if($this->edit_mode == TRUE && 
        array_key_exists('id', $this->existing_data) == TRUE && 
        array_key_exists('instances', $this->existing_data) == TRUE && 
        $this->existing_data['id'] != FALSE && 
        $this->existing_data['instances'] > 1) {
	        $instances = new Zend_Form_Element_Select('instances');
	        $instances->setLabel('Update all instances');
	        $instances->setDescription('There are ' . 
	        $this->existing_data['instances'] . '  instances of this 
	        text in your site, to update all instances select yes, otherwise 
	        select no and only this heading wil be updated.');
	        $instances->setMultiOptions(array(1=>'Yes - Update all instances', 
	        0=>'No - Only update this heading'));
	        $instances->setBelongsTo('params');
		} else {
			$instances = new Zend_Form_Element_Hidden('instances');
			$instances->setValue(0);
			$instances->setBelongsTo('params');
		}
        
        $this->elements['instances'] = $instances;
    	
        $heading_type = new Zend_Form_Element_Select('heading_type');
        $heading_type->setLabel('Heading type');
        $heading_type->setMultiOptions($this->elements_data);
        $heading_type->setDescription('Choose the type for the new heading.');
        $heading_type->setBelongsTo('params');
        if(array_key_exists('heading_id', $this->existing_data) == TRUE 
        && $this->existing_data['heading_id'] != FALSE) {
            $heading_type->setValue($this->existing_data['heading_id']);
        }
        
        /**
        * 
        * 
        * @todo Need to include a check box if the current piece of text is 
        * being used by multiple content items, asks the user if they want to 
        * update all content items or just this one.
        * 
        * 
        */

        $this->elements['heading_type'] = $heading_type;

        $padding_top = new Dlayer_Form_Element_Number('padding_top');
        $padding_top->setLabel('Top padding');
        $padding_top->setAttribs(array('maxlength'=>3, 'class'=>'tinyint', 
        'min'=>0));
        $padding_top->setDescription('Set the spacing above the title.');
        $padding_top->setBelongsTo('params');
        if(array_key_exists('padding_top', $this->existing_data) == TRUE 
        && $this->existing_data['padding_top'] != FALSE) {
            $padding_top->setValue($this->existing_data['padding_top']);
        } else {
            $padding_top->setValue(12);
        }

        $this->elements['padding_top'] = $padding_top;

        $padding_bottom = new Dlayer_Form_Element_Number('padding_bottom');
        $padding_bottom->setLabel('Bottom padding');
        $padding_bottom->setAttribs(array('maxlength'=>3, 'class'=>'tinyint',
        'min'=>0));
        $padding_bottom->setDescription('Set the spacing below the title.');
        $padding_bottom->setBelongsTo('params');
        if(array_key_exists('padding_bottom', $this->existing_data) == TRUE 
        && $this->existing_data['padding_bottom'] != FALSE) {
            $padding_bottom->setValue($this->existing_data['padding_bottom']);
        } else {
            $padding_bottom->setValue(12);
        }

        $this->elements['padding_bottom'] = $padding_bottom;

        $padding_left = new Dlayer_Form_Element_Number('padding_left');
        $padding_left->setLabel('Left padding');
        $padding_left->setAttribs(array('maxlength'=>3, 'class'=>'tinyint', 
        'min'=>0));
        $padding_left->setDescription('Set the spacing to the left of the
        title.');
        $padding_left->setBelongsTo('params');
        $padding_left->setValue($this->container['padding_left']);

        $this->elements['padding_left'] = $padding_left;

        $width = new Dlayer_Form_Element_Number('width');
        $width->setLabel('Width');
        $width->setAttribs(array('maxlength'=>4, 'class'=>'mediumint', 
        'min'=>0));
        $width->setDescription('Set the width for the heading content
        conatiner.');
        $width->setBelongsTo('params');
        $width->setValue($this->container['width']);

        $this->elements['width'] = $width;
        
        // Duplicated value for params array, required by the validateData 
        // method when in edit mode, content item is not currently being 
        // passed to the validateData method
        if(array_key_exists('id', $this->existing_data) == TRUE 
        && $this->existing_data['id'] != FALSE) {
        	$content_id = new Zend_Form_Element_Hidden('content_container_id');
        	$content_id->setValue($this->existing_data['id']);
        	$content_id->setBelongsTo('params');

            $this->elements['content_container_id'] = $content_id;
        }
        
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
        $this->elements['submit']->setDecorators(array(array('ViewHelper'),
        array('HtmlTag', array('tag' => 'div', 'class'=>'save'))));

        $this->elements['padding_top']->setDecorators(
        array(array('ViewHelper', array('tag' => 'div', 'class'=>'input')),
        array('Description'), array('Errors'), array('Label'),
        array('HtmlTag', array('tag' => 'div', 'class'=>'input_50'))));

        $this->elements['padding_bottom']->setDecorators(
        array(array('ViewHelper', array('tag' => 'div', 'class'=>'input')),
        array('Description'), array('Errors'), array('Label'),
        array('HtmlTag', array('tag' => 'div', 'class'=>'input_50'))));

        $this->elements['padding_left']->setDecorators(
        array(array('ViewHelper', array('tag' => 'div', 'class'=>'input')),
        array('Description'), array('Errors'), array('Label'),
        array('HtmlTag', array('tag' => 'div', 'class'=>'input_50'))));

        $this->elements['width']->setDecorators(
        array(array('ViewHelper', array('tag' => 'div', 'class'=>'input')),
        array('Description'), array('Errors'), array('Label'),
        array('HtmlTag', array('tag' => 'div', 'class'=>'input_50'))));
    }
}