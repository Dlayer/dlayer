<?php

/**
 * Form class for the textarea tool, allows the user to add a textarea
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Form_Form_Textarea extends Dlayer_Form_Form
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
		$this->setTitles('Add <small>Textarea</small>', 'Edit <small>Textarea</small>');

		$this->setLabels('Add textarea', 'Save');

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
		$label = new Zend_Form_Element_Text('label');
		$label->setLabel('Label');
		$label->setAttribs(array(
			'maxlength' => 255,
			'placeholder' => 'e.g., Comment',
			'class' => 'form-control input-sm',
		));
		$label->setDescription('Enter a label.');
		$label->setBelongsTo('params');
		$label->setRequired();

		$value = $this->fieldValue('label');
		if ($value != FALSE)
		{
			$label->setValue($value);
		}

		$this->elements['label'] = $label;

		$description = new Zend_Form_Element_Textarea('description');
		$description->setLabel('Description');
		$description->setAttribs(array(
			'rows' => 2, 'cols' => 30,
			'placeholder' => 'e.g., Please enter your comment',
			'class' => 'form-control input-sm',
		));
		$description->setDescription('Enter a description, if necessary give the user instructions.');
		$description->setBelongsTo('params');

		$value = $this->fieldValue('description');
		if ($value != FALSE)
		{
			$description->setValue($value);
		}

		$this->elements['description'] = $description;

		$placeholder = new Zend_Form_Element_Text('placeholder');
		$placeholder->setLabel('Placeholder text');
		$placeholder->setAttribs(array(
			'maxlength' => 255,
			'placeholder' => 'e.g., I love your app, thank you :)',
			'class' => 'form-control input-sm',
		));
		$placeholder->setDescription('Enter the help text, displays when the field is empty.');
		$placeholder->setBelongsTo('params');

		$value = $this->fieldAttributeValue('placeholder');
		if ($value != FALSE)
		{
			$placeholder->setValue($value);
		}

		$this->elements['placeholder'] = $placeholder;

		$cols = new Dlayer_Form_Element_Number('cols');
		$cols->setLabel('<span class="glyphicon glyphicon-plus toggle" id="fgc-cols" title="Expand for more" aria-hidden="true"></span> Display width');
		$cols->setValue(40);
		$cols->setAttribs(array(
			'maxlength' => 3, 'min' => 0,
			'class' => 'form-control input-sm',
		));
		$cols->setDescription('Visual size of the field, overridden by styling, legacy setting.');
		$cols->setBelongsTo('params');
		$cols->setRequired();

		$value = $this->fieldAttributeValue('cols');
		if ($value != FALSE)
		{
			$cols->setValue($value);
		}

		$this->elements['cols'] = $cols;

		$rows = new Dlayer_Form_Element_Number('rows');
		$rows->setLabel('<span class="glyphicon glyphicon-plus toggle" id="fgc-rows" title="Expand for more" aria-hidden="true"></span> Display rows');
		$rows->setValue(4);
		$rows->setAttribs(array(
			'maxlength' => 3, 'min' => 0,
			'class' => 'form-control input-sm',
		));
		$rows->setDescription('Number of lines of text before scroll bars appear, defaults to four.');
		$rows->setBelongsTo('params');
		$rows->setRequired();

		$value = $this->fieldAttributeValue('rows');
		if ($value != FALSE)
		{
			$rows->setValue($value);
		}

		$this->elements['rows'] = $rows;
	}

	/**
	 * Add any custom decorators, these are inputs where we need a little more control over the html,an example being the submit button
	 *
	 * @return void
	 */
	protected function addCustomElementDecorators()
	{
		parent::addCustomElementDecorators();

		$this->elements['cols']->setDecorators(
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

		$this->elements['rows']->setDecorators(
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
