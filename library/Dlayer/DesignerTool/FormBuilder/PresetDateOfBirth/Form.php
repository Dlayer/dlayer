<?php

/**
 * Form for the preset date of birth 'date' element tool
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_PresetDateOfBirth_Form extends Dlayer_Form_Tool_Form
{
    /**
     * Set the properties for the form
     *
     * @param array $tool Tool and environment data array
     * @param array $data Current data for content item
     * @param array $element_data
     * @param array|NULL $options Zend form options
     */
    public function __construct(array $tool, array $data, array $element_data, $options=NULL)
    {
        $tool['name'] = 'Date';
        $this->field_type = 'Date';
        $this->preset = 1;

        parent::__construct($tool, $data, $element_data, $options);
    }

    /**
     * Initialise the form, sets the action and method and then calls the elements to build the form
     *
     * @return void
     */
    public function init()
    {
        $this->setAction('/form/process/tool');

        $this->setMethod('post');

        $this->generateFormElements();

        $this->addElementsToForm('date_of_birth', 'Date of Birth', $this->elements);

        $this->addDefaultElementDecorators();

        $this->addCustomElementDecorators();
    }

    protected function generateUserElements()
    {
        $label = new Zend_Form_Element_Hidden('label');
        $label->setDescription('Click <mark>save</mark> to quickly add a date of birth element to your form, all 
            the options and values have been preset for you, if necessary, you can alter them by editing the element.');
        $label->setBelongsTo('params');
        $label->setRequired();

        if (array_key_exists('label', $this->data) && $this->data['label'] !== false) {
            $label->setValue($this->data['label']);
        }

        $this->elements['label'] = $label;

        $description = new Zend_Form_Element_Hidden('description');
        $description->setBelongsTo('params');

        if (array_key_exists('description', $this->data) && $this->data['description'] !== false) {
            $description->setValue($this->data['description']);
        }

        $this->elements['description'] = $description;

        $placeholder = new Zend_Form_Element_Hidden('placeholder');
        $placeholder->setBelongsTo('params');

        if (array_key_exists('placeholder', $this->data) && $this->data['placeholder'] !== false) {
            $placeholder->setValue($this->data['placeholder']);
        }

        $this->elements['placeholder'] = $placeholder;

        $size = new Zend_Form_Element_Hidden('size');
        $size->setBelongsTo('params');
        $size->setValue(50);

        $this->elements['size'] = $size;

        $maxLength = new Zend_Form_Element_Hidden('maxlength');
        $maxLength->setBelongsTo('params');
        $maxLength->setValue(255);

        $this->elements['maxlength'] = $maxLength;
    }

    protected function addCustomElementDecorators()
    {
        parent::addCustomElementDecorators();

        $this->elements['label']->getDecorator('Description')->setOption('escape', false);
    }
}
