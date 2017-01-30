<?php

/**
 * Text element tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
abstract class Dlayer_DesignerTool_FormBuilder_Shared_Tool_Element extends Dlayer_Tool_Form
{
    /**
     * Add a new content item or setting
     *
     * @return array|FALSE Ids for new environment vars or FALSE if the request failed
     */
    protected function add()
    {
        $continue = false;
        $model = new Dlayer_DesignerTool_FormBuilder_Shared_Model_Element();

        $field_id = $model->addField($this->site_id, $this->form_id, $this->field_type);

        if ($field_id !== false) {
            $continue = $model->addAttributes($this->site_id, $this->form_id, $field_id, $this->params, $this->field_type);
        }

        if ($field_id !== false && $continue === true) {
            Dlayer_Helper::sendToInfoLog('Element added to site id: ' . $this->site_id . ' form id: ' .
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
        $model = new Dlayer_DesignerTool_FormBuilder_Shared_Model_Element();

        try {
            $result = $model->editAttributes($this->site_id, $this->form_id, $this->field_id, $this->params, $this->field_type);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }

        if ($result === true) {
            return $this->returnIds();
        } else {
            return false;
        }
    }
}
