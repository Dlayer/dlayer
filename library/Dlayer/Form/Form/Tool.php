<?php
/**
 * Base tool class for the Form builder, where possible all the tool forms extend this class and simply set the
 * user elements and titles etc
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Form_Form_Tool extends Dlayer_Form_Module_FormNew
{
	private $tool;
	private $field_type;
	private $post_uri;
	private $form_id;
	private $field_data;
	private $edit_mode;
	private $multi_use;

	private $legend_add;
	private $legend_edit;

	/**
	 * Set the properties for the form
	 *
	 * @param string $tool Tool name, will match database
	 * @param string $field_type Field type, will match database
	 * @param string $post_uri Uri to post form to
	 * @param integer $form_id Id of the form selected in Form builder
	 * @param array $field_data An array with a field for every element, the data will either be the current data if
	 * editing or FALSE if adding a new field
	 * @param boolean $edit_mode Are we in edit mode? Lets us see context for labels etc
	 * @param boolean $multi_use Is the tool or multi-use, if so tool stays selected after processing
	 * @param array|NULL $options Zend form options
	 */
	public function __construct($tool, $field_type, $post_uri, $form_id, array $field_data, $edit_mode=FALSE,
		$multi_use=TRUE, $options=NULL)
	{
		$this->tool = $tool;
		$this->field_type = $field_type;
		$this->post_uri = $post_uri;
		$this->form_id = $form_id;
		$this->field_data = $field_data;
		$this->edit_mode = $edit_mode;
		$this->multi_use = $multi_use;

		parent::__construct($options);
	}

	/**
	 * Initialise the form, calls all the methods to build the form
	 *
	 * @return void
	 */
	public function init()
	{
		$this->setAction($this->post_uri);

		$this->setMethod('post');

		$this->setUpFormElements();

		$this->validationRules();
		
		if($this->edit_mode == FALSE)
		{
			$legend = $this->legend_add;
		}
		else
		{
			$legend = $this->legend_edit;
		}

		$this->addElementsToForm($this->tool . '_tool', $legend, $this->elements);
			
		$this->addDefaultElementDecorators();

		$this->addCustomElementDecorators();
	}

	/**
	 * Set the titles for the form
	 *
	 * @param string $add Title for the add legend
	 * @param string $edit Title for the edit legend
	 * @return void
	 */
	protected function setTitles($add='Add', $edit='Edit')
	{
		$this->legend_add = $add;
		$this->legend_edit = $edit;
	}

	/**
	 * Set up all the form elements, the form elements are broken into three sections, the hidden tools elements that
	 * exists for each form, the user facing elements that are specific to the tool and then the submit button
	 *
	 * @return void
	 */
	protected function setUpFormElements()
	{
		$this->addToolElements();

		$this->addUserElements();

		$this->addSubmitElement();
	}

	/**
	 * Set up the tool elements, these are the elements that set the tool name and and the general processing data ,
	 * form id, whether the tool is in edit mode and then if the tool is a multi use tool
	 *
	 * @return void The elements are written to the $this->elements private property
	 */
	protected function addToolElements()
	{
		$form_id = new Zend_Form_Element_Hidden('form_id');
		$form_id->setValue($this->form_id);

		$this->elements['form_id'] = $form_id;

		$tool = new Zend_Form_Element_Hidden('tool');
		$tool->setValue($this->tool);

		$this->elements['tool'] = $tool;

		$field_type = new Zend_Form_Element_Hidden('field_type');
		$field_type->setValue($this->field_type);

		$this->elements['field_type'] = $field_type;

		if(array_key_exists('id', $this->field_data) == TRUE
			&& $this->field_data['id'] != FALSE) {
			$field_id = new Zend_Form_Element_Hidden('field_id');
			$field_id->setValue($this->field_data['id']);
			$this->elements['field_id'] = $field_id;
		}

		$multi_use = new Zend_Form_Element_Hidden('multi_use');
		$multi_use->setValue($this->multi_use);
		$multi_use->setBelongsTo('params');

		$this->elements['multi_use'] = $multi_use;
	}

	/**
	 * Add the user facing elements to the form
	 *
	 * @return void The elements are written to the $this->elements private property
	 */
	protected function addUserElements()
	{

	}

	/**
	 * Add the submit button to the form
	 *
	 * @return void The elements are written to the $this->elements private property
	 */
	protected function addSubmitElement()
	{
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('class', 'submit');
		$submit->setAttribs(array('class'=>'btn btn-primary'));
		if($this->edit_mode == FALSE) {
			$submit->setLabel('Add text field');
		} else {
			$submit->setLabel('Save changes');
		}

		$this->elements['submit'] = $submit;
	}

	/**
	 * Set any validation rules
	 *
	 * @return void
	 */
	protected function validationRules()
	{

	}

	/**
	 * Add any custom element decorators required for just this form
	 *
	 * @return void
	 */
	protected function addCustomElementDecorators()
	{
		parent::addCustomElementDecorators();
	}
}
