<?php
/**
* Base form class for all the image library ribbon forms
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
abstract class Dlayer_Form_Module_Image extends Dlayer_Form
{
    protected $existing_data = array();
    protected $edit_mode;
    protected $multi_use;
    
    /**
    * @var array Data array for any data that needs to be passed to form 
    *            fields, an example being select options
    */
    protected $elements_data;

    protected $tool;

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
    public function __construct(array $existing_data, $edit_mode=FALSE, 
    $multi_use, $options=NULL)
    {
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
}