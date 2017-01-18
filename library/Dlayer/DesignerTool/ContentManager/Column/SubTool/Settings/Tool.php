<?php

/**
 * Settings sub tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Column_SubTool_Settings_Tool extends Dlayer_Tool_Content
{
    /**
     * @var Dlayer_DesignerTool_ContentManager_Column_SubTool_Settings_Model
     */
    private $model;

    /**
     * @var array
     */
    private $current_values = array();

    /**
     * @var boolean
     */
    private $current_values_fetched = false;

    /**
     * Check that the required params have been submitted, check the keys in the params array
     *
     * @param array $params
     *
     * @return boolean
     */
    protected function paramsExist(array $params)
    {
        $valid = false;
        if (array_key_exists('width', $params) === true && array_key_exists('offset', $params) === true) {
            $valid = true;
        }

        return $valid;
    }

    /**
     * Check to ensure the posted params are of the correct type and optionally within range
     *
     * @param array $params
     *
     * @return boolean
     */
    protected function paramsValid(array $params)
    {
        $valid = false;
        if (
            (intval($params['width']) > 0 && intval($params['width']) < 13)
            &&
            intval($params['offset']) >= 0
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
     *
     * @return void
     */
    protected function paramsAssign(array $params, $manual_tool = true)
    {
        if (array_key_exists('width', $params) === true) {
            $this->params['width'] = intval($params['width']);
        }

        if (array_key_exists('offset', $params) === true) {
            $this->params['offset'] = intval($params['offset']);
        }
    }

    /**
     * Validate the instances param, need to see if it should exist first
     *
     * @param integer $site_id
     * @param integer $content_id
     *
     * @return boolean
     */
    protected function validateInstances($site_id, $content_id)
    {
        // TODO: Implement validateInstances() method.
    }

    /**
     * Add a new item
     *
     * @return array|FALSE Ids for new environment vars or FALSE if the request failed
     */
    protected function add()
    {
        // TODO: Implement add() method.
    }

    /**
     * Edit the item
     *
     * @return array|FALSE Ids for new environment vars or FALSE if the request failed
     * @throws Exception
     */
    protected function edit()
    {
        // TODO: Implement add() method.
    }

    /**
     * Make a structural change to the page
     *
     * @return array|FALSE An array of the environment vars to set or FALSE upon error
     */
    protected function structure()
    {
        $this->model = new Dlayer_DesignerTool_ContentManager_Column_SubTool_Settings_Model();

        $this->width();

        $this->offset();

        return $this->returnIds();
    }

    /**
     * Update the default width for the Bootstrap (md) layout
     *
     * @return void
     * @throws Exception
     */
    private function width()
    {
        $this->currentValues();

        $width = $this->current_values['width'];

        if ($this->params['width'] !== $width || $width === false) {
            // $width false should never happen, just in case update the value for the column
            try {
                $result = $this->model->updateWidth($this->site_id, $this->page_id, $this->column_id, $this->params['width']);
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), $e->getCode(), $e);
            }

            if ($result === false) {
                Dlayer_Helper::sendToErrorLog('Failed to set the column width for the default layout, site_id: ' .
                    $this->site_id . ' page id: ' . $this->page_id . ' column id: ' . $this->column_id . ' new width: ' .
                    $this->params['width'] . ' width: ' . $width);
            }
        }
    }

    /**
     * Update the offset for a column
     *
     * @return void
     * @throws Exception
     */
    private function offset()
    {
        $this->currentValues();

        $offset = $this->current_values['offset'];

        if ($this->params['offset'] !== $offset || $offset === false) {
            // $offset false should never happen, just in case update the value for the column
            try {
                $result = $this->model->updateOffset($this->site_id, $this->page_id, $this->column_id, $this->params['offset']);
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), $e->getCode(), $e);
            }

            if ($result === false) {
                Dlayer_Helper::sendToErrorLog('Failed to set the column offset, site_id: ' .
                    $this->site_id . ' page id: ' . $this->page_id . ' column id: ' . $this->column_id . ' new offset: ' .
                    $this->params['offset'] . ' offset: ' . $offset);
            }
        }
    }

    /**
     * Fetch the current values for the column settings, result assigned to $this->current_values
     */
    private function currentValues()
    {
        if ($this->current_values_fetched === false) {
            try {
                $this->current_values = $this->model->widthProperties($this->site_id, $this->page_id, $this->column_id);
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), $e->getCode(), $e);
            }

            $this->current_values_fetched = true;

            if ($this->current_values === false) {
                $this->current_values = array(
                    'width' => false,
                    'offset' => false
                );
            }
        }
    }

    /**
     * Generate the return ids array
     *
     * @return array
     */
    protected function returnIds()
    {
        return array(
            array(
                'type' => 'page_id',
                'id' => $this->page_id,
            ),
            array(
                'type' => 'row_id',
                'id' => $this->row_id,
            ),
            array(
                'type' => 'column_id',
                'id' => $this->column_id,
            ),
            array(
                'type' => 'tool',
                'id' => 'Column',
            ),
            array(
                'type' => 'tab',
                'id' => 'settings',
                'sub_tool' => 'Settings'
            )
        );
    }
}
