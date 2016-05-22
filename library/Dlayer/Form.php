<?php
/**
 * Base form class for Dlayer
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
abstract class Dlayer_Form extends Zend_Form
{
	/**
	 * @var array Form elements array
	 */
	protected $elements = array();

	/**
	 * @var array Data for form elements
	 */
	protected $elementsData = array();

	/**
	 * Dlayer_Form constructor. Pass in anything needed to set up the form and set options
	 *
	 * @param array|NULL $options
	 * @return void
	 */
	public function __construct($options=NULL)
	{
		parent::__construct($options=NULL);
	}

	/**
	 * Create the form elements and assign them to $this->elements, array will be passed to
	 * Dlayer_Form::addElementsToForm()
	 *
	 * @return void
	 */
	abstract protected function setUpFormElements();

	/**
	 * Add validation rules
	 *
	 * @return void
	 */
	abstract protected function validationRules();

	/**
	 * Add the default element decorators
	 *
	 * @return void
	 */
	abstract protected function addDefaultElementDecorators();

	/**
	 * Add any custom element decorators
	 *
	 * @return void
	 */
	abstract protected function addCustomElementDecorators();

	/**
	 * Fetch the data for the form elements if in edit mode, also responsible for fetching the data for dynamic
	 * elements like select menus and radio boxes
	 *
	 * @return void
	 */
	abstract protected function elementsData();

	/**
	 * Assign the elements to the form, calls Zend_Form::addElements and Zend_Form::addDisplayGroup
	 *
	 * @param string $id Id for fieldset
	 * @param string $label Legend for fieldset
	 * @param array $elements The elements top assign
	 * @throws Zend_Form_Exception
	 */
	protected function addElementsToForm($id, $label, array $elements) 
	{
		$this->addElements($elements);

		$this->addDisplayGroup($elements, $id, array('legend'=>$label, 'escape'=>false));
	}
}
