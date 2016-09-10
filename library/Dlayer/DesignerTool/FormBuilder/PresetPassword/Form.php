<?php

/**
 * Form class for the preset password tool, allows the user to add a password field which is simply a password field with a few options preset, on edit it acts like a standard password field
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_PresetPassword_Form extends Dlayer_Form_Form
{
	/**
	 * Set the properties for the form
	 *
	 * @param string $tool Tool name, will match database
	 * @param string $field_type Field type, will match database
	 * @param string $post_uri Uri to post form to
	 * @param integer $form_id Id of the form selected in Form builder
	 * @param array $field_data An array with a field for every element, the data will either be the current data if editing or FALSE if adding a new field
	 * @param boolean $edit_mode Are we in edit mode? Lets us see context for labels etc
	 * @param boolean $multi_use Is the tool or multi-use, if so tool stays selected after processing
	 * @param string|NULL$sub_tool Sub tool name, will match the database
	 * @param array|NULL $options Zend form options
	 */
	public function __construct($tool, $field_type, $post_uri, $form_id, array $field_data, $edit_mode = FALSE,
		$multi_use = TRUE, $sub_tool = NULL, $options = NULL)
	{
		$this->setTitles('Add <small>Password field</small>');

		$this->setLabels('Add password field', 'Save');

		parent::__construct($tool, $field_type, $post_uri, $form_id, $field_data, $edit_mode, $multi_use, $sub_tool,
			$options);
	}

	/**
	 * Add the user facing elements to the form
	 *
	 * @return void The elements are written to the $this->elements private property
	 */
	protected function addUserElements()
	{
		$label = new Zend_Form_Element_Text('label');
		$label->setBelongsTo('params');
		$label->setAttribs(array('class' => 'form-control input-sm'));
		$label->setValue('Your password');

		$this->elements['label'] = $label;

		$description = new Zend_Form_Element_Textarea('description');
		$description->setBelongsTo('params');
		$description->setAttribs(array('class' => 'form-control input-sm', 'rows' => 5));
		$description->setValue('Please enter your password');

		$this->elements['description'] = $description;

		$placeholder = new Zend_Form_Element_Text('placeholder');
		$placeholder->setBelongsTo('params');
		$placeholder->setAttribs(array('class' => 'form-control input-sm'));
		$placeholder->setValue('******');

		$this->elements['placeholder'] = $placeholder;

		$size = new Dlayer_Form_Element_Number('size');
		$size->setValue(20);
		$size->setAttribs(array('class' => 'form-control input-sm'));
		$size->setBelongsTo('params');

		$this->elements['size'] = $size;

		$max_length = new Dlayer_Form_Element_Number('maxlength');
		$max_length->setValue(255);
		$max_length->setAttribs(array('class' => 'form-control input-sm'));
		$max_length->setBelongsTo('params');

		$this->elements['maxlength'] = $max_length;
	}
}
