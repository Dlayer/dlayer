<?php

/**
 * Form to set the text for the submit button and option set a reset button
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_Button_Form extends Dlayer_Form_Tool_Form
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

        $this->addElementsToForm('buttons', 'Buttons', $this->elements);

        $this->addDefaultElementDecorators();

        $this->addCustomElementDecorators();
    }

    protected function generateUserElements()
    {
        $submit_label = new Zend_Form_Element_Text('submit_label');
        $submit_label->setLabel('Submit button label');
        $submit_label->setDescription('Enter the label for the submit button.');
        $submit_label->setAttribs(
            array(
                'maxlength'=>255,
                'placeholder' => 'e.g., Send',
                'class'=>'form-control input-sm'
            )
        );
        $submit_label->setBelongsTo('params');
        $submit_label->setRequired();

        if (array_key_exists('submit_label', $this->data) && $this->data['submit_label'] !== false) {
            $submit_label->setValue($this->data['submit_label']);
        }

        $this->elements['submit_label'] = $submit_label;

        $reset_label = new Zend_Form_Element_Text('reset_label');
        $reset_label->setLabel('Reset button label');
        $reset_label->setDescription('Enter the optional label for the reset button, if not set the 
            reset button will not be added to your form.');
        $reset_label->setAttribs(
            array(
                'maxlength'=>255,
                'placeholder' => 'e.g., Reset',
                'class'=>'form-control input-sm'
            )
        );
        $reset_label->setBelongsTo('params');

        if (array_key_exists('reset_label', $this->data) && $this->data['reset_label'] !== false) {
            $reset_label->setValue($this->data['reset_label']);
        }

        $this->elements['reset_label'] = $reset_label;
    }
}
