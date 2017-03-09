<?php

/**
 * Form for the horizontal rule tool
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_HorizontalRule_Form extends Dlayer_Form_Tool_Content
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
        $this->content_type = 'HorizontalRule';

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

        $this->addElementsToForm('horizontal_rule', 'Horizontal rule', $this->elements);

        $this->addDefaultElementDecorators();

        $this->addCustomElementDecorators();
    }

    protected function generateUserElements()
    {
        $rule_color = new Dlayer_Form_Element_ColorPicker('color');
        $rule_color->setLabel('Colour');
        $rule_color->setDescription('Set a custom horizontal rule colour or reset to use the default.');
        $rule_color->setBelongsTo('params');
        $rule_color->addClearLink();

        if (array_key_exists('color', $this->data) === true && $this->data['color'] !== false) {
            $rule_color->setValue($this->data['color']);
        }

        $this->elements['color'] = $rule_color;
    }
}
