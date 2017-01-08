<?php

/**
 * Form content item view helper
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_View_ImportedForm extends Zend_View_Helper_Abstract
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
     * @var boolean Is the content item selectable?
     */
    private $selectable;

    /**
     * @var boolean Is the content item selected?
     */
    private $selected;

    /**
     * Constructor for view helper, data is set via the setter methods
     *
     * @param array $data Content item data array
     * @param boolean $selectable
     * @param boolean $selected
     * @return Dlayer_View_ImportedForm
     */
    public function importedForm(array $data, $selectable = false, $selected = false)
    {
        $this->resetParams();

        $this->data = $data;
        $this->selectable = $selectable;
        $this->selected = $selected;

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
        $this->selectable = false;
        $this->selected = false;
    }

    /**
     * Generate the html for the content item
     *
     * @return string
     */
    private function render()
    {
        $class = 'content';

        if ($this->selectable === true) {
            $class .= ' selectable';
        }
        if ($this->selected === true) {
            $class .= ' selected';
        }

        $html = '<div class="' . $class . '" data-content-id="' . $this->view->escape($this->data['content_id']) .
            '" data-content-type="form" data-tool="Form"' .
            $this->view->stylingContentItem()->setContentItem($this->data['content_id']) . '>';

        $title = false;

        if ($this->data['title'] !== null) {
            $title = '<h2>' . $this->view->escape($this->data['title']);
            if ($this->data['sub_title'] !== null) {
                $title .= ' <small>' . $this->view->escape($this->data['sub_title']) . '</small>';
            }
            $title .= '</h2>';
        }

        if ($title !== false) {
            $html .= $title;
        }

        $html .= $this->data['form']->form();
        $html .= '</div>';

        return $html;
    }

    /**
     * The view helper can be output directly, there is no need to call the render method, simply echo or print
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
        //return '';
    }
}
