<?php

/**
 * Title tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_Title_Tool extends Dlayer_Tool_Form
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
        if (array_key_exists('form_title', $params) === true &&
            array_key_exists('form_subtitle', $params) === true ) {

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
        if (strlen(trim($params['form_title'])) > 0 && strlen(trim($params['form_subtitle'])) >= 0) {
            $valid = true;
        }

        return $valid;
    }

    /**
     * Prepare the posted params, convert them to the required types and assign to the $this->params property
     *
     * @param array $params
     * @return void
     */
    protected function paramsAssign(array $params)
    {
        // TODO: Implement paramsAssign() method.
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
            'title' => trim($params['form_title']),
            'subtitle' => (strlen(trim($params['form_subtitle'])) > 0) ? trim($params['form_subtitle']) : null
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
     * Make a setting/layout change to form
     *
     * @return array|false An array of the environment vars to set or FALSE upon error
     */
    protected function structure()
    {
        $model = new Dlayer_DesignerTool_FormBuilder_Title_Model();

        $result = $model->updateTitles(
            $this->site_id,
            $this->form_id,
            $this->params_auto['title'],
            $this->params_auto['subtitle']
        );

        if ($result === true) {
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
}
