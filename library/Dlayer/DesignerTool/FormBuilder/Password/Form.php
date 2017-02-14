<?php

/**
 * Form for the password element tool, used by the add and edit actions
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_Password_Form extends Dlayer_Form_Tool_Form
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
        $this->field_type = 'Password';

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

        $this->addElementsToForm('password', 'Password element', $this->elements);

        $this->addDefaultElementDecorators();

        $this->addCustomElementDecorators();
    }

    protected function generateUserElements()
    {
        $label = new Zend_Form_Element_Text('label');
        $label->setLabel('Label');
        $label->setAttribs(
            array(
                'maxlength'=>255,
                'placeholder'=>'e.g., Enter password',
                'class'=>'form-control input-sm'
            )
        );
        $label->setDescription('Please enter the label for the password element');
        $label->setBelongsTo('params');
        $label->setRequired();

        if (array_key_exists('label', $this->data) && $this->data['label'] !== false) {
            $label->setValue($this->data['label']);
        }

        $this->elements['label'] = $label;

        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('Description');
        $description->setAttribs(
            array(
                'rows'=>2,
                'cols'=>30,
                'placeholder'=>'e.g., Please enter your password',
                'class'=>'form-control input-sm'
            )
        );
        $description->setDescription('Please enter a description, this should indicate to the user what you are 
            expecting, for example, their password');
        $description->setBelongsTo('params');

        if (array_key_exists('description', $this->data) && $this->data['description'] !== false) {
            $description->setValue($this->data['description']);
        }

        $this->elements['description'] = $description;

        $size = new Zend_Form_Element_Hidden('size');
        $size->setBelongsTo('params');
        $size->setValue(50);

        $this->elements['size'] = $size;

        $maxLength = new Zend_Form_Element_Hidden('maxlength');
        $maxLength->setBelongsTo('params');
        $maxLength->setValue(255);

        $this->elements['maxlength'] = $maxLength;
    }
}
