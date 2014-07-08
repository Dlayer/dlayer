<?php
/**
* Form for the import form tool
* 
* Allows the user to choose a form from the form builder to import, 
* set the width of the containing div and then add any padding to the div
*
* This form is used by the add and edit version of the ribbon
*
* @author Dean Blackborough
* @copyright G3D Development Limited
* @version $Id: ImportForm.php 1928 2014-06-12 13:53:38Z Dean.Blackborough $
*/
class Dlayer_Form_Content_ImportForm extends Dlayer_Form_Module_Content
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
    * @param integer $multi_use Tool tab multi use param
    * @param boolean $edit_mode Is the tool in edit mode
    * @param array|NULL $options Zend form options data array
    * @return void
    */
    public function __construct($page_id, $div_id, array $container,
    array $existing_data, $edit_mode=FALSE, $multi_use, $options=NULL)
    {
        $this->tool = 'import-form';
        $this->content_type = 'form';
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

        $this->addElementsToForm('form', 'Import form', $this->elements);

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
        $model_forms = new Dlayer_Model_Form();
        $session_dlayer = new Dlayer_Session();
        
        $this->elements_data[] = 'Choose form';
        
        foreach($model_forms->forms($session_dlayer->siteId()) as $form) {
            $this->elements_data[$form['id']] = $form['name'];
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
        $content_type->setValue($this->content_type);

        $this->elements['content_type'] = $content_type;

        if(array_key_exists('id', $this->existing_data) == TRUE &&
        $this->existing_data['id'] != FALSE) {
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
    	$form = new Zend_Form_Element_Select('form_id');
        $form->setLabel('Form');
        $form->setDescription('Select the form that you would like to import 
        into the page block.');
        $form->setMultiOptions($this->elements_data);
        $form->setBelongsTo('params');
        if(array_key_exists('form_id', $this->existing_data) == TRUE && 
        $this->existing_data['form_id'] != FALSE) {
            $form->setValue($this->existing_data['form_id']);
        }

        $this->elements['form_id'] = $form;
        
        $width = new Dlayer_Form_Element_Number('width');
        if($this->edit_mode == FALSE) {
            $width->setLabel('Width');
        } else {
            $width->setLabel('Width - Minimum width: ' . 
            $this->existing_data['minimum_width']);
        }
        $width->setAttribs(array('maxlength'=>4, 'class'=>'mediumint'));
        if($this->edit_mode == TRUE) {
            $width->setAttrib('min', $this->existing_data['minimum_width']);
        }
        $width->setDescription('Set the width for the form container, it
        can be no larger than the page block it sits in, the submitted value
        will be checked by the tool. The minimum width for the selected form 
        can be managed in the Form builder.');
        $width->setBelongsTo('params');
        $width->setValue($this->container['width']);

        $this->elements['width'] = $width;

        $padding = new Dlayer_Form_Element_Number('padding');
        $padding->setLabel('Padding');
        $padding->setAttribs(array('maxlength'=>3, 'class'=>'tinyint', 
        'min'=>0));
        $padding->setDescription('Set the padding for the form container, this 
        much space will be left around the outside of the form.');
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