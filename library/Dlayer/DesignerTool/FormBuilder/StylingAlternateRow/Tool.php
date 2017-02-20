<?php

/**
 * Alternate rows
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_StylingAlternateRow_Tool extends Dlayer_Tool_Form
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
        if (array_key_exists('confirm', $params) === true &&
            array_key_exists('color_1', $params) === true &&
            array_key_exists('color_2', $params) === true) {

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
        if (intval($params['confirm']) === 1 &&
            (strlen(trim($params['color_1'])) === 0 || Dlayer_Validate::colorHex(trim($params['color_1'])) === true) &&
            (strlen(trim($params['color_2'])) === 0 || Dlayer_Validate::colorHex(trim($params['color_2'])) === true) &&
            (strlen(trim($params['color_1'])) === 7 || strlen(trim($params['color_2'])) === 7)) {

            $valid = true;
        }

        return $valid;
    }

    /**
     * Prepare the posted params, convert them to the required types and assign to the $this->params_auto property
     *
     * @param array $params
     * @return void
     */
    protected function paramsAssignAuto(array $params)
    {
        $this->params_auto = array(
            'color_1' => (strlen(trim($params['color_1'])) === 0) ? null : trim($params['color_1']),
            'color_2' => (strlen(trim($params['color_2'])) === 0) ? null : trim($params['color_2'])
        );
    }

    /**
     * Make a structural change to the page
     *
     * @return array|false An array of the environment vars to set or FALSE upon error
     */
    protected function structure()
    {
        $results = array();

        $model = new Dlayer_DesignerTool_FormBuilder_StylingAlternateRow_Model();

        $clear = $model->clearAllFormRowBackgroundColors($this->site_id, $this->form_id);

        if ($clear === true) {
            $fieldIds = $model->fieldIdsInOrder($this->site_id, $this->form_id);

            $x = 1;
            foreach ($fieldIds as $field) {
                if ($x % 2 === 0) {
                    if ($this->params_auto['color_2'] !== null) {
                        $results[] = $model->setRowBackgroundColor($this->site_id, $this->form_id, intval($field['id']),
                            $this->params_auto['color_2']);
                    } else {
                        $results[] = true;
                    }
                } else {
                    if ($this->params_auto['color_1'] !== null) {
                        $results[] = $model->setRowBackgroundColor($this->site_id, $this->form_id, intval($field['id']),
                            $this->params_auto['color_1']);
                    } else {
                        $results[] = true;
                    }
                }
                $x++;
            }
        } else {
            $results[] = false;
        }

        if (in_array(false, $results) === false) {
            return $this->returnIds();
        } else {
            return false;
        }
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
        // TODO: Implement edit() method.
    }

    /**
     * Prepare the posted params, convert them to the required types and assign to the $this->params property
     *
     * @param array $params
     *
     * @return void
     */
    protected function paramsAssign(array $params)
    {
        // TODO: Implement paramsAssign() method.
    }
}
