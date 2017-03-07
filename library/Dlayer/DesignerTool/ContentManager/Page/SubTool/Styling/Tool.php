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
    protected function contentBackgroundColor()
    {
        /**
         * @todo Add a check to see if current matches new, if so we don't need to do any of the below
         */
        $model_styling = new Dlayer_DesignerTool_ContentManager_Page_SubTool_Styling_Model();
        $model_palette = new Dlayer_Model_Palette();

        $id = $model_styling->existingContentBackgroundColorId($this->site_id, $this->page_id);

        if ($id === false) {
            try {
                $model_styling->addContentBackgroundColor(
                    $this->site_id,
                    $this->page_id,
                    $this->params['content_background_color']
                );

                $model_palette->addToHistory($this->site_id, $this->params['content_background_color']);

                Dlayer_Helper::sendToInfoLog('Set background colour for page: ' . $this->content_id .
                    ' site_id: ' . $this->site_id . ' page id: ' . $this->page_id);
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), $e->getCode(), $e);
            }
        } else {
            try {
                $model_styling->editContentBackgroundColor($id, $this->params['content_background_color']);
                if ($this->params['content_background_color'] !== null && strlen($this->params['content_background_color']) === 7) {
                    $model_palette->addToHistory($this->site_id, $this->params['content_background_color']);

                    Dlayer_Helper::sendToInfoLog('Set background colour for page: ' . $this->content_id .
                        ' site_id: ' . $this->site_id . ' page id: ' . $this->page_id);
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
        $this->contentBackgroundColor();

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
}
