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

        $model = new Dlayer_DesignerTool_ContentManager_Shared_Model_Typography();

        if ($model->fontFamilyIdValid($params['font_family_id']) === true &&
            $model->textWeightIdValid($params['text_weight_id']) === true) {
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
     * @return array|FALSE Ids for new environment vars or FALSE if the request failed
     * @throws Exception
     */
    protected function edit()
    {
        $this->fontFamily();
        $this->textWeight();

        $this->cleanUp();

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
        $model = new Dlayer_DesignerTool_ContentManager_Shared_Model_Typography();

        $id = $model->existingFontAndTextValues($this->site_id, $this->page_id, $this->content_id);

        if ($id === false && $this->params['font_family_id'] !== DEFAULT_FONT_FAMILY_FOR_MODULE) {
            try {
                $model->addFontFamily(
                    $this->site_id,
                    $this->page_id,
                    $this->content_id,
                    $this->params['font_family_id']
                );

                Dlayer_Helper::sendToInfoLog('Set font family for content item: ' . $this->content_id .
                    ' site_id: ' . $this->site_id . ' page id: ' . $this->page_id .
                    ' row id: ' . $this->row_id . ' column id: ' . $this->column_id);
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), $e->getCode(), $e);
            }
        } else {
            try {
                $model->editFontFamily($id, $this->params['font_family_id']);
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), $e->getCode(), $e);
            }
        }
    }

    /**
     * Manage the text weight for a content item
     *
     * @return void
     * @throws Exception
     */
    protected function textWeight()
    {
        $model = new Dlayer_DesignerTool_ContentManager_Shared_Model_Typography();

        $id = $model->existingFontAndTextValues($this->site_id, $this->page_id, $this->content_id);

        if ($id === false && $this->params['text_weight_id'] !== DEFAULT_TEXT_WEIGHT_FOR_MODULE)  {
            try {
                $model->addTextWeight(
                    $this->site_id,
                    $this->page_id,
                    $this->content_id,
                    $this->params['text_weight_id']
                );

                Dlayer_Helper::sendToInfoLog('Set text weight content item: ' . $this->content_id .
                    ' site_id: ' . $this->site_id . ' page id: ' . $this->page_id .
                    ' row id: ' . $this->row_id . ' column id: ' . $this->column_id);
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), $e->getCode(), $e);
            }
        } else {
            try {
                $model->editTextWeight($id, $this->params['text_weight_id']);
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), $e->getCode(), $e);
            }
        }
    }

    /**
     * Clean up the typography table if required, don't want null values stored if not necessary
     */
    protected function cleanUp()
    {
        $model = new Dlayer_DesignerTool_ContentManager_Shared_Model_Typography();

        $model->cleanUp($this->site_id, $this->page_id, $this->content_id);
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
}
