<?php

/**
 * Styling sub tools for a column
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Column_SubTool_Styling_Form extends Dlayer_Form_Tool_Content
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
    public function __construct(array $tool, array $data, $instances, array $element_data, $options = null)
    {
        $this->sub_tool_model = 'Styling';

        parent::__construct($tool, $data, $instances, $element_data, $options);
    }

    /**
     * Initialise the form, sets the action and method and then calls the elements to build the form
     *
     * @return void
     */
    public function init()
    {
        $this->setAction('/content/process/tool-auto');

        $this->setMethod('post');

        $this->generateFormElements();

        $this->addElementsToForm('column_styling', 'Styling', $this->elements);

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
        $background_color = new Dlayer_Form_Element_ColorPicker('background_color');
        $background_color->setLabel('Column background color');
        $background_color->setDescription('Set the background colour for the selected column.');
        $background_color->setBelongsTo('params');
        $background_color->addClearLink();

        if (array_key_exists('background_color', $this->data) === true &&
            $this->data['background_color'] !== false
        ) {
            $background_color->setValue($this->data['background_color']);
        }

        $this->elements['background_color'] = $background_color;
    }
}
