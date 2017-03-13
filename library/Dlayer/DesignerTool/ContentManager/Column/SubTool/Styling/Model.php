<?php

/**
 * Model class for styling tool of column
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Column_SubTool_Styling_Model
{
    private $model;

    public function __construct()
    {
        $this->model = new Dlayer_Model_DesignerTool_ContentManager_ColumnStyling();
    }

    /**
     * Check to see if there is an existing color defined for the column
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id Column id
     *
     * @return integer|false
     */
    public function existingBackgroundColorId($site_id, $page_id, $id)
    {
        return $this->model->existingAttributeId($site_id, $page_id, $id, 'background-color');
    }

    /**
     * Add a new background color
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id Column id
     * @param string $color
     *
     * @return boolean
     */
    public function addBackgroundColor($site_id, $page_id, $id, $color)
    {
        return $this->model->addAttributeValue($site_id, $page_id, $id, 'background-color', $color);
    }

    /**
     * Edit the column background color
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
     * Fetch the background color
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
