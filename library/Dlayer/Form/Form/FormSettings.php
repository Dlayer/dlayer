<?php

/**
 * Form class for the setting tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Form_Form_FormSettings extends Dlayer_Form_Form
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
		$this->setTitles('Options', 'Options');

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
		$http = new Zend_Form_Element_Select('http');
		$http->setLabel('Method');
		$http->setDescription('Set the HTTP method to use for form submission, unless building a widget leave at POST.');
		$http->addMultiOptions(
			array(1 => 'POST', 2 => 'GET'));
		$http->setRequired();
		$http->setAttrib('class', 'form-control input-sm');
		$http->setBelongsTo('params');

		$this->elements['http'] = $http;

		$url = new Zend_Form_Element_Text('url');
		$url->setLabel('Custom URL');
		$url->setAttribs(array(
			'maxlength' => 255,
			'placeholder' => 'e.g., https://your-url/handler',
			'class' => 'form-control input-sm',
		));
		$url->setDescription('Set a custom URL to submit the form to, leave blank to let Dlayer handle the submissions.');
		$url->setBelongsTo('params');
		$url->setRequired();

		$this->elements['url'] = $url;

		$lock = new Zend_Form_Element_Select('lock');
		$lock->setLabel('Lock form?');
		$lock->setDescription('If the form is locked it cannot be changed in anyway.');
		$lock->addMultiOptions(
			array(1 => 'Unlock', 2 => 'Lock'));
		$lock->setRequired();
		$lock->setAttrib('class', 'form-control input-sm');
		$lock->setBelongsTo('params');

		$this->elements['lock'] = $lock;
	}
}
