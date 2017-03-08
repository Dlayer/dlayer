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
    private $model_page;
    private $model_html;

    public function __construct()
    {
        $this->model_page = new Dlayer_Model_DesignerTool_ContentManager_PageStyling();
        $this->model_html = new Dlayer_Model_DesignerTool_ContentManager_HtmlStyling();
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
        return $this->model_page->getAttributeValue($site_id, $page_id, 'background-color');
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
        return $this->model_html->getAttributeValue($site_id, 'background-color');
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
        return $this->model_page->existingAttributeId($site_id, $page_id, 'background-color');
    }

    /**
     * Check to see if there is an existing background colour defined for the pahe/html
     *
     * @param integer $site_id
     *
     * @return integer|false
     */
    public function existingHtmlBackgroundColorId($site_id)
    {
        return $this->model_html->existingAttributeId($site_id, 'background-color');
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
        return $this->model_page->addAttributeValue($site_id, $page_id, 'background-color', $color);
    }

    /**
     * Add a new background color for the html/page
     *
     * @param integer $site_id
     * @param string $color
     *
     * @return boolean
     */
    public function addHtmlBackgroundColor($site_id, $color)
    {
        return $this->model_html->addAttributeValue($site_id, 'background-color', $color);
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
        return $this->model_page->editAttributeValue($id, $color);
    }

    /**
     * Edit the background color for the page/html, optionally delete any existing value
     *
     * @param integer $id
     * @param string $color
     *
     * @return boolean
     */
    public function editHtmlBackgroundColor($id, $color)
    {
        return $this->model_html->editAttributeValue($id, $color);
    }
}
