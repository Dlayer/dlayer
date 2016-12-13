<?php

/**
 * Typography sub tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Heading_SubTool_Typography_Tool extends Dlayer_Tool_Content
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
        if (array_key_exists('font_family_id', $params) === true) {
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

        $model = new Dlayer_DesignerTool_ContentManager_Heading_SubTool_Typography_Model();

        if($model->fontFamilyIdValid($params['font_family_id']) === true) {
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
        $this->fontFamily();

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
        $model = new Dlayer_DesignerTool_ContentManager_Heading_SubTool_Typography_Model();

        $id = $model->existingFontFamily($this->site_id, $this->page_id, $this->content_id);

        if ($id === false) {
            try {
                $model->addFontFamily(
                    $this->site_id,
                    $this->page_id,
                    $this->content_id,
                    $this->params['font_family_id']
                );

                Dlayer_Helper::sendToInfoLog('Set font family for heading content item: ' . $this->content_id .
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
                'id' => 'Heading',
            ),
            array(
                'type' => 'tab',
                'id' => 'typography',
                'sub_tool' => 'Typography'
            ),
            array(
                'type' => 'content_id',
                'id' => $this->content_id,
                'content_type' => 'heading'
            )
        );
    }
}
