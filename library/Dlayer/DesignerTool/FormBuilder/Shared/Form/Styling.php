<?php

/**
 * Shared styling form class
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_Shared_Form_Styling extends Dlayer_Form_Tool_Form
{
    /**
     * Set the properties for the form
     *
     * @param array $tool Tool and environment data array
     * @param array $data Current data for content item
     * @param array $element_data
     * @param array|NULL $options Zend form options
     */
    public function __construct(array $tool, array $data, array $element_data, $options)
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

        $this->addElementsToForm('styling', 'Styling', $this->elements);

        $this->addDefaultElementDecorators();

        $this->addCustomElementDecorators();
    }

    /**
     * Generate the tool elements that the user interacts with
     *
     * @return void
     */
    protected function generateUserElements()
    {
        $row_background_color = new Dlayer_Form_Element_ColorPicker('row_background_color');
        $row_background_color->setLabel('Row background colour');
        $row_background_color->setDescription('Choose a background colour for the row');
        $row_background_color->setBelongsTo('params');
        $row_background_color->addClearLink();
        if (array_key_exists('row_background_color', $this->data) === true &&
            $this->data['row_background_color'] !== false
        ) {

            $row_background_color->setValue($this->data['row_background_color']);
        }

        $this->elements['background_color'] = $row_background_color;
    }
}
