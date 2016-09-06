<?php

/**
 * Form for the import image tool
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Image_Form extends Dlayer_Form_Content
{
	/**
	 * Set the properties for the form
	 *
	 * @param array $tool Tool and environment data array
	 * @param array $data Current data for content item
	 * @param integer $instances Instances of content data on web site
	 * @param array $element_data
	 * @param array|NULL $options Zend form options
	 */
	public function __construct(array $tool, array $data, $instances, array $element_data, $options=NULL)
	{
		$this->content_type = 'image';

		parent::__construct($tool, $data, $instances, $element_data, $options);
	}

	/**
	 * Initialise the form, sets the action and method and then calls the elements to build the form
	 *
	 * @return void
	 */
	public function init()
	{
		$this->setAction('/content/process/tool');

		$this->setMethod('post');

		$this->generateFormElements();

		$this->addElementsToForm('image_content_item', 'Import image', $this->elements);

		$this->addDefaultElementDecorators();

		$this->addCustomElementDecorators();
	}

	protected function generateUserElements()
	{
		$version_id = new Dlayer_Form_Element_ImagePicker('version_id');
		$version_id->setLabel('Image');
		$version_id->setDescription("Choose the image you would like to import.");
		$version_id->setAttribs(array('class'=>'form-control input-sm'));
		$version_id->setBelongsTo('params');
		$version_id->setRequired();

		if(array_key_exists('version_id', $this->data) === TRUE && $this->data['version_id'] !== FALSE)
		{
			$version_id->setValue($this->data['version_id']);
		}

		$this->elements['version_id'] = $version_id;

		$expand = new Zend_Form_Element_Select('expand');
		$expand->setLabel('Expand?');
		$expand->setDescription('Do you want your viewers to be able to see an expanded version of your image?');
		$expand->setMultiOptions(
			array(
				0=>'No - Inline image only',
				1=>'Yes - Full size image displays in a dialog on click'
			)
		);
		$expand->setAttribs(array('class'=>'form-control input-sm'));
		$expand->setBelongsTo('params');
		$expand->setRequired();

		if(array_key_exists('expand', $this->data) === TRUE && $this->data['expand'] !== FALSE)
		{

			$expand->setValue($this->data['expand']);
		}

		$this->elements['expand'] = $expand;

		$caption = new Zend_Form_Element_Textarea('caption');
		$caption->setLabel('Caption');
		$caption->setAttribs(array('cols'=>50, 'rows'=>5, 'placeholder'=>'e.g., Caption explaining image...',
			'class'=>'form-control input-sm'));
		$caption->setDescription('Enter an optional caption which will appear below your image.');
		$caption->setBelongsTo('params');

		if(array_key_exists('caption', $this->data) === TRUE && $this->data['caption'] !== FALSE)
		{

			$caption->setValue($this->data['caption']);
		}

		$this->elements['caption'] = $caption;
	}
}
