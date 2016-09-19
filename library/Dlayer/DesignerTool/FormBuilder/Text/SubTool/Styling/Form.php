<?php

/**
 * Form class for the text/styling sub tool, allows the user to control the styling for the field and row
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_Text_SubTool_Styling_Form extends Dlayer_Form_Form
{
	/**
	 * Set the properties for the form
	 *
	 * @param string $tool Tool name, will match database
	 * @param string $field_type Field type, will match database
	 * @param string $post_uri Uri to post form to
	 * @param integer $form_id Id of the form selected in Form builder
	 * @param array $field_data An array with a field for every element, the data will either be the current data if
	 *     editing or FALSE if adding a new field
	 * @param boolean $edit_mode Are we in edit mode? Lets us see context for labels etc
	 * @param boolean $multi_use Is the tool or multi-use, if so tool stays selected after processing
	 * @param string|NULL $sub_tool Sub tool name, will match the database
	 * @param array|NULL $options Zend form options
	 */
	public function __construct($tool, $field_type, $post_uri, $form_id, array $field_data, $edit_mode = FALSE,
		$multi_use = TRUE, $sub_tool = NULL, $options = NULL)
	{
		$this->setTitles('', 'Styling <small>Field and row styling</small>');

		$this->setLabels('', 'Save');

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
		$background_color = new Dlayer_Form_Element_ColorPicker('background_color');
		$background_color->setLabel('Row background colour');
		$background_color->setDescription('Choose a background colour for the row, to clear the colour using the clear button.');
		$background_color->setBelongsTo('params');
		$background_color->addClearLink();
		$background_color->setRequired();
		if(array_key_exists('background_color', $this->field_data) === TRUE
			&& $this->field_data['background_color'] != FALSE
		)
		{
			$background_color->setValue($this->field_data['background_color']);
		}

		$this->elements['background_color'] = $background_color;
	}
}
