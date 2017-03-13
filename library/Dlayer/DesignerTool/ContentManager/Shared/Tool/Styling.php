<?php

/**
 * Styling sub tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Shared_Tool_Styling extends Dlayer_Tool_Content
{
    /**
     * @var Dlayer_DesignerTool_ContentManager_Shared_Model_Styling
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
        if (array_key_exists('content_background_color', $params) === true) {
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
        if (strlen(trim($params['content_background_color'])) === 0 ||
            (strlen(trim($params['content_background_color'])) === 7 &&
                Dlayer_Validate::colorHex($params['content_background_color']) === true)
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
        if (array_key_exists('content_background_color', $params) === true) {
            $this->params['content_background_color'] = trim($params['content_background_color']);
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
     * Add a new content item or setting
     *
     * @return array|FALSE Ids for new environment vars or FALSE if the request failed
     */
    protected function add()
    {
        // TODO: Implement add() method.
    }

    /**
     * Edit a new content item or setting
     *
     * @return array|FALSE Ids for new environment vars or FALSE if the request failed
     * @throws Exception
     */
    protected function edit()
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
     * Manage the background colour for a content item
     *
     * @return void
     * @throws Exception
     */
    protected function backgroundColor()
    {
        $this->model();

        $log_property = 'background color';
        $id = $this->model->existingBackgroundColorId($this->site_id, $this->page_id, $this->content_id);

        if ($id === false) {
            $result = $this->model->addBackgroundColor(
                $this->site_id,
                $this->page_id,
                $this->content_id,
                $this->params['content_background_color']
            );

            if ($result === true) {
                $this->addToColorHistory($this->params['content_background_color']);
                $this->logChange($log_property, $this->params['content_background_color']);
            } else {
                throw new Exception('Unable to set new background color on content item');
            }
        } else {
            $color = $this->model->backgroundColor($this->site_id, $this->page_id, $this->content_id);

            if ($color !== $this->params['content_background_color']) {

                $result = $this->model->editBackgroundColor($id, $this->params['content_background_color']);

                if ($result === true) {
                    if ($this->params['content_background_color'] !== null) {
                        $this->addToColorHistory($this->params['content_background_color']);
                    }
                    $this->logChange($log_property, $this->params['content_background_color']);
                } else {
                    throw new Exception('Unable to update the background color on content item');
                }
            }
        }
    }

    /**
     * Make a structural change to the page
     *
     * @return array|FALSE An array of the environment vars to set or FALSE upon error
     */
    protected function structure()
    {
        // TODO: Implement structure() method.
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
        Dlayer_Helper::sendToInfoLog("Set {$property} on content item - content_id: " . $this->content_id .
            ' site_id: ' . $this->site_id . ' page id: ' . $this->page_id . ' row id: ' . $this->row_id .
            ' column id: ' . $this->column_id . ' new value: ' . $value);
    }

    /**
     * Setup the model
     *
     * @return void
     */
    protected function model()
    {
        if ($this->model === null) {
            $this->model = new Dlayer_DesignerTool_ContentManager_Shared_Model_Styling();
        }
    }
}
