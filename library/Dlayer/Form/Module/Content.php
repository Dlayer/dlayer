<?php
/**
* Base form class for all the Content manager ribbon forms
*
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
abstract class Dlayer_Form_Module_Content extends Dlayer_Form
{
	protected $page_id;
	protected $div_id;
	protected $content_row_id;
	protected $content_row = array();
	protected $content_item = array();
	protected $edit_mode;
	protected $multi_use;

	/**
	* Data array for the elements, will be populated with the dynamic values 
	* required by certain form inputs, one example being select menus
	* 
	* @var mixed
	*/
	protected $elements_data;

	protected $tool;
	protected $content_type;
	protected $sub_tool_model;

	/**
	* Set the initial properties for the form
	* 
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @param array $content_row Details for the content row, used to preset 
	* 	certains values for the content item, for example which bootstrap 
	* 	column class to use
	* @param array $existing_data The existing data for the content item, 
	* 	array values will be FALSE in add mode, populated in edit mode
	* @param boolean $edit_mode Is the tool in edit mode
	* @param integer $multi_use The multi use value for the tool, either 1 or 0
	* @param array|NULL $options Zend form options data array
	* @return void
	*/
	public function __construct($page_id, $div_id, $content_row_id, 
		array $content_row, array $content_item, $edit_mode=FALSE, 
		$multi_use=0, $options=NULL)
	{
		$this->page_id = $page_id;
		$this->div_id = $div_id;
		$this->content_row_id = $content_row_id;
		$this->content_row = $content_row;
		$this->content_item = $content_item;
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
		$this->setDecorators(array(
			'FormElements', 
			array('Form', array('class'=>'form'))));

		$this->setElementDecorators(array(
			array('ViewHelper'), 
			array('Description', array('tag' => 'p', 'class'=>'help-block')),
			array('Errors', array('class'=> 'alert alert-danger')), 
			array('Label'), 
			array('HtmlTag', array(
				'tag' => 'div', 
				'class'=> array(
					'callback' => function($decorator) {
						if($decorator->getElement()->hasErrors()) {
							return 'form-group has-error';
						} else {
							return 'form-group';
						}
				})
			))
		));

		$this->setDisplayGroupDecorators(array(
			'FormElements',
			'Fieldset',
		));
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
			array('HtmlTag', array(
				'tag' => 'div', 
				'class'=>'form-group form-group-submit')
			)
		));
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