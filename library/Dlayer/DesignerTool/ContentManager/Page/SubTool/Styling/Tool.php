<?php

/**
 * Styling sub tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Page_SubTool_Styling_Tool extends Dlayer_Tool_Content
{
    /**
     * @var Dlayer_DesignerTool_ContentManager_Page_SubTool_Styling_Model
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
        if (array_key_exists('content_background_color', $params) === true &&
            array_key_exists('html_background_color', $params) === true) {
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
            (
                strlen(trim($params['content_background_color'])) === 0 ||
                (strlen(trim($params['content_background_color'])) === 7 &&
                    Dlayer_Validate::colorHex($params['content_background_color']) === true)
            ) &&
            (
                strlen(trim($params['html_background_color'])) === 0 ||
                (strlen(trim($params['html_background_color'])) === 7 &&
                    Dlayer_Validate::colorHex($params['html_background_color']) === true)
            )
        ) {
            $this->model();
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
        if (array_key_exists('html_background_color', $params) === true) {
            $this->params['html_background_color'] = trim($params['html_background_color']);
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
     * Manage the content background colour
     *
     * @return void
     * @throws Exception
     */
    protected function contentBackgroundColor()
    {
        $this->model();

        $log_property = 'content background color';
        $id = $this->model->existingContentBackgroundColorId($this->site_id, $this->page_id);

        if ($id === false) {
            $result = $this->model->addContentBackgroundColor(
                $this->site_id,
                $this->page_id,
                $this->params['content_background_color']
            );

            if ($result === true) {
                $this->addToColorHistory($this->params['content_background_color']);
                $this->logChange($log_property, $this->params['content_background_color']);
            } else {
                throw new Exception('Unable to set new content background color');
            }
        } else {
            $background_color = $this->model->contentBackgroundColor($this->site_id, $this->page_id);

            if ($background_color !== $this->params['content_background_color']) {

                $result = $this->model->editContentBackgroundColor($id, $this->params['content_background_color']);

                if ($result === true) {
                    if ($this->params['content_background_color'] !== null) {
                        $this->addToColorHistory($this->params['content_background_color']);
                    }
                    $this->logChange($log_property, $this->params['content_background_color']);
                } else {
                    throw new Exception('Unable to update the content container background color');
                }
            }
        }
    }

    /**
     * Manage the html/page background colour
     *
     * @return void
     * @throws Exception
     */
    protected function htmlBackgroundColor()
    {
        $this->model();

        $log_property = 'html background color';
        $id = $this->model->existingHtmlBackgroundColorId($this->site_id);

        if ($id === false) {
            $result = $this->model->addHtmlBackgroundColor(
                $this->site_id,
                $this->params['html_background_color']
            );

            if ($result === true) {
                $this->addToColorHistory($this->params['html_background_color']);
                $this->logChange($log_property, $this->params['html_background_color']);
            } else {
                throw new Exception('Unable to set new html/page background color');
            }
        } else {
            $background_color = $this->model->contentBackgroundColor($this->site_id, $this->page_id);

            if ($background_color !== $this->params['html_background_color']) {
                $result = $this->model->editHtmlBackgroundColor($id, $this->params['html_background_color']);

                if ($result === true) {
                    if ($this->params['html_background_color'] !== null) {
                        $this->addToColorHistory($this->params['html_background_color']);
                    }
                    $this->logChange($log_property, $this->params['html_background_color']);
                } else {
                    throw new Exception('Unable to update the html/page container background color');
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
            $this->contentBackgroundColor();
        } catch (Exception $e) {
            Dlayer_Helper::sendToErrorLog($e->getMessage());
            return false;
        }

        try {
            $this->htmlBackgroundColor();
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
                'type' => 'tool',
                'id' => 'Page',
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
        Dlayer_Helper::sendToInfoLog("Set {$property} for page: " . $this->page_id .
            ' site_id: ' . $this->site_id . ' new value: ' . $value);
    }

    /**
     * Setup the model
     *
     * @return void
     */
    protected function model()
    {
        if ($this->model === null) {
            $this->model = new Dlayer_DesignerTool_ContentManager_Page_SubTool_Styling_Model();
        }
    }
}
