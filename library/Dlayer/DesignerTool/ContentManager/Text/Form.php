<?php

/**
 * Form for the text content item tool
 *
 * The form is used by the Text content item to allow a user to define or edit
 * a text content item, a text content item is essentially just a plain text
 * block. This form is also used by the edit version of the tool.
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Text_Form extends Dlayer_Form_Tool_Content
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
		$this->content_type = 'text';

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

		$this->addElementsToForm('text_content_item', 'Text', $this->elements);

		$this->addDefaultElementDecorators();

		$this->addCustomElementDecorators();
	}

	protected function generateUserElements()
	{
		$name = new Zend_Form_Element_Text('name');
		$name->setLabel('Name');
		$name->setAttribs(array('size'=>50, 'maxlength'=>255, 'placeholder'=>'e.g., Intro for contact page',
			'class'=>'form-control input-sm'));
		$name->setDescription('Give the content item a name, this will allow you to recreate it again later.');
		$name->setBelongsTo('params');
		$name->setRequired();

		if(array_key_exists('name', $this->data) === TRUE && $this->data['name'] !== FALSE)
		{
			$name->setValue($this->data['name']);
		}

		$this->elements['name'] = $name;

		if($this->tool['content_id'] !== NULL && $this->instances > 1)
		{
			$instances = new Zend_Form_Element_Select('instances');
			$instances->setLabel('Update shared content?');
			$instances->setDescription("The content below is used {$this->instances} times on your web site, do you 
				want to update the text for this content item only or all content items?");
			$instances->setMultiOptions(
				array(
					1 => 'Yes - update all content items',
					0 => 'No - Please only update this item'
				)
			);
			$instances->setAttribs(array('class' => 'form-control input-sm'));
			$instances->setBelongsTo('params');

			$this->elements['instances'] = $instances;
		}

		$content = new Zend_Form_Element_Textarea('content');
		$content->setLabel('Content');
		$content->setAttribs(array('cols'=>50, 'rows'=>15, 'placeholder'=>'e.g., The quick brown fox jumps jumps...',
			'class'=>'form-control input-sm'));
		$content->setDescription('Enter your content.');
		$content->setBelongsTo('params');
		$content->setRequired();

		if(array_key_exists('content', $this->data) === TRUE && $this->data['content'] !== FALSE)
		{
			$content->setValue($this->data['content']);
		}

		$this->elements['content'] = $content;
	}
}
