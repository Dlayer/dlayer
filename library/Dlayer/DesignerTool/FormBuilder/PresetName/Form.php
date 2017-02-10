<?php

/**
 * Form for the name preset tool
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_PresetName_Form extends Dlayer_Form_Tool_Form
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
        $tool['name'] = 'Text'; // Override the tool
        $this->field_type = 'Text';
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

        $this->addElementsToForm('name', 'Name element', $this->elements);

        $this->addDefaultElementDecorators();

        $this->addCustomElementDecorators();
    }

    protected function generateUserElements()
    {
        $label = new Zend_Form_Element_Hidden('label');
        $label->setBelongsTo('params');
        $label->setDescription('Click <mark>save</mark> to quickly add a name element to your form, all 
            the options and values have been preset for you, if necessary, you can alter them by editing the element.');
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

        $placeHolder = new Zend_Form_Element_Hidden('placeholder');
        $placeHolder->setBelongsTo('params');
        if (array_key_exists('placeholder', $this->data) && $this->data['placeholder'] !== false) {
            $placeHolder->setValue($this->data['placeholder']);
        }

        $this->elements['placeholder'] = $placeHolder;

        $size = new Zend_Form_Element_Hidden('size');
        $size->setBelongsTo('params');
        if (array_key_exists('size', $this->data) && $this->data['size'] !== false) {
            $size->setValue($this->data['size']);
        }

        $this->elements['size'] = $size;

        $maxLength = new Zend_Form_Element_Hidden('maxlength');
        $maxLength->setBelongsTo('params');
        if (array_key_exists('maxlength', $this->data) && $this->data['maxlength'] !== false) {
            $maxLength->setValue($this->data['maxlength']);
        }

        $this->elements['maxlength'] = $maxLength;
    }

    protected function addCustomElementDecorators()
    {
        parent::addCustomElementDecorators();

        $this->elements['label']->getDecorator('Description')->setOption('escape', false);
    }
}
