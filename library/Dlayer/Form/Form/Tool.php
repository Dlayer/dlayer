<?php
/**
 * Base tool class for the Form builder, where possible all the tool forms extend this class and simply set the
 * user elements and titles etc
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
abstract class Dlayer_Form_Form_Tool extends Dlayer_Form
{
	protected $tool;
	protected $sub_tool;
	protected $field_type;
	protected $post_uri;
	protected $form_id;
	protected $field_data;
	protected $edit_mode;
	protected $multi_use;

	protected $label_add = 'Add';
	protected $label_edit = 'Edit';
	protected $legend_add = 'Add';
	protected $legend_edit = 'Save';

	protected $disable = FALSE;

	/**
	 * Set the properties for the form
	 *
	 * @param string $tool Tool name, will match database
	 * @param string $field_type Field type, will match database
	 * @param string $post_uri Uri to post form to
	 * @param integer $form_id Id of the form selected in Form builder
	 * @param array $field_data An array with a field for every element, the data will either be the current data if 	 * editing or FALSE if adding a new field
	 * @param boolean $edit_mode Are we in edit mode? Lets us see context for labels etc
	 * @param boolean $multi_use Is the tool or multi-use, if so tool stays selected after processing
	 * @param string|NULL$sub_tool Sub tool name, will match the database
	 * @param array|NULL $options Zend form options
	 */
	public function __construct($tool, $field_type, $post_uri, $form_id, array $field_data, $edit_mode=FALSE,
		$multi_use=TRUE, $sub_tool = NULL, $options=NULL)
	{
		$this->tool = $tool;
		$this->sub_tool = $sub_tool;
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

		$this->elementsData();

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
	 * Fetch any data required to create the form elements, for example the data for a select menu
	 *
	 * @return void
	 */
	protected function elementsData()
	{
		
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

		// Set sub tool
		if($this->sub_tool !== NULL)
		{
			$sub_tool_model = new Zend_Form_Element_Hidden('sub_tool_model');
			$sub_tool_model->setValue($this->sub_tool);

			$this->elements['sub_tool_model'] = $sub_tool_model;
		}

		if($this->field_type !== '')
		{
			$field_type = new Zend_Form_Element_Hidden('field_type');
			$field_type->setValue($this->field_type);

			$this->elements['field_type'] = $field_type;
		}

		// Edit for base tools
		if(array_key_exists('id', $this->field_data) === TRUE && $this->field_data['id'] != FALSE)
		{
			$field_id = new Zend_Form_Element_Hidden('field_id');
			$field_id->setValue($this->field_data['id']);

			$this->elements['field_id'] = $field_id;
		}

		// Sub tools
		if(array_key_exists('field_id', $this->field_data) === TRUE && $this->field_data['field_id'] != FALSE)
		{
			$field_id = new Zend_Form_Element_Hidden('field_id');
			$field_id->setValue($this->field_data['field_id']);

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
	abstract protected function addUserElements();

	/**
	 * Add the submit button to the form
	 *
	 * @return void The elements are written to the $this->elements private property
	 */
	protected function addSubmitElement()
	{
		$submit = new Zend_Form_Element_Submit('submit');
		$attributes = array('class'=>'btn btn-primary');
		if($this->disable === TRUE)
		{
			$attributes['disabled'] = 'disabled';
		}
		$submit->setAttribs($attributes);
		if($this->edit_mode == FALSE) 
		{
			$submit->setLabel($this->label_add);
		}
		else
		{
			$submit->setLabel($this->label_edit);
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
	 * Check field array for field value, either return assigned value or FALSE
	 * if field value not set in data array
	 *
	 * @param string $field
	 * @return string|FALSE
	 */
	protected function fieldValue($field)
	{
		if(array_key_exists($field, $this->field_data) == TRUE
			&& $this->field_data[$field] != FALSE) {
			return $this->field_data[$field];
		} else {
			return FALSE;
		}
	}

	/**
	 * Check field array for field attribute value, either return assigned
	 * attribute value or FALSE if field attribute value not set in data array
	 *
	 * @param string $attribute
	 * @return string|FALSE
	 */
	protected function fieldAttributeValue($attribute)
	{
		if(array_key_exists('attributes', $this->field_data) == TRUE
			&& array_key_exists($attribute, $this->field_data['attributes']) == TRUE
			&& $this->field_data['attributes'][$attribute] != FALSE) {
			return $this->field_data['attributes'][$attribute];
		} else {
			return FALSE;
		}
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
	 * Set the labels for the submit button
	 *
	 * @param string $add Label in add mode
	 * @param string $edit Label in edit mode
	 * @return void
	 */
	protected function setLabels($add='Add', $edit='Edit')
	{
		$this->label_add = $add;
		$this->label_edit = $edit;
	}

	/**
	 * Disable the tool, adds disabled class to the submit button
	 *
	 * @return void
	 */
	protected function disableTool()
	{
		$this->disable = TRUE;
	}
}
