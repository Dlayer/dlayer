<?php

/**
 * Text element tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_Text_SubTool_Styling_Tool extends Dlayer_Tool_Form
{
    /**
     * Check that the required params have been submitted, check the keys in the params array
     *
     * @param array $params
     * @return boolean
     */
    protected function paramsExist(array $params)
    {
        $valid = false;
        if (array_key_exists('row_background_color', $params) === true) {
            $valid = true;
        }

        return $valid;
    }

    /**
     * Check to ensure the posted params are of the correct type and optionally within range
     *
     * @param array $params
     * @return boolean
     */
    protected function paramsValid(array $params)
    {
        $valid = false;
        if (strlen(trim($params['row_background_color'])) === 0 ||
            (strlen(trim($params['row_background_color'])) === 7 &&
                Dlayer_Validate::colorHex($params['row_background_color']) === true)
        ) {
            $valid = true;
        }

        return $valid;
    }

    /**
     * Prepare the posted params, convert them to the required types and assign to the $this->params property
     *
     * @param array $params
     * @param boolean $manual_tool Are the values to be assigned to $this->params or $this->params_auto
     * @return void
     */
    protected function paramsAssign(array $params, $manual_tool = true)
    {
        $this->params = array(
            'row_background_color' => trim($params['row_background_color'])
        );
    }



    /**
     * Make a structural change to the page
     *
     * @return array|FALSE An array of the environment vars to set or FALSE upon error
     */
    protected function structure()
    {
        // Not required by manual tool
    }

    /**
     * Generate the return ids array
     *
     * @param integer|null $field_id Set field id or use class property
     * @return array
     */
    protected function returnIds($field_id = null)
    {
        if ($field_id !== null) {
            $this->field_id = $field_id;
        }

        return array(
            array(
                'type' => 'form_id',
                'id' => $this->form_id,
            ),
            array(
                'type' => 'tool',
                'id' => 'Text'
            ),
            array(
                'type' => 'tab',
                'id' => 'styling',
                'sub_tool' => 'Styling'
            ),
            array(
                'type' => 'field_id',
                'id' => $this->field_id,
                'field_type' => 'Text'
            )
        );
    }

    /**
     * Add a new form field
     *
     * @return array|false Ids for new environment vars or FALSE if the request failed
     */
    protected function add()
    {
        // TODO: Implement add() method.
    }

    /**
     * Edit a form field
     *
     * @return array|false Ids for new environment vars or FALSE if the request failed
     * @throws Exception
     */
    protected function edit()
    {
        $this->rowBackgroundColor();

        return $this->returnIds();
    }

    /**
     * manage the background color for a field row
     *
     * @return void
     * @throws Exception
     */
    protected function rowBackgroundColor()
    {
        $model = new Dlayer_DesignerTool_FormBuilder_Text_SubTool_Styling_Model();
        $model_palette = new Dlayer_Model_Palette();

        $id = $model->existingRowBackgroundColor($this->site_id, $this->form_id, $this->field_id);

        if ($id === false) {
            try {
                $model->addRowBackgroundColor(
                    $this->site_id,
                    $this->form_id,
                    $this->field_id,
                    $this->params['row_background_color']
                );
                $model_palette->addToHistory($this->site_id, $this->params['row_background_color']);

                Dlayer_Helper::sendToInfoLog('Set row background colour for form field: ' . $this->field_id .
                    ' site_id: ' . $this->site_id . ' form id: ' . $this->form_id);
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), $e->getCode(), $e);
            }
        } else {
            try {
                $model->editRowBackgroundColor($id, $this->params['row_background_color']);
                if ($this->params['row_background_color'] !== null && strlen($this->params['row_background_color']) === 7) {
                    $model_palette->addToHistory($this->site_id, $this->params['row_background_color']);

                    Dlayer_Helper::sendToInfoLog('Set row background colour for form field: ' . $this->field_id .
                        ' site_id: ' . $this->site_id . ' form id: ' . $this->form_id);
                }
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), $e->getCode(), $e);
            }
        }
    }
}
