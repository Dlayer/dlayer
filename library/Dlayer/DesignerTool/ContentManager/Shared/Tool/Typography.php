<?php

/**
 * Shared typography tool class
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Shared_Tool_Typography extends Dlayer_Tool_Content
{
    /**
     * @var Dlayer_DesignerTool_ContentManager_Shared_Model_Content_Typography
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
        if (array_key_exists('font_family_id', $params) === true &&
            array_key_exists('text_weight_id', $params) === true
        ) {
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

        $model = new Dlayer_Model_DesignerTool_ContentManager_Typography();

        if ($model->fontFamilyIdValid($params['font_family_id']) === true &&
            $model->fontWeightIdValid($params['text_weight_id']) === true) {
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
        if (array_key_exists('font_family_id', $params) === true) {
            $this->params['font_family_id'] = intval($params['font_family_id']);
        }

        if (array_key_exists('text_weight_id', $params) === true) {
            $this->params['text_weight_id'] = intval($params['text_weight_id']);
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
     * Edit a content item or setting
     *
     * @return array|false Ids for new environment vars or false if the request failed
     * @throws Exception
     */
    protected function edit()
    {
        try {
            $this->fontFamily();
        } catch (Exception $e) {
            Dlayer_Helper::sendToErrorLog($e->getMessage());
            return false;
        }

        try {
            $this->fontWeight();
        } catch (Exception $e) {
            Dlayer_Helper::sendToErrorLog($e->getMessage());
            return false;
        }

        return $this->returnIds();
    }

    /**
     * Manage the font family for a content item
     *
     * @return void
     * @throws Exception
     */
    protected function fontFamily()
    {
        $this->model();

        $log_property = 'font family';
        $id = $this->model->existingFontFamilyId($this->site_id, $this->page_id, $this->content_id);

        if ($id === false) {
            $result = $this->model->addFontFamily(
                $this->site_id,
                $this->page_id,
                $this->content_id,
                $this->params['font_family_id']
            );

            if ($result === true) {
                $this->logChange($log_property, $this->params['font_family_id']);
            } else {
                throw new Exception('Unable to set new font family on content item');
            }
        } else {
            $family_id = $this->model->fontWeight($this->site_id, $this->page_id, $this->content_id);

            if ($family_id !== $this->params['font_family_id']) {

                $result = $this->model->editFontWeight($id, $this->params['font_family_id']);

                if ($result === true) {
                    $this->logChange($log_property, $this->params['font_family_id']);
                } else {
                    throw new Exception('Unable to update the font family on content item');
                }
            }
        }
    }

    /**
     * Manage the font weight for a content item
     *
     * @return void
     * @throws Exception
     */
    protected function fontWeight()
    {
        $this->model();

        $log_property = 'font weight';
        $id = $this->model->existingFontWeightId($this->site_id, $this->page_id, $this->content_id);

        if ($id === false) {
            $result = $this->model->addFontWeight(
                $this->site_id,
                $this->page_id,
                $this->content_id,
                $this->params['text_weight_id']
            );

            if ($result === true) {
                $this->logChange($log_property, $this->params['text_weight_id']);
            } else {
                throw new Exception('Unable to set new text weight on content item');
            }
        } else {
            $weight_id = $this->model->fontWeight($this->site_id, $this->page_id, $this->content_id);

            if ($weight_id !== $this->params['text_weight_id']) {

                $result = $this->model->editFontWeight($id, $this->params['text_weight_id']);

                if ($result === true) {
                    $this->logChange($log_property, $this->params['text_weight_id']);
                } else {
                    throw new Exception('Unable to update the font weight on content item');
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
            $this->model = new Dlayer_DesignerTool_ContentManager_Shared_Model_Content_Typography();
        }
    }
}
