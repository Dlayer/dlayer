<?php

/**
 * Form for the import form tool
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Form_Form extends Dlayer_Form_Tool_Content
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
		$this->content_type = 'form';

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

		$this->addElementsToForm('form_content_item', 'Import form', $this->elements);

		$this->addDefaultElementDecorators();

		$this->addCustomElementDecorators();
	}

	protected function generateUserElements()
	{
		$form_id = new Zend_Form_Element_Select('form_id');
		$form_id->setLabel('Form');
		$form_id->setDescription("Choose the form you would like to import.");
		if(array_key_exists('forms', $this->element_data) && is_array($this->element_data['forms']) === TRUE)
		{
			$form_id->setMultiOptions($this->element_data['forms']);
		}
		else
		{
			$form_id->setMultiOptions(array());
		}
		$form_id->setAttribs(array('class'=>'form-control input-sm'));
		$form_id->setBelongsTo('params');
		$form_id->setRequired();

		if(array_key_exists('form_id', $this->data) === TRUE && $this->data['form_id'] !== FALSE)
		{
			$form_id->setValue($this->data['form_id']);
		}

		$this->elements['form_id'] = $form_id;
	}
}
