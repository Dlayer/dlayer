<?php

/**
 * Preset comment element tool ribbon class
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_PresetComment_Ribbon extends Dlayer_Ribbon_Form
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

        $this->fieldData();

        return array(
            'form' => new Dlayer_DesignerTool_FormBuilder_PresetComment_Form(
                $tool,
                $this->field_data,
                array()
            )
        );
    }

    /**
     * Fetch any existing field data, always return an array, values are false if noting exists
     *
     * @return void
     */
    protected function fieldData()
    {
        if ($this->field_data_fetched === false) {
            $this->field_data = array(
                'label' => 'Your comment',
                'description' => 'Please provide your feedback',
                'placeholder' => 'e.g., The demo seems pretty limited',
                'rows' => 4,
                'cols' => 40
            );

            $this->field_data_fetched = true;
        }
    }
}
