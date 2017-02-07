<?php

/**
 * Inline layout
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_InlineLayout_Form extends Dlayer_Form_Tool_Form
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

        $this->addElementsToForm('layout', 'Inline layout', $this->elements);

        $this->addDefaultElementDecorators();

        $this->addCustomElementDecorators();
    }

    protected function generateUserElements()
    {
        $inline = new Zend_Form_Element_Hidden('inline');
        $inline->setBelongsTo('params');
        $inline->setDescription('Enable the inline layout for this form; labels and elements will 
            site inline, flowing left to right.');
        $inline->setValue(2);

        $this->elements['inline'] = $inline;
    }
}
