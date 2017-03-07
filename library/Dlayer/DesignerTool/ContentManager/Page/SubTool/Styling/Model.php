<?php

/**
 * Model class for styling sub tool, no direct database access calls utility model class.
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Page_SubTool_Styling_Model
{
    private $model;

    public function __construct()
    {
        $this->model = new Dlayer_Model_DesignerTool_ContentManager_PageStyling();
    }

    /**
     * Fetch the background colour assigned to the content section of the page
     *
     * @param integer $site_id
     * @param integer $page_id
     *
     * @return array|false
     */
    public function contentBackgroundColor($site_id, $page_id)
    {
        return $this->model->getContentAttributeValue($site_id, $page_id, 'background-color');
    }

    /**
     * Fetch the background colour assigned to the html
     *
     * @param integer $site_id
     *
     * @return array|false
     */
    public function htmlBackgroundColor($site_id)
    {
        return $this->model->getHtmlAttributeValue($site_id, 'background-color');
    }

    /**
     * Check to see if there is an existing background colour defined for the content container
     *
     * @param integer $site_id
     * @param integer $page_id
     *
     * @return integer|false
     */
    public function existingContentBackgroundColorId($site_id, $page_id)
    {
        return $this->model->existingContentAttributeId($site_id, $page_id, 'background-color');
    }

    /**
     * Add a new background color for the content container
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param string $color
     *
     * @return boolean
     */
    public function addContentBackgroundColor($site_id, $page_id, $color)
    {
        return $this->model->addContentAttributeValue($site_id, $page_id, 'background-color', $color);
    }

    /**
     * Edit the background color for the content page, optionally delete any existing value
     *
     * @param integer $id
     * @param string $color
     *
     * @return boolean
     */
    public function editContentBackgroundColor($id, $color)
    {
        return $this->model->editContentAttributeValue($id, $color);
    }
}
