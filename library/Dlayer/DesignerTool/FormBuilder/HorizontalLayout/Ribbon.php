<?php

/**
 * Horizontal layout tool ribbon class
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_HorizontalLayout_Ribbon extends Dlayer_Ribbon_Form
{
    /**
     * Fetch the view data for the tool tab, contains an index with the form (pre filled if necessary) and another
     * with the data required by the live preview functions
     *
     * @param array $tool Tool and environment data array
     * @return array Data array for view
     */
    public function viewData(array $tool)
    {
        $this->tool = $tool;

        return array(
            'form' => new Dlayer_DesignerTool_FormBuilder_HorizontalLayout_Form(
                $tool,
                array(),
                array('layout' => 3)
            )
        );
    }

    /**
     * Fetch the data array for the field, if in edit mode mode populate the values otherwise every value is
     * set to false, the tool form can simply check to see if the value is false or not and then set the
     * existing value
     *
     * @return array
     */
    protected function fieldData()
    {
        // TODO: Implement fieldData() method.
    }
}
