<?php

/**
 * Password element, styling sub tool ribbon class
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_Password_SubTool_Styling_Ribbon extends Dlayer_Ribbon_Form
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
            'form' => new Dlayer_DesignerTool_FormBuilder_Password_SubTool_Styling_Form(
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
                'row_background_color' => false
            );

            if ($this->tool['field_id'] !== null) {
                $model = new Dlayer_DesignerTool_FormBuilder_Password_SubTool_Styling_Model();
                $row_background_color = $model->rowBackgroundColor(
                    $this->tool['site_id'],
                    $this->tool['form_id'],
                    $this->tool['field_id']
                );

                if ($row_background_color !== false) {
                    $this->field_data['row_background_color'] = $row_background_color;
                }
            }

            $this->field_data_fetched = true;
        }
    }
}
