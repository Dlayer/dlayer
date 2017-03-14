<?php

/**
 * Rich text content item tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_RichText_Tool extends Dlayer_Tool_Content
{
    /**
     * Check that the required params have been submitted, check the keys in the params array
     *
     * @param array $params
     * @return boolean
     */
    protected function paramsExist(array $params)
    {
        $valid = false;
        if (array_key_exists('name', $params) === true && array_key_exists('content', $params) === true) {
            $valid = true;
        }

        return $valid;
    }

    /**
     * Check to ensure the posted params are of the correct type and optionally within range
     *
     * @param array $params
     * @return boolean
     */
    protected function paramsValid(array $params)
    {
        $valid = false;
        if (strlen(trim($params['name'])) > 0 && strlen(trim($params['content'])) > 0) {
            $valid = true;
        }
        return $valid;
    }

    /**
     * Prepare the posted params, convert them to the required types and assign to the $this->params property
     *
     * @param array $params
     * @param boolean $manual_tool Are the values to be assigned to $this->params or $this->params_auto
     * @return void
     */
    protected function paramsAssign(array $params, $manual_tool = true)
    {
        $this->params = array(
            'name' => trim($params['name']),
            'content' => trim($params['content'])
        );
    }

    /**
     * Add a new content item or setting
     *
     * @return array|FALSE Ids for new environment vars or FALSE if the request failed
     */
    protected function add()
    {
        $data_added = false;
        $content_id = $this->addContentItem('RichText');

        if ($content_id !== false) {
            $model = new Dlayer_DesignerTool_ContentManager_RichText_Model();
            $data_added = $model->add($this->site_id, $this->page_id, $content_id, $this->params);
        }

        if ($content_id !== false && $data_added === true) {
            Dlayer_Helper::sendToInfoLog('Rich text added to site id: ' . $this->site_id . ' page id: ' . $this->page_id .
                ' row id: ' . $this->row_id . ' column id: ' . $this->column_id);

            return $this->returnIds($content_id);
        } else {
            return false;
        }
    }

    /**
     * Edit a new content item or setting
     *
     * @return array|FALSE Ids for new environment vars or FALSE if the request failed
     * @throws Exception
     */
    protected function edit()
    {
        $model = new Dlayer_DesignerTool_ContentManager_RichText_Model();

        try {
            $edit = $model->edit($this->site_id, $this->page_id, $this->content_id, $this->params);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }

        if ($edit === true) {
            return $this->returnIds();
        } else {
            return false;
        }
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
     * Generate the return ids array
     *
     * @param integer|NULL Set content id or use the class property
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
                'id' => 'RichText',
            ),
            array(
                'type' => 'content_id',
                'id' => $this->content_id,
                'content_type' => 'RichText'
            )
        );
    }

    /**
     * Validate the instances param, need to see if it should exist first
     *
     * @param integer $site_id
     * @param integer $content_id
     * @return boolean
     */
    protected function validateInstances($site_id, $content_id)
    {
        $model = new Dlayer_DesignerTool_ContentManager_Shared_Model_Content_Item();
        $instances = $model->instancesOfData($site_id, $content_id, 'RichText');

        if ($instances > 1) {
            return true;
        } else {
            return false;
        }
    }
}
