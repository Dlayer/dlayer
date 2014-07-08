<?php
/**
* Base form class for all the Content manager ribbon forms
*
* @author Dean Blackborough
* @copyright G3D Development Limited
* @version $Id: Content.php 1928 2014-06-12 13:53:38Z Dean.Blackborough $
*/
abstract class Dlayer_Form_Module_Content extends Dlayer_Form
{
	protected $page_id;
    protected $div_id;
    protected $container = array();
    protected $existing_data = array();
    protected $edit_mode;
    protected $multi_use;
    
    protected $elements_data;

    protected $tool;
    protected $content_type;
    protected $sub_tool_model;

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
        $this->page_id = $page_id;
        $this->div_id = $div_id;
        $this->container = $container;
        $this->existing_data = $existing_data;
        $this->edit_mode = $edit_mode;
        $this->multi_use = $multi_use;

        parent::__construct($options=NULL);
    }
    
    /**
    * Add the default decorators to use for the form inputs
    *
    * @return void
    */
    protected function addDefaultElementDecorators()
    {
        $this->setElementDecorators(array(array('ViewHelper',
        array('tag' => 'div', 'class'=>'input')), array('Description'),
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
    
    /**
    * Check exisiting data array for field value, either return assigned 
    * value or FALSE if field value not set in data array
    * 
    * @param string $field
    * @return string|FALSE
    */
    protected function existingDataValue($field) 
    {
		if(array_key_exists($field, $this->existing_data) == TRUE 
        && $this->existing_data[$field] != FALSE) {
        	return $this->existing_data[$field];
		} else {
			return FALSE;
		}
    }
}