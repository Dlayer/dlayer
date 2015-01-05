<?php
/**
* Heading settings form, allows the user to define the styling for each of the 
* html heading types, H1 through H7
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
* @version $Id: Heading.php 1724 2014-04-13 15:12:59Z Dean.Blackborough $
*/
class Dlayer_Form_Settings_Content_Heading extends Dlayer_Form_Module_App 
{
	private $heading;
	private $data;

	/**
	* Pass in any values that are needed to set up the form
	* 
	* @param array $heading Heading data array, include name, id and current 
	*                       values for the site being edited
	* @param array|NULL Options for form
	* @return void
	*/
	public function __construct(array $heading, $options=NULL)
	{
		$this->heading = $heading;

		parent::__construct($options=NULL);
	}

	/**
	* Initialise the form, sets the url and submit method and then calls 
	* the methods that set up the form itself
	* 
	* @return void
	*/
	public function init() 
	{        
		$this->setAction('/content/settings/headings');

		$this->setMethod('post');

		$this->formElementsData();

		$this->setUpFormElements();

		$this->validationRules();

		$this->addElementsToForm('heading', $this->heading['name'], 
			$this->elements);

		$this->addDefaultElementDecorators();

		$this->addCustomElementDecorators();
	}

	/**
	* Fetch the data for the form select menus
	* 
	* @return void Writes the data to the private $this->data array
	*/
	private function formElementsData() 
	{
		$model_settings = new Dlayer_Model_Settings();

		$styles = array();
		$weights = array();
		$decorations = array();

		foreach($model_settings->fontStyles() as $k=>$values) {
			$styles[$k] = $values['name'];
		}
		foreach($model_settings->fontWeights() as $k=>$values) {
			$weights[$k] = $values['name'];
		}
		foreach($model_settings->fontDecorations() as $k=>$values) {
			$decorations[$k] = $values['name'];
		}

		$this->data['styles'] = $styles;
		$this->data['weights'] = $weights;
		$this->data['decorations'] = $decorations;
	}

	/** 
	* Set up the form elements needed for this form
	* 
	* @return void Form elements are written to the private $this->elements 
	*              property
	*/
	protected function setUpFormElements() 
	{
		$heading_id = new Zend_Form_Element_Hidden('heading_id');
		$heading_id->setValue($this->heading['id']);
		$this->elements['heading_id'] = $heading_id;

		$style = new Zend_Form_Element_Select('style');
		$style->setLabel('Font style');
		$style->setMultiOptions($this->data['styles']);
		$style->setValue($this->heading['style_id']);
		$style->setAttribs(array('id'=>'style_id_' . $this->heading['id'], 
			'class'=>'font_styles form-control'));
		$this->elements['style'] = $style;

		$weight = new Zend_Form_Element_Select('weight');
		$weight->setLabel('Font weight');
		$weight->setMultiOptions($this->data['weights']);
		$weight->setValue($this->heading['weight_id']);
		$weight->setAttribs(array('id'=>'weight_id_' . $this->heading['id'], 
			'class'=>'font_weights form-control'));
		$this->elements['weight'] = $weight;

		$decoration = new Zend_Form_Element_Select('decoration');
		$decoration->setLabel('Decoration');
		$decoration->setMultiOptions($this->data['decorations']);
		$decoration->setValue($this->heading['decoration_id']);
		$decoration->setAttribs(array('id'=>'decoration_id_' . 
			$this->heading['id'], 'class'=>'font_decorations form-control'));
		$this->elements['decoration'] = $decoration;

		$size = new Dlayer_Form_Element_Number('size');
		$size->setLabel('Font size (px)');
		$size->setRequired();
		$size->setValue($this->heading['size']);
		$size->setAttribs(array('maxlength'=>2, 
			'id'=>'size_' . $this->heading['id'], 
			'class'=>'font_sizes form-control', 
			'min'=>10));
		$size->addValidator(new Dlayer_Validate_FontSize());
		$this->elements['size'] = $size;

		$color_hex = new Dlayer_Form_Element_Color('color_hex');
		$color_hex->setLabel('Font color');
		$color_hex->setAttribs(array('maxlength'=>7, 
			'class'=>'font_colors color form-control', 
			'id'=>'color_hex_' . $this->heading['id']));
		$color_hex->setRequired();
		$color_hex->setValue($this->heading['color_hex']);
		$color_hex->addValidator(new Dlayer_Validate_ColorHex());
		$this->elements['color_hex'] = $color_hex;

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Save');
		$submit->setAttribs(array('class'=>'btn btn-primary'));
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
		//$this->elements['test']->addValidator(new Zend_Validate_Alpha());
	}

	/**
	* Add any custom decorators, these are inputs where we need a little more 
	* control over the html, an example being the submit button
	* 
	* @return void
	*/
	protected function addCustomElementDecorators() 
	{
		$this->elements['heading_id']->setDecorators(array(array('ViewHelper'),
			array('HtmlTag', array('tag' => 'div', 'class'=>'hidden'))));

		parent::addCustomElementDecorators();
	}
}