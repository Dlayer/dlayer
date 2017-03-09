<?php

/**
 * Base content view helper, it gets called by the column view helper and generates the data for all the content items
 * that sit in the container. The html for the individual content items is handled by a view helper for each content
 * type
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_View_Content extends Zend_View_Helper_Abstract
{
    /**
     * Override the hinting for the view property so that we can see the view
     * helpers that have been defined
     *
     * @var Dlayer_View_Codehinting
     */
    public $view;

    /**
     * @var array Content data array for the entire page
     */
    private $content = array();

    /**
     * @param integer $column_id id of the current column
     */
    private $column_id;

    /**
     * @param integer|NULL Id of the selected column, if any
     */
    private $selected_column_id;

    /**
     * @param integer|NULL Id of the selected column, if any
     */
    private $selected_content_id;

    /**
     * Constructor for view helper, data is set via the setter methods
     *
     * @return Dlayer_View_Content
     */
    public function content()
    {
        return $this;
    }

    /**
     * Set the column id for the column for which we need to generate data
     *
     * @param integer $id
     * @return Dlayer_View_Content
     */
    public function setColumnId($id)
    {
        $this->column_id = $id;

        return $this;
    }

    /**
     * Set the id of the selected content item, this controls whether or not the selected class get applied to a
     * content item
     *
     * @param integer $id Id of the selected content item
     * @return Dlayer_View_Content
     */
    public function setSelectedContentId($id)
    {
        $this->selected_content_id = $id;

        return $this;
    }

    /**
     * Set the id of the selected column, this controls whether or not the selected class get applied to a column
     *
     * @param integer $id Id of the selected column
     * @return Dlayer_View_Content
     */
    public function setSelectedColumnId($id)
    {
        $this->selected_column_id = $id;

        return $this;
    }

    /**
     * Pass in the content data for the content page. The content data is passed in using this setter because the
     * view helper will be called many times to generate a content page and we only want to pass what could be a
     * very large data array once
     *
     * @param array $content
     * @return Dlayer_View_Content
     */
    public function setContent(array $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Generate the html for the content items, it checks to see if there is any content for the currently set
     * column and then generates the html
     *
     * Unlike the majority of the view helpers within Dlayer the render method is public, we will be calling it
     * directly from other view helpers
     */
    public function render()
    {
        $html = '';

        if (array_key_exists($this->column_id, $this->content) === true) {
            foreach ($this->content[$this->column_id] as $content) {
                $selectable = false;
                $selected = false;

                if ($this->selected_column_id === $this->column_id) {
                    if ($this->selected_content_id === $content['content_id']) {
                        $selected = true;
                    } else {
                        $selectable = true;
                    }
                }

                switch ($content['type']) {
                    case 'BlogPost':
                        $html .= $this->view->blogPost($content['data'], $selectable, $selected);
                        break;

                    case 'Form':
                        $html .= $this->view->importedForm($content['data'], $selectable, $selected);
                        break;

                    case 'Heading':
                        $html .= $this->view->heading($content['data'], $selectable, $selected);
                        break;

                    case 'HeadingDate':
                        $html .= $this->view->headingDate($content['data'], $selectable, $selected);
                        break;

                    case 'HorizontalRule':
                        $html .= $this->view->horizontalRule($content['data'], $selectable, $selected);
                        break;

                    case 'Html':
                        $html .= $this->view->html($content['data'], $selectable, $selected);
                        break;

                    case 'Image':
                        $html .= $this->view->image($content['data'], $selectable, $selected);
                        break;

                    case 'Jumbotron':
                        $html .= $this->view->jumbotron($content['data'], $selectable, $selected);
                        break;

                    case 'RichText':
                        $html .= $this->view->richText($content['data'], $selectable, $selected);
                        break;

                    case 'Text':
                        $html .= $this->view->text($content['data'], $selectable, $selected);
                        break;

                    default:
                        break;
                }
            }
        }

        return $html;
    }
}
