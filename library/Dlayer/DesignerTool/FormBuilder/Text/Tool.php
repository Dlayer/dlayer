<?php

/**
 * Text element tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_Text_Tool extends Dlayer_Tool_Form
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
        if (array_key_exists('label', $params) === true &&
            array_key_exists('description', $params) === true &&
            array_key_exists('placeholder', $params) === true &&
            array_key_exists('size', $params) === true &&
            array_key_exists('maxlength', $params) === true) {

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
        if (strlen(trim($params['label'])) > 0 &&
            strlen(trim($params['description'])) >= 0 &&
            strlen(trim($params['placeholder'])) >= 0 &&
            intval($params['size']) > 0 &&
            intval($params['maxlength']) > 0) {

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
            'label' => trim($params['name']),
            'description' => trim($params['description']),
            'placeholder' => trim($params['placeholder']),
            'size' => intval($params['size']),
            'maxlength' => intval($params['maxlength'])
        );
    }

    /**
     * Add a new content item or setting
     *
     * @return array|FALSE Ids for new environment vars or FALSE if the request failed
     */
    protected function add()
    {
        $continue = false;
        $model = new Dlayer_DesignerTool_FormBuilder_Text_Model();

        $field_id = $model->addField($this->site_id, $this->form_id, 'text');

        if ($field_id !== false) {
            $continue = $model->addAttributes($this->site_id, $this->form_id, $field_id, $this->params);
        }

        if ($field_id !== false && $continue === true) {
            Dlayer_Helper::sendToInfoLog('Text element added to site id: ' . $this->site_id . ' form id: ' .
                $this->form_id);

            return $this->returnIds($field_id);
        } else {
            return false;
        }
    }

    /**
     * Edit a new content item or setting
     *
     * @return array|FALSE Ids for new environment vars or FALSE if the request failed
     * @throws Exception
     */
    protected function edit()
    {

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
                'id' => 'Text',
            ),
            array(
                'type' => 'field_id',
                'id' => $this->field_id,
                'field_type' => 'Text'
            )
        );
    }
}
