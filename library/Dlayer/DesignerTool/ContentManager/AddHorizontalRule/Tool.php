<?php

/**
 * Add a Horizontal rule content item tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_AddHorizontalRule_Tool extends Dlayer_Tool_Content
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
        if (array_key_exists('name', $params) === true) {
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
        if (strlen(trim($params['name'])) > 0) {
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
            'name' => trim($params['name'])
        );
    }

    /**
     * Add a new content item or setting
     *
     * @return array|false Ids for new environment vars or FALSE if the request failed
     */
    protected function add()
    {
        $data_added = false;
        $content_id = $this->addContentItem('HorizontalRule');

        if ($content_id !== false) {
            Dlayer_Helper::sendToInfoLog('Horizontal rule added to site id: ' . $this->site_id . ' page id: ' .
                $this->page_id . ' row id: ' . $this->row_id . ' column id: ' . $this->column_id);

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
        // Not required by tool
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
                'id' => 'HorizontalRule',
            ),
            array(
                'type' => 'content_id',
                'id' => $this->content_id,
                'content_type' => 'HorizontalRule'
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
        return false;
    }
}
