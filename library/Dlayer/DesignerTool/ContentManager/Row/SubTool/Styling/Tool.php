<?php

/**
 * Styling sub tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Row_SubTool_Styling_Tool extends Dlayer_Tool_Content
{
    /**
     * @var Dlayer_DesignerTool_ContentManager_Row_SubTool_Styling_Model
     */
    protected $model;

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
        if (array_key_exists('background_color', $params) === true) {
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
        if (strlen(trim($params['background_color'])) === 0 ||
            (strlen(trim($params['background_color'])) === 7 &&
                Dlayer_Validate::colorHex($params['background_color']) === true)
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
        if (array_key_exists('background_color', $params) === true) {
            $this->params['background_color'] = trim($params['background_color']);
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
     * Manage the background color for the selected item
     *
     * @return void
     * @throws Exception
     */
    protected function backgroundColor()
    {
        $this->model();

        $log_property = 'background color';
        $id = $this->model->existingBackgroundColorId($this->site_id, $this->page_id, $this->row_id);

        if ($id === false) {
            $result = $this->model->addBackgroundColor(
                $this->site_id,
                $this->page_id,
                $this->row_id,
                $this->params['background_color']
            );

            if ($result === true) {
                $this->addToColorHistory($this->params['background_color']);
                $this->logChange($log_property, $this->params['background_color']);
            } else {
                throw new Exception('Unable to set new background color on row');
            }
        } else {
            $color = $this->model->backgroundColor($this->site_id, $this->page_id, $this->row_id);

            if ($color !== $this->params['background_color']) {

                $result = $this->model->editBackgroundColor($id, $this->params['background_color']);

                if ($result === true) {
                    if ($this->params['background_color'] !== null) {
                        $this->addToColorHistory($this->params['color']);
                    }
                    $this->logChange($log_property, $this->params['background_color']);
                } else {
                    throw new Exception('Unable to update the background color on a row');
                }
            }
        }
    }

    /**
     * Make a structural change to the page
     *
     * @return array|false An array of the environment vars to set or false upon error
     */
    protected function structure()
    {
        try {
            $this->backgroundColor();
        } catch (Exception $e) {
            Dlayer_Helper::sendToErrorLog($e->getMessage());
            return false;
        }

        return $this->returnIds();
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
                'id' => 'Row',
            ),
            array(
                'type' => 'tab',
                'id' => 'styling',
                'sub_tool' => 'Styling'
            )
        );
    }

    /**
     * Add the used colour to the colour history table
     *
     * @param string $color
     *
     * @return void
     */
    protected function addToColorHistory($color)
    {
        $model_palette = new Dlayer_Model_Palette();
        $model_palette->addToHistory($this->site_id, $color);
    }

    /**
     * Log change
     *
     * @param string $property
     * @param string $value
     *
     * @return void
     */
    protected function logChange($property, $value)
    {
        Dlayer_Helper::sendToInfoLog("Set {$property} for row - site_id: " . $this->site_id . ' page id: ' .
            $this->page_id . ' row id: ' . $this->row_id . ' new value: ' . $value);
    }

    /**
     * Setup the model
     *
     * @return void
     */
    protected function model()
    {
        if ($this->model === null) {
            $this->model = new Dlayer_DesignerTool_ContentManager_Row_SubTool_Styling_Model();
        }
    }
}
