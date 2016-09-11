<?php

/**
 * Form for the jumbotron content item tool
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Jumbotron_Form extends Dlayer_Form_Content
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
		$this->content_type = 'jumbotron';

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

		$this->addElementsToForm('jumbotron_content_item', 'Jumbotron', $this->elements);

		$this->addDefaultElementDecorators();

		$this->addCustomElementDecorators();
	}

	protected function generateUserElements()
	{
		$name = new Zend_Form_Element_Text('name');
		$name->setLabel('Name');
		$name->setAttribs(array('size'=>50, 'maxlength'=>255, 'placeholder'=>'e.g., Site masthead',
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

		$title = new Zend_Form_Element_Text('title');
		$title->setLabel('Title');
		$title->setAttribs(array('size'=>50, 'maxlength'=>255, 'placeholder'=>'e.g., Welcome to my site',
			'class'=>'form-control input-sm'));
		$title->setDescription('Enter the title for the Jumbotron.');
		$title->setBelongsTo('params');
		$title->setRequired();

		if(array_key_exists('title', $this->data) === TRUE && $this->data['title'] !== FALSE)
		{
			$title->setValue($this->data['title']);
		}

		$this->elements['title'] = $title;

		$intro = new Zend_Form_Element_Textarea('intro');
		$intro->setLabel('Introduction');
		$intro->setAttribs(array('cols'=>50, 'rows'=>3, 'placeholder'=>'e.g., Below you will find an overview of all the services...', 'class'=>'form-control input-sm'));
		$intro->setDescription('Enter the introduction.');
		$intro->setBelongsTo('params');
		$intro->setRequired();

		if(array_key_exists('intro', $this->data) === TRUE && $this->data['intro'] !== FALSE)
		{
			$intro->setValue($this->data['intro']);
		}

		$this->elements['intro'] = $intro;

		$button_label = new Zend_Form_Element_Text('button_label');
		$button_label->setLabel('Button label');
		$button_label->setAttribs(array('cols'=>50, 'row'=>15, 'placeholder'=>'e.g., Learn more',
			'class'=>'form-control input-sm'));
		$button_label->setDescription('Set the label for the optional button.');
		$button_label->setBelongsTo('params');

		if(array_key_exists('button_label', $this->data) === TRUE && $this->data['button_label'] !== FALSE)
		{
			$button_label->setValue($this->data['button_label']);
		}

		$this->elements['button_label'] = $button_label;
	}
}
