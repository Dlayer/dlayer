<?php

/**
 * Styling sub tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Image_SubTool_Styling_Tool extends Dlayer_Tool_Content
{
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
        $this->backgroundColorContentItem();

        return $this->returnIds();
    }

    /**
     * Manage the background colour for a content item
     *
     * @return void
     * @throws Exception
     */
    protected function backgroundColorContentItem()
    {
        $model_heading = new Dlayer_DesignerTool_ContentManager_Heading_SubTool_Styling_Model();
        $model_palette = new Dlayer_Model_Palette();

        $id = $model_heading->existingBackgroundColor($this->site_id, $this->page_id, $this->content_id);

        if ($id === false) {
            try {
                $model_heading->addBackgroundColor(
                    $this->site_id,
                    $this->page_id,
                    $this->content_id,
                    $this->params['content_background_color']
                );
                $model_palette->addToHistory($this->site_id, $this->params['content_background_color']);
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), $e->getCode(), $e);
            }
        } else {
            try {
                $model_heading->editBackgroundColor($id, $this->params['content_background_color']);
                if ($this->params['content_background_color'] !== null && strlen($this->params['content_background_color']) === 7) {
                    $model_palette->addToHistory($this->site_id, $this->params['content_background_color']);
                }
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), $e->getCode(), $e);
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
                'id' => 'Image',
            ),
            array(
                'type' => 'tab',
                'id' => 'styling',
                'sub_tool' => 'Styling'
            ),
            array(
                'type' => 'content_id',
                'id' => $this->content_id,
                'content_type' => 'image'
            )
        );
    }
}
