<?php

/**
 * Handler class for the content manager tools, called by the content manager Ajax method, simply passes the
 * request off to the specific ribbon class for the tool
 *
 * The handlers are similar for each of the designers, the difference being the designer environment variables that are
 * passed in
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Ribbon_Handler_Content
{
    /**
     * @var integer $site_id Id of the selected site
     */
    private $site_id;

    /**
     * @var integer $page_id Id of the selected page
     */
    private $page_id;

    /**
     * @var integer $multi_use Is the tool a multi use tool?
     */
    private $multi_use;

    /**
     * @var boolean $edit_mode Is the tool in what would be considered edit mode
     */
    private $edit_mode;

    /**
     * @var integer|NULL Id of the selected row, if any
     */
    private $row_id;

    /**
     * @var integer|NULL Id of the selected row, if any
     */
    private $column_id;

    /**
     * @var integer|NULL Id of the selected content item, if any
     */
    private $content_id;

    /**
     * Constructor for class, set required data
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param string $tool
     * @param string $tab
     * @param integer $multi_use
     * @param boolean $edit_mode
     * @param integer|NULL $row_id
     * @param integer|NULL $column_id
     * @param integer|NULL $content_id
     *
     * @return array|FALSE Returns an array of the data necessary to create the tool tab for the tool or FALSE if
     * there is no data or something went wrong
     */
    public function viewData(
        $site_id,
        $page_id,
        $tool,
        $tab,
        $multi_use,
        $edit_mode = false,
        $row_id = null,
        $column_id = null,
        $content_id = null
    ) {
        $this->site_id = $site_id;
        $this->page_id = $page_id;
        $this->multi_use = $multi_use;
        $this->edit_mode = $edit_mode;
        $this->row_id = $row_id;
        $this->column_id = $column_id;
        $this->content_id = $content_id;

        switch ($tool) {
            case 'AddColumn':
                $data = $this->addColumn($tool, $tab);
                break;

            case 'AddRow':
                $data = $this->addRow($tool, $tab);
                break;

            case 'Column':
                $data = false;
                break;

            case 'Form':
                $data = $this->form($tool, $tab);
                break;

            case 'Heading':
                $data = $this->heading($tool, $tab);
                break;

            case 'Image':
                $data = $this->image($tool, $tab);
                break;

            case 'Jumbotron':
                $data = $this->jumbotron($tool, $tab);
                break;

            case 'Page':
                $data = $this->page($tool, $tab);
                break;

            case 'Row':
                $data = false;
                break;

            case 'Text':
                $data = $this->text($tool, $tab);
                break;

            default:
                $data = false;
                break;
        }

        return $data;
    }

    /**
     * Base tool params, uses by every tool, accessible via $data['tool'] in the view
     *
     * @todo Once all the tool have been updated move this method, could be in controller
     *
     * @param string $tool
     *
     * @return array
     */
    private function toolParams($tool)
    {
        return array(
            'site_id' => $this->site_id,
            'name' => $tool,
            'page_id' => $this->page_id,
            'column_id' => $this->column_id,
            'row_id' => $this->row_id,
            'content_id' => $this->content_id,
            'multi_use' => $this->multi_use,
        );
    }

    /**
     * Fetch the view data for the add column tool, very simple tool, currently no ribbon class, just going to
     * return an array containing the data for the hidden fields
     *
     * @param string $tool The tool name
     * @param string $tab The tool tab name
     *
     * @return array|FALSE
     */
    private function addColumn($tool, $tab)
    {
        switch ($tab) {
            case 'add-column':
                $data = array(
                    'tool' => $this->toolParams($tool),
                );
                break;

            default:
                $data = false;
                break;
        }

        return $data;
    }

    /**
     * Fetch the view data for the add row tool, very simple tool, currently no ribbon class, just going to
     * return an array containing the data for the hidden fields
     *
     * @param string $tool The tool name
     * @param string $tab The tool tab name
     *
     * @return array|FALSE
     */
    private function addRow($tool, $tab)
    {
        switch ($tab) {
            case 'add-row':
                $data = array(
                    'tool' => $this->toolParams($tool),
                );
                break;

            default:
                $data = false;
                break;
        }

        return $data;
    }

    /**
     * Fetch the view tab data for the text tool, returns an array containing the form and the data for the tool
     *
     * @param string $tool The tool name
     * @param string $tab The tool tab name
     *
     * @return array|FALSE
     */
    private function text($tool, $tab)
    {
        switch ($tab) {
            case 'text':
                $ribbon_text = new Dlayer_DesignerTool_ContentManager_Text_Ribbon();
                $data = $ribbon_text->viewData($this->toolParams($tool));
                break;

            case 'styling':
                $ribbon_styling = new Dlayer_DesignerTool_ContentManager_Text_SubTool_Styling_Ribbon();
                $data = $ribbon_styling->viewData($this->toolParams($tool));
                break;

            default:
                $data = false;
                break;
        }

        return $data;
    }

    /**
     * Fetch the view tab data for the text tool, returns an array containing the form and the data for the tool
     *
     * @param string $tool The tool name
     * @param string $tab The tool tab name
     *
     * @return array|FALSE
     */
    private function heading($tool, $tab)
    {
        switch ($tab) {
            case 'heading':
                $ribbon_heading = new Dlayer_DesignerTool_ContentManager_Heading_Ribbon();
                $data = $ribbon_heading->viewData($this->toolParams($tool));
                break;

            default:
                $data = false;
                break;
        }

        return $data;
    }

    /**
     * Fetch the view tab data for the jumbotron tool, returns an array containing the form and the data for the tool
     *
     * @param string $tool The tool name
     * @param string $tab The tool tab name
     *
     * @return array|FALSE
     */
    private function jumbotron($tool, $tab)
    {
        switch ($tab) {
            case 'jumbotron':
                $ribbon_jumbotron = new Dlayer_DesignerTool_ContentManager_Jumbotron_Ribbon();
                $data = $ribbon_jumbotron->viewData($this->toolParams($tool));
                break;

            default:
                $data = false;
                break;
        }

        return $data;
    }

    /**
     * Fetch the view tab data for the import form tools, returns an array containing the form and the data for the tool
     *
     * @param string $tool The tool name
     * @param string $tab The tool tab name
     *
     * @return array|FALSE
     */
    private function form($tool, $tab)
    {
        switch ($tab) {
            case 'form':
                $ribbon_form = new Dlayer_DesignerTool_ContentManager_Form_Ribbon();
                $data = $ribbon_form->viewData($this->toolParams($tool));
                break;

            default:
                $data = false;
                break;
        }

        return $data;
    }

    /**
     * Fetch the view tab data for the image tools, returns an array containing the form and the data for the tool
     *
     * @param string $tool The tool name
     * @param string $tab The tool tab name
     *
     * @return array|FALSE
     */
    private function image($tool, $tab)
    {
        switch ($tab) {
            case 'image':
                $ribbon_image = new Dlayer_DesignerTool_ContentManager_Image_Ribbon();
                $data = $ribbon_image->viewData($this->toolParams($tool));
                break;

            default:
                $data = false;
                break;
        }

        return $data;
    }

    /**
     * Fetch the view tab data for the image tools, returns an array containing the form and the data for the tool
     *
     * @param string $tool The tool name
     * @param string $tab The tool tab name
     *
     * @return array|FALSE
     */
    private function page($tool, $tab)
    {
        return false;
    }
}
