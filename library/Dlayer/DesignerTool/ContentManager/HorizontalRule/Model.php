<?php

/**
 * Model class for styling tool of horizontal rule
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_HorizontalRule_Model
{
    private $model;

    public function __construct()
    {
        $this->model = new Dlayer_Model_DesignerTool_ContentManager_ContentStyling();
    }

    /**
     * Check to see if there is an existing color defined for the horizontal rule
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id Content id
     *
     * @return integer|false
     */
    public function existingBorderTopColorId($site_id, $page_id, $id)
    {
        return $this->model->existingAttributeId($site_id, $page_id, $id, 'border-top');
    }

    /**
     * Add a new border attribute
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id Content id
     * @param string $color
     *
     * @return boolean
     */
    public function addBorderTopColor($site_id, $page_id, $id, $color)
    {
        return $this->model->addAttributeValue($site_id, $page_id, $id, 'border-top', '1px solid ' . $color);
    }

    /**
     * Edit the horizontal rule border color
     *
     * @param integer $id
     * @param string $color
     *
     * @return boolean
     */
    public function editBorderTopColor($id, $color)
    {
        if (strlen($color) !== 0) {
            $color = '1px solid ' . $color;
        }
        return $this->model->editAttributeValue($id, $color);
    }

    /**
     * Fetch the horizontal rule definition
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id
     *
     * @return array|false
     */
    public function borderTopColor($site_id, $page_id, $id)
    {
        return $this->model->getAttributeValue($site_id, $page_id, $id, 'border-top');
    }
}
