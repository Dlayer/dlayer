<?php

/**
 * Shared styling form class
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Shared_Form_Styling extends Dlayer_Form_Content
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
        $content_background_color = new Dlayer_Form_Element_ColorPicker('content_background_color');
        $content_background_color->setLabel('Content item background color');
        $content_background_color->setDescription('Set the background colour for the selected content item.');
        $content_background_color->setBelongsTo('params');
        $content_background_color->addClearLink();
        $content_background_color->setBelongsTo('params');

        if (array_key_exists('content_background_color', $this->data) === true &&
            $this->data['content_background_color'] !== false
        ) {
            $content_background_color->setValue($this->data['content_background_color']);
        }

        $this->elements['content_background_color'] = $content_background_color;
    }
}
