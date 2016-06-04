<?php
/**
 * Form class for the preset name tool, allows the user to add a name field which is simply a text field with a few
 * options preset, once added it behaves as a text field
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Form_Form_PresetEmail extends Dlayer_Form_Form_Tool
{
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
	 * @param array|NULL $options Zend form options
	 */
	public function __construct($tool, $field_type, $post_uri, $form_id, array $field_data, $edit_mode=FALSE,
		$multi_use=TRUE, $options=NULL)
	{
		$this->setTitles('Add <small>Email field</small>');

		$this->setLabels('Add email field', 'Save');

		parent::__construct($tool, $field_type, $post_uri, $form_id, $field_data, $edit_mode, $multi_use, $options);
	}

	/**
	 * Add the user facing elements to the form
	 *
	 * @return void The elements are written to the $this->elements private property
	 */
	protected function addUserElements()
	{
		$label = new Zend_Form_Element_Text('label');
		$label->setLabel('Label');
		$label->setAttribs(array('maxlength'=>255, 'placeholder'=>'Your email', 'class'=>'form-control input-sm'));
		$label->setDescription("Enter the label for the email field, defaults to 'Your email'.");
		$label->setBelongsTo('params');
		$label->setValue('Your email');

		$this->elements['label'] = $label;

		$description = new Zend_Form_Element_Textarea('description');
		$description->setLabel('Description');
		$description->setAttribs(array('rows'=>2, 'cols'=>30, 'placeholder'=>'Please enter your email',
			'class'=>'form-control input-sm'));
		$description->setDescription("Enter the description for the email field, defaults to 'Please enter your email address'.");
		$description->setBelongsTo('params');
		$description->setValue('Please enter your email address');

		$this->elements['description'] = $description;

		$placeholder = new Zend_Form_Element_Text('placeholder');
		$placeholder->setLabel('Placeholder text');
		$placeholder->setAttribs(array('maxlength'=>255, 'placeholder'=>'Enter your email',
			'class'=>'form-control input-sm'));
		$placeholder->setDescription("Set the help text to display for the email field, defaults to 'Enter you email'.");
		$placeholder->setBelongsTo('params');
		$placeholder->setValue('Enter your email');

		$this->elements['placeholder'] = $placeholder;

		$size = new Dlayer_Form_Element_Number('size');
		$size->setLabel('Size');
		$size->setValue(40);
		$size->setAttribs(array('maxlength'=>3, 'min'=>0, 'class'=>'form-control input-sm'));
		$size->setDescription('Set the size of the email field in characters, defaults to 40 characters.');
		$size->setBelongsTo('params');

		$this->elements['size'] = $size;

		$maxlength = new Dlayer_Form_Element_Number('maxlength');
		$maxlength->setLabel('Max length');
		$maxlength->setValue(255);
		$maxlength->setAttribs(array('maxlength'=>3, 'min'=>0, 'class'=>'form-control input-sm'));
		$maxlength->setDescription('Set the maximum number of characters that can be entered into the email field, defaults to 255 characters.');
		$maxlength->setBelongsTo('params');

		$this->elements['maxlength'] = $maxlength;
	}
}
