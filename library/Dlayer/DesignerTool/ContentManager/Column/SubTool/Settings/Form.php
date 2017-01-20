<?php

/**
 * Settings for column
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Column_SubTool_Settings_Form extends Dlayer_Form_Content
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
        $this->sub_tool_model = 'Settings';

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

        $this->addElementsToForm('column_settings', 'Settings', $this->elements);

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
        $width = new Dlayer_Form_Element_Number(
            'width',
            array(
                'min' => 1,
                'max' => 12,
                'class'=>'form-control input-sm'
            )
        );
        $width->setLabel('Width (1 - 12)');
        $width->setDescription('Set the base width to use for the default (md) layout.');
        $width->setBelongsTo('params');
        $width->setRequired();

        if (array_key_exists('width', $this->data) === true &&
            $this->data['width'] !== false
        ) {
            $width->setValue($this->data['width']);
        }

        $this->elements['width'] = $width;

        $offset = new Dlayer_Form_Element_Number(
            'offset',
            array(
                'min' => 0,
                'max' => 12,
                'class'=>'form-control input-sm'
            )
        );
        $offset->setLabel('Offset (0 - 12)');
        $offset->setDescription('Set the offset for the column in default (md) layout, defaults to 0.');
        $offset->setBelongsTo('params');

        if (array_key_exists('offset', $this->data) === true &&
            $offset->data['offset'] !== false
        ) {
            $offset->setValue($this->data['offset']);
        }

        $this->elements['offset'] = $offset;
    }
}
