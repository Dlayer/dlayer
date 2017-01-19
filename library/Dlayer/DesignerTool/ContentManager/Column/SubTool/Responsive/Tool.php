<?php

/**
 * Responsive sub tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Column_SubTool_Responsive_Tool extends Dlayer_Tool_Content
{
    /**
     * @var Dlayer_DesignerTool_ContentManager_Column_SubTool_Responsive_Model
     */
    private $model;

    /**
     * @var array
     */
    private $current_values = array();

    /**
     * @var boolean
     */
    private $current_values_fetched = false;

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
        if (array_key_exists('xs', $params) === true &&
            array_key_exists('sm', $params) === true &&
            array_key_exists('lg', $params) === true) {
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
        if (trim($params['xs']) === "" || (intval($params['xs']) > 0 && intval($params['xs']) < 13) &&
            trim($params['sm']) === "" || (intval($params['sm']) > 0 && intval($params['sm']) < 13) &&
            trim($params['lg']) === "" || (intval($params['lg']) > 0 && intval($params['lg']) < 13)
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
        foreach (array('xs', 'sm', 'lg') as $column_type) {
            if (array_key_exists($column_type, $params) === true && strlen($params[$column_type]) > 0) {
                $this->params[$column_type] = intval($params[$column_type]);
            }
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
     * Make a structural change to the page
     *
     * @return array|FALSE An array of the environment vars to set or FALSE upon error
     */
    protected function structure()
    {
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
                'type' => 'row_id',
                'id' => $this->row_id,
            ),
            array(
                'type' => 'column_id',
                'id' => $this->column_id,
            ),
            array(
                'type' => 'tool',
                'id' => 'Column',
            ),
            array(
                'type' => 'tab',
                'id' => 'responsive',
                'sub_tool' => 'Responsive'
            )
        );
    }
}
