<?php

/**
 * Shared typography form class
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Shared_Form_Content_Typography extends Dlayer_Form_Tool_Content
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

        $this->addElementsToForm('typography', 'Typography', $this->elements);

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
        $font_family->setDescription('Choose a font family, defaults to the font family selected in the settings');
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

        $text_weight = new Zend_Form_Element_Select('text_weight_id');
        $text_weight->setLabel('Text weight');
        $text_weight->setDescription('Choose the text weight, defaults to the the text weight selected in settings');
        if ($this->element_data['text_weights'] !== false) {
            $text_weight->setMultiOptions($this->element_data['text_weights']);
        }
        $text_weight->setAttribs(array('class' => 'form-control input-sm'));
        $text_weight->setBelongsTo('params');
        if ($this->data['text_weight_id'] !== false) {
            $text_weight->setValue($this->data['text_weight_id']);
        } else {
            $text_weight->setValue(DEFAULT_TEXT_WEIGHT_FOR_MODULE);
        }

        $this->elements['text_weight_id'] = $text_weight;
    }
}
