<?php
/**
* Form for the text content tool
* 
* Allows the user to add a block of text as a content item, when adding a text 
* block the user needs to define the width and padding for the content 
* container as well as the text itself.
* 
* The width and padding will be defaulted with sensible values based upon the 
* page block the content item is being added to
* 
* This form is used for the add and edit version of the tool
*
* @author Dean Blackborough
* @copyright G3D Development Limited
* @version $Id: Text.php 1928 2014-06-12 13:53:38Z Dean.Blackborough $
*/
class Dlayer_Form_Content_Text extends Dlayer_Form_Module_Content
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
        $this->tool = 'text';
        $this->content_type = 'text';
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

        $this->setUpFormElements();

        $this->validationRules();

        $this->addElementsToForm('text_text', 'Add text', $this->elements);

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
        
        $content_type = new Zend_Form_Element_Hidden('content_type');
        $content_type->setValue('text');

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
        'placeholder'=>'e.g., Intro text for site'));
        $name->setDescription('Set a name for the content, this will allow you 
        to easily identify it when you want to re-use the text.');
        $name->setBelongsTo('params');
        $name->setRequired();
        if(array_key_exists('name', $this->existing_data) == TRUE 
        && $this->existing_data['name'] != FALSE) {
            $name->setValue($this->existing_data['name']);
        }

        $this->elements['name'] = $name;
    	
    	$text = new Zend_Form_Element_Textarea('content');
        $text->setLabel('Text');
        $text->setAttribs(array('cols'=>50, 'rows'=>10, 
        'placeholder'=>'e.g., The quick brown fox jumps over...'));
        $text->setDescription('Enter the text for your new content.');
        $text->setBelongsTo('params');
        $text->setRequired();
        if(array_key_exists('content', $this->existing_data) == TRUE 
        && $this->existing_data['content'] != FALSE) {
            $text->setValue($this->existing_data['content']);
        }

        $this->elements['text'] = $text;
        
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
	        select no and only this text block be updated.');
	        $instances->setMultiOptions(array(1=>'Yes - Update all instances', 
	        0=>'No - Only update this text block'));
	        $instances->setBelongsTo('params');
		} else {
			$instances = new Zend_Form_Element_Hidden('instances');
			$instances->setValue(0);
			$instances->setBelongsTo('params');
		}
        
        $this->elements['instances'] = $instances;
    	
        $width = new Dlayer_Form_Element_Number('width');
        $width->setLabel('Width');
        $width->setAttribs(array('maxlength'=>4, 'class'=>'mediumint', 
        'min'=>0));
        $width->setDescription('Set the width for the text block container, it
        can be no larger than the page block it sits in, the submitted value
        will be checked by the tool.');
        $width->setBelongsTo('params');
        $width->setValue($this->container['width']);

        $this->elements['width'] = $width;

        $padding = new Dlayer_Form_Element_Number('padding');
        $padding->setLabel('Padding');
        $padding->setAttribs(array('maxlength'=>3, 'class'=>'tinyint', 
        'min'=>0, 'max'=>99));
        $padding->setDescription('Set the padding for the text, this much space
        will be left around the outside of the text.');
        $padding->setBelongsTo('params');
        $padding->setValue($this->container['padding']);

        $this->elements['padding'] = $padding;
        
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
}