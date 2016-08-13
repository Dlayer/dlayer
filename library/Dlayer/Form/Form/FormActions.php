<?php

/**
 * Form class for the actions tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Form_Form_FormActions extends Dlayer_Form_Form
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
	 * @param string|NULL $sub_tool Sub tool name, will match the database
	 * @param array|NULL $options Zend form options
	 */
	public function __construct($tool, $field_type, $post_uri, $form_id, array $field_data, $edit_mode = FALSE,
		$multi_use = TRUE, $sub_tool = NULL, $options = NULL)
	{
		$this->setTitles('Actions <small>Submission actions</small>', 'Actions <small>Submission actions</small>');

		$this->setLabels('Save', 'Save');

		$this->disableTool();

		parent::__construct($tool, $field_type, $post_uri, $form_id, $field_data, $edit_mode, $multi_use, $sub_tool,
			$options);
	}

	/**
	 * Set up the user elements, these are the elements that the user interacts with to use the tool
	 *
	 * @return void Writes the elements to the private $this->elements array
	 */
	protected function addUserElements()
	{
		$email = new Zend_Form_Element_Select('email');
		$email->setLabel('Email copy of submission');
		$email->setDescription('Would you like Dlayer to send you an email after each submission?');
		$email->addMultiOptions(
			array(1 => 'No thank you', 2 => 'Yes please'));
		$email->setRequired();
		$email->setAttrib('class', 'form-control input-sm');
		$email->setBelongsTo('params');

		$this->elements['email'] = $email;

		$save = new Zend_Form_Element_Select('save');
		$save->setLabel('Save submissions');
		$save->setDescription('Would you like Dlayer to save a copy of each submission in the database?');
		$save->addMultiOptions(
			array(1 => 'No thank you', 2 => 'Yes please'));
		$save->setRequired();
		$save->setAttrib('class', 'form-control input-sm');
		$save->setBelongsTo('params');

		$this->elements['save'] = $save;
	}

}
