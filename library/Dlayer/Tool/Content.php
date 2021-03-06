<?php

/**
 * Base class for the content module tools. All tool classes need to define the abstract methods of this class and
 * the Dlayer_Tool class
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
abstract class Dlayer_Tool_Content
{
    protected $site_id = null;
    protected $page_id = null;
    protected $row_id = null;
    protected $column_id = null;
    protected $content_id = null;

    protected $params = array();
    protected $params_auto = array();

    protected $validated = false;
    protected $validated_auto = false;

    /**
     * Validate the posted params, checks to ensure the correct params exists and then checks to ensure that the values
     * are of the correct format and if necessary within the acceptable range. If the data is valid it is written to
     * the class properties so we don't need to pass the data in again, the process method can called directly if
     * validation was successful
     *
     * @param array $params
     * @param integer $site_id
     * @param integer $page_id
     * @param integer|NULL $row_id
     * @param integer|NULL $column_id
     * @param integer|NULL $content_id
     * @return boolean
     */
    public function validate(
        array $params,
        $site_id,
        $page_id,
        $row_id = null,
        $column_id = null,
        $content_id = null
    ) {
        $this->site_id = $site_id;
        $this->page_id = $page_id;
        $this->row_id = $row_id;
        $this->column_id = $column_id;
        $this->content_id = $content_id;

        if ($this->paramsExist($params) === true && $this->paramsValid($params) === true) {
            $this->validated = true;
            $this->paramsAssign($params);

            // Assign instances param if necessary
            if ($this->content_id !== null && $this->validateInstances($this->site_id, $this->content_id) === true) {
                $this->params['instances'] = intval($params['instances']);
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Validate the posted params, checks to ensure the correct params exists and then checks to ensure that the values
     * are of the correct format and if necessary within the acceptable range. If the data is valid it is written to
     * the class properties so we don't need to pass the data in again, the process method can called directly if
     * validation was successful
     *
     * The auto methods are used for structural changes to the page, the validateAuto function writes the params to
     * $this->params_auto once validated
     *
     * @param array $params
     * @param integer $site_id
     * @param integer $page_id
     * @param integer|NULL $row_id
     * @param integer|NULL $column_id
     * @return boolean
     */
    public function validateAuto(array $params, $site_id, $page_id, $row_id = null, $column_id = null)
    {
        if ($this->paramsExist($params) === true && $this->paramsValid($params)) {
            $this->site_id = $site_id;
            $this->page_id = $page_id;
            $this->row_id = $row_id;
            $this->column_id = $column_id;

            $this->paramsAssign($params, false);

            $this->validated_auto = true;

            return true;
        } else {
            return false;
        }
    }

    /**
     * Check that the required params have been submitted, check the keys in the params array
     *
     * @param array $params
     * @return boolean
     */
    abstract protected function paramsExist(array $params);

    /**
     * Check to ensure the posted params are of the correct type and optionally within range
     *
     * @param array $params
     * @return boolean
     */
    abstract protected function paramsValid(array $params);

    /**
     * Prepare the posted params, convert them to the required types and assign to the $this->params property
     *
     * @param array $params
     * @param boolean $manual_tool Are the values to be assigned to $this->params or $this->params_auto
     * @return void
     */
    abstract protected function paramsAssign(array $params, $manual_tool = true);

    /**
     * Validate the instances param, need to see if it should exist first
     *
     * @param integer $site_id
     * @param integer $content_id
     * @return boolean
     */
    abstract protected function validateInstances($site_id, $content_id);

    /**
     * Process the request for a manual tool, this will either add a new item/setting or edit the details for an
     * existing item/setting, the method will check the value of $this->validated before processing the request
     *
     * @return array|FALSE New environment ids or FALSE upon failure
     * @throws Exception
     */
    public function process()
    {
        if ($this->validated === true) {
            if ($this->content_id === null) {
                $ids = $this->add();
            } else {
                $ids = $this->edit();
            }

            return $ids;
        } else {
            return false;
        }
    }

    /**
     * Process the request for the auto tools, auto tools handle structural changes to the content page
     *
     * @return array|FALSE An array of the environment vars to set or FALSE upon failure
     */
    public function processAuto()
    {
        if ($this->validated_auto === true) {
            $ids = $this->structure();

            return $ids;
        } else {
            return false;
        }
    }

    /**
     * Add a new content item or setting
     *
     * @return array|FALSE Ids for new environment vars or FALSE if the request failed
     */
    abstract protected function add();

    /**
     * Add a new content item or setting
     *
     * @param string $content_type
     * @return integer|FALSE Either the id or false
     */
    protected function addContentItem($content_type)
    {
        $model_content = new Dlayer_Model_Page();

        return $model_content->addContentItem($this->site_id, $this->page_id, $this->column_id, $content_type);
    }

    /**
     * Edit a new content item or setting
     *
     * @return array|FALSE Ids for new environment vars or FALSE if the request failed
     * @throws Exception
     */
    abstract protected function edit();

    /**
     * Make a structural change to the page
     *
     * @return array|FALSE An array of the environment vars to set or FALSE upon error
     */
    abstract protected function structure();
}
