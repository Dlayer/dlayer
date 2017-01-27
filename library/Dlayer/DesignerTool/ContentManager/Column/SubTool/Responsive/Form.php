<?php

/**
 * Responsive settings
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Column_SubTool_Responsive_Form extends Dlayer_Form_Tool_Content
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
        $this->sub_tool_model = 'Responsive';

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

        $this->addElementsToForm('column_responsive', 'Responsive settings', $this->elements);

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
        $xs = new Dlayer_Form_Element_Number(
            'xs',
            array(
                'min' => 1,
                'max' => 12,
                'class'=>'form-control input-sm'
            )
        );
        $xs->setLabel("Width for 'xs' layout (1 - 12)");
        $xs->setDescription('Set the column width for the xs (mobile) layout.');
        $xs->setBelongsTo('params');

        if (array_key_exists('xs', $this->data) === true &&
            $this->data['xs'] !== false
        ) {
            $xs->setValue($this->data['xs']);
        }

        $this->elements['xs'] = $xs;

        $sm = new Dlayer_Form_Element_Number(
            'sm',
            array(
                'min' => 1,
                'max' => 12,
                'class'=>'form-control input-sm'
            )
        );
        $sm->setLabel("Width for 'sm' layout (1 - 12)");
        $sm->setDescription('Set the column width for the sm (tablet) layout.');
        $sm->setBelongsTo('params');

        if (array_key_exists('sm', $this->data) === true &&
            $this->data['sm'] !== false
        ) {
            $sm->setValue($this->data['sm']);
        }

        $this->elements['sm'] = $sm;

        $lg = new Dlayer_Form_Element_Number(
            'lg',
            array(
                'min' => 1,
                'max' => 12,
                'class'=>'form-control input-sm'
            )
        );
        $lg->setLabel("Width for 'lg' layout (1 - 12)");
        $lg->setDescription('Set the column width for the lg (Large desktop) layout.');
        $lg->setBelongsTo('params');

        if (array_key_exists('lg', $this->data) === true &&
            $this->data['lg'] !== false
        ) {
            $lg->setValue($this->data['lg']);
        }

        $this->elements['lg'] = $lg;
    }
}
