<?php

/**
 * The page designer class allows us to fetch the different structure groups that are used to generate a page,
 * columns, rows and content. The data is passed to the views where a view helper for each data type will be called,
 * these will in turn call additional child view helpers to apply the styles
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Designer_ContentPage
{
    private $site_id;
    private $page_id;

    private $model_page;

    /**
     * Pass in anything needed to set up the object
     *
     * @param integer $site_id
     * @param integer $page_id
     */
    public function __construct($site_id, $page_id)
    {
        $this->site_id = $site_id;
        $this->page_id = $page_id;

        $this->model_page = new Dlayer_Model_View_ContentPage();
    }

    /**
     * Fetch all the content that has been assigned to the selected content page, the content is indexed by row and
     * assigned to the page by the view helpers
     *
     * @return array
     */
    public function content()
    {
        return $this->model_page->content($this->site_id, $this->page_id);
    }

    /**
     * Fetch all the content rows that have been added to the selected content page, these are passed to the content
     * page view helper
     *
     * @return array
     */
    public function rows()
    {
        return $this->model_page->rows($this->site_id, $this->page_id);
    }

    /**
     * Fetch all the columns that have been added to the selected content page, these are passed to the content page
     * view helper
     *
     * @return array
     */
    public function columns()
    {
        return $this->model_page->columns($this->site_id, $this->page_id);
    }

    /**
     * Fetch all the styles for the content items that have been assigned to the current page
     *
     * @return array
     */
    public function contentItemStyles()
    {
        return array();
    }
}
