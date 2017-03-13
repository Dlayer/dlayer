<?php

/**
 * Shared model class for styling tools
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Shared_Model_Content_Styling
{
    private $model;

    public function __construct()
    {
        $this->model = new Dlayer_Model_DesignerTool_ContentManager_ContentStyling();
    }

    /**
     * Check to see if there is an existing background color for the content item
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id Content id
     *
     * @return integer|false
     */
    public function existingBackgroundColorId($site_id, $page_id, $id)
    {
        return $this->model->existingAttributeId($site_id, $page_id, $id, 'background-color');
    }

    /**
     * Add a new background color to the content item
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id Content id
     * @param string $color
     *
     * @return boolean
     */
    public function addBackgroundColor($site_id, $page_id, $id, $color)
    {
        return $this->model->addAttributeValue($site_id, $page_id, $id, 'background-color', $color);
    }

    /**
     * Edit the set background color, removes the value is being cleared
     *
     * @param integer $id
     * @param string $color
     *
     * @return boolean
     */
    public function editBackgroundColor($id, $color)
    {
        return $this->model->editAttributeValue($id, $color);
    }

    /**
     * Fetch the current background color
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id
     *
     * @return array|false
     */
    public function backgroundColor($site_id, $page_id, $id)
    {
        return $this->model->getAttributeValue($site_id, $page_id, $id, 'background-color');
    }
}
