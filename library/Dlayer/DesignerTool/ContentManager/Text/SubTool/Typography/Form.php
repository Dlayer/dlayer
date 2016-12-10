<?php

/**
 * Typography sub tools for the text content item
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Text_SubTool_Typography_Form extends Dlayer_Form_Content
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
        $this->content_type = 'text';
        $this->sub_tool_model = 'Typography';

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

        $this->addElementsToForm('text_typography', 'Typography', $this->elements);

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
        $font_family = new Zend_Form_Element_Select('font_family_id');
        $font_family->setLabel('Font family');
        $font_family->setDescription('Choose a font familiy, defaults to the font familiy set in the settings');
        if ($this->element_data['font_families'] !== false) {
            $font_family->setMultiOptions($this->element_data['font_families']);
        }
        $font_family->setAttribs(array('class' => 'form-control input-sm'));
        $font_family->setBelongsTo('params');
        if ($this->data['font_family_id'] !== false) {
            $font_family->setValue($this->data['font_family_id']);
        } else {
            $font_family->setValue(DEFAULT_FONT_FAMILY_FOR_MODULE);
        }

        $this->elements['font_family_id'] = $font_family;
    }
}
