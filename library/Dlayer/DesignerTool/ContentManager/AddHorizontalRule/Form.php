<?php

/**
 * Form for the horizontal rule tool
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_AddHorizontalRule_Form extends Dlayer_Form_Tool_Content
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
        $name = new Zend_Form_Element_Hidden('name');
        $name->setDescription("To add a horizontal rule, please click the 'save' button.");
        $name->setBelongsTo('params');
        $name->setRequired();

        if(array_key_exists('name', $this->data) === TRUE && $this->data['name'] !== FALSE)
        {
            $name->setValue($this->data['name']);
        }

        $this->elements['name'] = $name;
    }
}
