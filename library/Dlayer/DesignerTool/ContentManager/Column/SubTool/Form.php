<?php

/**
 * Styling sub tools for a column
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Column_SubTool_Styling_Form extends Dlayer_Form_Content
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
        $this->setAction('/content/process/tool');

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
        $column_background_color = new Dlayer_Form_Element_ColorPicker('column_background_color');
        $column_background_color->setLabel('Column background color');
        $column_background_color->setDescription('Set the background colour for the selected column.');
        $column_background_color->setBelongsTo('params');
        $column_background_color->addClearLink();
        $column_background_color->setBelongsTo('params');

        if (array_key_exists('column_background_color', $this->data) === true &&
            $this->data['column_background_color'] !== false
        ) {
            $column_background_color->setValue($this->data['column_background_color']);
        }

        $this->elements['column_background_color'] = $column_background_color;
    }
}
