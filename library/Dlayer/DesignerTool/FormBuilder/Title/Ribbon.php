<?php

/**
 * Ribbon for title tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_Title_Ribbon extends Dlayer_Ribbon_Form
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
            'form' => new Dlayer_DesignerTool_FormBuilder_Title_Form(
                $tool,
                $this->field_data,
                array()
            )
        );
    }

    /**
     * Fetch the data array for the field/item, if in edit mode mode populate the values otherwise every value is
     * set to false, the tool form can simply check to see if the value is false or not and then set the
     * existing value
     *
     * @return array
     */
    protected function fieldData()
    {
        if ($this->field_data_fetched === false) {
            $this->field_data = array(
                'form_title' => false,
                'form_subtitle' => false
            );

            $model = new Dlayer_DesignerTool_FormBuilder_Title_Model();
            $titles = $model->titles($this->tool['site_id'], $this->tool['form_id']);

            if ($titles !== false) {
                $this->field_data['form_title'] = $titles['title'];
                $this->field_data['form_subtitle'] = $titles['subtitle'];
            }

            $this->field_data_fetched = true;
        }
    }
}
