<?php

/**
 * Delete element form class
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_Password_SubTool_Delete_Form extends
    Dlayer_DesignerTool_FormBuilder_Shared_Form_Delete
{
    /**
     * Set the properties for the form
     *
     * @param array $tool Tool and environment data array
     * @param array $data Current data for content item
     * @param array $element_data
     * @param array|null $options Zend form options
     */
    public function __construct(array $tool, array $data, array $element_data, $options = null)
    {
        $this->field_type = 'Password';
        $this->sub_tool_model = 'Delete';

        parent::__construct($tool, $data, $element_data, $options);
    }
}
