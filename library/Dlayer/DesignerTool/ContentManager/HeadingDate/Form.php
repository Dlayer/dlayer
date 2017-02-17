
<?php

/**
 * Form for the Heading & Date content item tool
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_HeadingDate_Form extends Dlayer_Form_Tool_Content
{
    /**
     * Set the properties for the form
     *
     * @param array $tool Tool and environment data array
     * @param array $data Current data for content item
     * @param integer $instances Instances of content data on web site
     * @param array $element_data Data array containing data for elements (Select menu etc.)
     * @param array|NULL $options Zend form options
     */
    public function __construct(array $tool, array $data, $instances, array $element_data, $options=NULL)
    {
        $this->content_type = 'heading-date';

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

        $this->addElementsToForm('heading_date_content_item', 'Heading & Date', $this->elements);

        $this->addDefaultElementDecorators();

        $this->addCustomElementDecorators();
    }

    protected function generateUserElements()
    {
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Name');
        $name->setAttribs(array('size'=>50, 'maxlength'=>255, 'placeholder'=>'e.g., Page title',
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
            $instances->setDescription("The content below is used {$this->instances} times* on your web site, do you 
				want to update the text for this heading only or all headings?");
            $instances->setMultiOptions(
                array(
                    1 => 'Yes - update all headings',
                    0 => 'No - Please only update this heading'
                )
            );
            $instances->setAttribs(array('class' => 'form-control input-sm'));
            $instances->setBelongsTo('params');

            $this->elements['instances'] = $instances;
        }

        $heading = new Zend_Form_Element_Textarea('heading');
        $heading->setLabel('Heading');
        $heading->setAttribs(array('cols'=>50, 'rows'=>2, 'placeholder'=>'e.g., Our projects',
            'class'=>'form-control input-sm'));
        $heading->setDescription('Enter your heading.');
        $heading->setBelongsTo('params');
        $heading->setRequired();

        if(array_key_exists('heading', $this->data) === TRUE && $this->data['heading'] !== FALSE)
        {
            $heading->setValue($this->data['heading']);
        }

        $this->elements['heading'] = $heading;

        $heading_type = new Zend_Form_Element_Select('type');
        $heading_type->setLabel('Heading type');
        if(array_key_exists('type', $this->element_data) && is_array($this->element_data['type']) === true) {
            $heading_type->setMultiOptions($this->element_data['type']);
        } else {
            $heading_type->setMultiOptions(array());
        }
        $heading_type->setDescription('Choose a heading type.');
        $heading_type->setAttribs(array('class'=>'form-control input-sm'));
        $heading_type->setBelongsTo('params');
        $heading_type->setRequired();

        if(array_key_exists('type', $this->data) === true && $this->data['type'] !== FALSE) {
            $heading_type->setValue($this->data['type']);
        }

        $this->elements['type'] = $heading_type;

        $date = new Dlayer_Form_Element_Date('date');
        $date->setLabel('Date');
        $date->setAttribs(
            array(
                'placeholder'=>'dd-mm-yyyy',
                'class'=>'form-control input-sm'
            )
        );
        $date->setDescription('Enter the date for your heading.');
        $date->setBelongsTo('params');
        $date->setRequired();

        if(array_key_exists('date', $this->data) === true && $this->data['date'] !== false) {
            $date->setValue($this->data['date']);
        }

        $this->elements['date'] = $date;

        $format = new Zend_Form_Element_Select('format');
        $format->setLabel('Date format');
        $format->setAttribs(
            array(
                'class'=>'form-control input-sm'
            )
        );
        $format->setDescription('Choose the format for the date.');
        $format->setBelongsTo('params');
        $format->setRequired();

        if (array_key_exists('format', $this->element_data) === true && is_array($this->element_data['format']) === true) {
            $format->setMultiOptions($this->element_data['format']);
        } else {
            $format->setMultiOptions(array());
        }

        if(array_key_exists('format', $this->data) === true && $this->data['format'] !== false) {
            $format->setValue($this->data['format']);
        }

        $this->elements['format'] = $format;
    }
}
