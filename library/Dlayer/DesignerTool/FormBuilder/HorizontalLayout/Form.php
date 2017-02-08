<?php

/**
 * Horizontal layout
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_HorizontalLayout_Form extends Dlayer_Form_Tool_Form
{
    /**
     * Set the properties for the form
     *
     * @param array $tool Tool and environment data array
     * @param array $data Current data for element
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
        $this->setAction('/form/process/tool-auto');

        $this->setMethod('post');

        $this->generateFormElements();

        $this->addElementsToForm('layout', 'Horizontal layout', $this->elements);

        $this->addDefaultElementDecorators();

        $this->addCustomElementDecorators();
    }

    protected function generateUserElements()
    {
        $horizontal = new Zend_Form_Element_Hidden('horizontal');
        $horizontal->setBelongsTo('params');
        $horizontal->setDescription('Enable the horizontal layout for this form; labels and elemenets 
            will appear on the same row using the width values defined below:');
        if ($this->element_data['layout'] !== false) {
            $horizontal->setValue($this->element_data['layout']);
        } // Will have null value if layout index false, won't pass validation

        $this->elements['horizontal'] = $horizontal;

        $label_width = new Dlayer_Form_Element_Number('label_width');
        $label_width->setAttribs(
            array(
                'max'=>12,
                'min'=>1,
                'class'=>'form-control input-sm'
            )
        );
        $label_width->setLabel('Label width');
        $label_width->setDescription('Set the width for the label column, should be a value between one 
            and 12, the sum of the label and elements widths should be 12');
        $label_width->setBelongsTo('params');

        if (array_key_exists('label_width', $this->data) && $this->data['label_width'] !== false) {
            $label_width->setValue($this->data['label_width']);
        } else {
            $label_width->setValue(3);
        }

        $this->elements['label_width'] = $label_width;

        $element_width = new Dlayer_Form_Element_Number('element_width');
        $element_width->setAttribs(
            array(
                'max'=>12,
                'min'=>1,
                'class'=>'form-control input-sm'
            )
        );
        $element_width->setLabel('Element width');
        $element_width->setDescription('Set the width for the element column, should be a value between one 
            and 12, the sum of the label and elements widths should be 12');
        $element_width->setBelongsTo('params');

        if (array_key_exists('element_width', $this->data) && $this->data['element_width'] !== false) {
            $element_width->setValue($this->data['element_width']);
        } else {
            $element_width->setValue(9);
        }

        $this->elements['element_width'] = $element_width;
    }
}
