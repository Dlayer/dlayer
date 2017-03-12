<?php

/**
 * Horizontal rule content item tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_HorizontalRule_Tool extends Dlayer_Tool_Content
{
    /**
     * @var Dlayer_DesignerTool_ContentManager_HorizontalRule_Model
     */
    private $model;

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
        if (array_key_exists('color', $params) === true) {
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
        if (strlen(trim($params['color'])) === 0 ||
            (strlen(trim($params['color'])) === 7 &&
                Dlayer_Validate::colorHex($params['color']) === true)
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
        $this->params = array(
            'color' => trim($params['color']),
        );
    }

    /**
     * Add a new content item or setting
     *
     * @return array|false Ids for new environment vars or FALSE if the request failed
     */
    protected function add()
    {
        // Not required by tool
    }

    /**
     * Edit a new content item or setting
     *
     * @return array|false Ids for new environment vars or false if the request failed
     * @throws Exception
     */
    protected function edit()
    {
        try {
            $this->borderTopColor();
        } catch (Exception $e) {
            Dlayer_Helper::sendToErrorLog($e->getMessage());
            return false;
        }

        return $this->returnIds();
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
     * Manage the border top colour
     *
     * @return void
     * @throws Exception
     */
    protected function borderTopColor()
    {
        $this->model();

        $log_property = 'horizontal rule color';
        $id = $this->model->existingBorderTopColorId($this->site_id, $this->page_id, $this->content_id);

        if ($id === false) {
            $result = $this->model->addBorderTopColor(
                $this->site_id,
                $this->page_id,
                $this->content_id,
                $this->params['color']
            );

            if ($result === true) {
                $this->addToColorHistory($this->params['color']);
                $this->logChange($log_property, $this->params['color']);
            } else {
                throw new Exception('Unable to set new horizontal rule color');
            }
        } else {
            $color = $this->model->borderTopColor($this->site_id, $this->page_id, $this->content_id);

            if ($color !== $this->params['color']) {

                $result = $this->model->editBorderTopColor($id, $this->params['color']);

                if ($result === true) {
                    if ($this->params['color'] !== null) {
                        $this->addToColorHistory($this->params['color']);
                    }
                    $this->logChange($log_property, $this->params['color']);
                } else {
                    throw new Exception('Unable to update the horizontal rule background color');
                }
            }
        }
    }

    /**
     * Generate the return ids array
     *
     * @param integer|NULL Set content id or use the class property
     *
     * @return array
     */
    protected function returnIds($content_id = null)
    {
        if ($content_id !== null) {
            $this->content_id = $content_id;
        }

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
                'id' => 'HorizontalRule',
            ),
            array(
                'type' => 'content_id',
                'id' => $this->content_id,
                'content_type' => 'HorizontalRule',
            ),
        );
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
        return false;
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
        Dlayer_Helper::sendToInfoLog("Set {$property} for horizontal rule - content_id: " . $this->content_id .
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
            $this->model = new Dlayer_DesignerTool_ContentManager_HorizontalRule_Model();
        }
    }
}
