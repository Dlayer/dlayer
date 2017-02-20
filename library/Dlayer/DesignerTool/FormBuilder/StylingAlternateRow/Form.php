<?php

/**
 * Alternate row styling
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_StylingAlternateRow_Form extends Dlayer_Form_Tool_Form
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

        $this->addElementsToForm('styling', 'Alternate rows', $this->elements);

        $this->addDefaultElementDecorators();

        $this->addCustomElementDecorators();
    }

    protected function generateUserElements()
    {
        $color_1 = new Dlayer_Form_Element_ColorPicker('color_1');
        $color_1->setLabel('Primary row colour');
        $color_1->setDescription('Select the primary row background colour');
        $color_1->setBelongsTo('params');
        $color_1->addClearLink();

        $this->elements['color_1'] = $color_1;

        $color_2 = new Dlayer_Form_Element_ColorPicker('color_2');
        $color_2->setLabel('Secondary row colour');
        $color_2->setDescription('Select the secondary row background colour');
        $color_2->setBelongsTo('params');
        $color_2->addClearLink();

        $this->elements['color_2'] = $color_2;

        $confirm = new Zend_Form_Element_Checkbox('confirm');
        $confirm->setLabel('Confirm');
        $confirm->setDescription('Please check the box to confirm, this will clear any existing row styling for 
            the form');
        $confirm->setBelongsTo('params');
        $confirm->setRequired();

        $this->elements['confirm'] = $confirm;
    }
}
