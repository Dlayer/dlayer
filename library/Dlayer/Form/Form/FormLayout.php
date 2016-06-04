<?php

/**
 * Form class for the layout tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Form_Form_FormLayout extends Dlayer_Form_Form_Tool
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
		$this->setTitles('Layout <small>Change how form looks</small>', 'Layout <small>Change how form looks</small>');

		$this->setLabels('Save', 'Save');

		parent::__construct($tool, $field_type, $post_uri, $form_id, $field_data, $edit_mode, $multi_use, $sub_tool,
			$options);
	}

	/**
	 * Fetch any data required to create the form elements, for example the data for a select menu
	 *
	 * @return void
	 */
	protected function elementsData()
	{
		$model_layout = new Dlayer_Model_Form_Layout();
		$this->elements_data['layout_options'] = $model_layout->layoutOptions();
	}

	/**
	 * Set up the user elements, these are the elements that the user interacts with to use the tool
	 *
	 * @return void Writes the elements to the private $this->elements array
	 */
	protected function addUserElements()
	{
		$title = new Zend_Form_Element_Text('title');
		$title->setLabel('Title');
		$title->setDescription('Enter the  title for the form.');
		$title->setAttribs(array(
			'maxlength' => 255, 'size' => 50,
			'class' => 'form-control input-sm',
		));
		$title->setValue($this->field_data['title']);
		$title->setBelongsTo('params');
		$title->setRequired();

		$this->elements['title'] = $title;

		$sub_title = new Zend_Form_Element_Text('sub_title');
		$sub_title->setLabel('Sub title');
		$sub_title->setDescription('Enter an optional sub title.');
		$sub_title->setAttribs(array(
			'maxlength' => 255, 'size' => 50,
			'class' => 'form-control input-sm',
		));
		$sub_title->setValue($this->field_data['sub_title']);
		$sub_title->setBelongsTo('params');

		$this->elements['sub_title'] = $sub_title;

		$submit_label = new Zend_Form_Element_Text('submit_label');
		$submit_label->setLabel('Button label');
		$submit_label->setDescription("Enter the text for the submit button.");
		$submit_label->setAttribs(array(
			'maxlength' => 255, 'size' => 50,
			'class' => 'form-control input-sm',
		));
		$submit_label->setValue($this->field_data['submit_label']);
		$submit_label->setBelongsTo('params');
		$submit_label->setRequired();

		$this->elements['submit_label'] = $submit_label;

		$reset_label = new Zend_Form_Element_Text('reset_label');
		$reset_label->setLabel('Reset label');
		$reset_label->setDescription("Enter the text for the reset blank or leave blank if you dont require a reset button.");
		$reset_label->setAttribs(array(
			'maxlength' => 255, 'size' => 50,
			'class' => 'form-control input-sm',
		));
		$reset_label->setValue($this->field_data['reset_label']);
		$reset_label->setBelongsTo('params');

		$this->elements['reset_label'] = $reset_label;

		$layout_option = new Zend_Form_Element_Select('layout_id');
		$layout_option->setLabel('Layout option');
		$layout_option->setDescription('Select the layout option for your form, standard, horizontal or inline.');
		$layout_option->addMultiOptions($this->elements_data['layout_options']);
		$layout_option->setRequired();
		$layout_option->setAttrib('class', 'form-control input-sm');
		$layout_option->setValue($this->field_data['layout_id']);
		$layout_option->setBelongsTo('params');

		$this->elements['layout_id'] = $layout_option;

		$horizontal_width_label = new Dlayer_Form_Element_Number(
			'horizontal_width_label');
		$horizontal_width_label->setAttribs(array(
			'max' => 12, 'min' => 1,
			'class' => 'form-control input-sm',
		));
		$horizontal_width_label->setLabel('<span class="glyphicon glyphicon-plus toggle" id="fgc-horizontal_width_label" title="Expand for more" aria-hidden="true"></span> Label width (Horizontal mode)');
		$horizontal_width_label->setDescription('Set the width of the label when using the horizontal layout option, should be a value between one and 12');
		$horizontal_width_label->setBelongsTo('params');
		$horizontal_width_label->setValue(
			$this->field_data['horizontal_width_label']);

		$this->elements['horizontal_width_label'] = $horizontal_width_label;

		$horizontal_width_field = new Dlayer_Form_Element_Number(
			'horizontal_width_field');
		$horizontal_width_field->setAttribs(array(
			'max' => 12, 'min' => 1,
			'class' => 'form-control input-sm',
		));
		$horizontal_width_field->setLabel('<span class="glyphicon glyphicon-plus toggle" id="fgc-horizontal_width_field" title="Expand for more" aria-hidden="true"></span> Field width (Horizontal mode)');
		$horizontal_width_field->setDescription('Set the width of the field when using the horizontal layout option, should be a value between one and 12');
		$horizontal_width_field->setBelongsTo('params');
		$horizontal_width_field->setValue(
			$this->field_data['horizontal_width_field']);

		$this->elements['horizontal_width_field'] = $horizontal_width_field;
	}

	/**
	 * Add any custom decorators, these are inputs where we need a little more
	 * control over the html, an example being the submit button
	 *
	 * @return void
	 */
	protected function addCustomElementDecorators()
	{
		parent::addCustomElementDecorators();

		$this->elements['horizontal_width_label']->setDecorators(
			array(
				array('ViewHelper'),
				array('Description', array('tag' => 'p', 'class' => 'help-block')),
				array('Errors', array('class' => 'alert alert-danger')),
				array('Label', array('escape' => FALSE)),
				array(
					'HtmlTag', array(
					'tag' => 'div',
					'class' => array(
						'callback' => function ($decorator)
						{
							if ($decorator->getElement()->hasErrors())
							{
								return 'form-group has-error';
							}
							else
							{
								return 'form-group form-group-collapsed';
							}
						},
					),
				),
				),
			)
		);

		$this->elements['horizontal_width_field']->setDecorators(
			array(
				array('ViewHelper'),
				array('Description', array('tag' => 'p', 'class' => 'help-block')),
				array('Errors', array('class' => 'alert alert-danger')),
				array('Label', array('escape' => FALSE)),
				array(
					'HtmlTag', array(
					'tag' => 'div',
					'class' => array(
						'callback' => function ($decorator)
						{
							if ($decorator->getElement()->hasErrors())
							{
								return 'form-group has-error';
							}
							else
							{
								return 'form-group form-group-collapsed';
							}
						},
					),
				),
				),
			)
		);
	}
}
