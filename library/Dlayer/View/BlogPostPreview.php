<?php

/**
 * Preview version of the Blog post content item view helper
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_View_BlogPostPreview extends Zend_View_Helper_Abstract
{
    /**
     * Override the hinting for the view property so that we can see the view
     * helpers that have been defined
     *
     * @var Dlayer_View_Codehinting
     */
    public $view;

    /**
     * @var array Data array for the content item
     */
    private $data;

    /**
     * Constructor for view helper, data is set via the setter methods
     *
     * @param array $data Content item data array
     *
     * @return Dlayer_View_BlogPostPreview
     */
    public function blogPostPreview(array $data)
    {
        $this->resetParams();

        $this->data = $data;

        return $this;
    }

    /**
     * Reset any internal params, we do this because the view helper could be called many times within the view script
     *
     * @return void
     */
    private function resetParams()
    {
        $this->data = array();
    }

    /**
     * Generate the html for the content item
     *
     * @return string
     */
    private function render()
    {
        $tag = $this->view->escape($this->data['tag']);

        return '<div><' . $tag . '>' . $this->view->escape($this->data['heading']) .
            ' <small>' . $this->view->escape($this->data['date']) . '</small></' .
            $tag . '>' . $this->data['content'] . '</div>';
    }

    /**
     * The view helper can be output directly, there is no need to call the render method, simply echo or print
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
