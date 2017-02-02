<?php

/**
 * Text element tool ribbon class
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_Text_Ribbon extends Dlayer_Ribbon_Form
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
        $this->previewData();

        return array(
            'form' => new Dlayer_DesignerTool_FormBuilder_Text_Form(
                $tool,
                $this->field_data,
                array()
            ),
            'preview' => $this->preview_data
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
                'label' => false,
                'description' => false,
                'placeholder' => false,
                'size' => false,
                'maxlength' => false
            );

            if ($this->tool['field_id'] !== null) {
                $model = new Dlayer_DesignerTool_FormBuilder_Text_Model();
                $field_data = $model->fieldData($this->tool['site_id'], $this->tool['form_id'], $this->tool['field_id']);

                if ($field_data !== false) {
                    foreach ($field_data as $row) {
                        if (array_key_exists($row['attribute'], $this->field_data) === true) {
                            switch ($row['attribute_type']) {
                                case 'integer':
                                    $this->field_data[$row['attribute']] = intval($row['value']);
                                    break;

                                default:
                                    $this->field_data[$row['attribute']] = trim($row['value']);
                                    break;
                            }
                        }
                    }
                }
            }

            $this->field_data_fetched = true;
        }
    }

    /**
     * Fetch the data required by the preview functions
     *
     * @return void
     */
    protected function previewData()
    {
        if ($this->preview_data_fetched === false && $this->tool['field_id'] !== null) {

            $this->fieldData();

            $this->preview_data = array(
                'attribute_values' => array(
                    array(
                        'element' => '#params-placeholder',
                        'field_id' => $this->tool['field_id'],
                        'attribute' => 'placeholder',
                        'initial_value' => $this->field_data['placeholder'],
                        'optional' => true
                    )
                )
            );

            $this->preview_data_fetched = true;
        }
    }
}
