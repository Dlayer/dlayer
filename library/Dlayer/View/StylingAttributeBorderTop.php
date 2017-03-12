<?php

/**
 * Styling view helper, generates the border top attribute
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_View_StylingAttributeBorderTop extends Zend_View_Helper_Abstract
{
    /**
     * @var string The complete style attribute
     */
    private $style;

    /**
     * @var string
     */
    private $border;

    /**
     * View helper constructor, pass in anything that may be needed to create the object
     *
     * @param string $border Border value
     *
     * @return Dlayer_View_StylingAttributeBorderTop
     */
    public function stylingAttributeBorderTop($border)
    {
        $this->resetParams();

        $this->border = $border;

        return $this;
    }

    /**
     * Reset any internal params, allows us to call the view helper multiple times within the same view.
     *
     * @return void
     */
    private function resetParams()
    {
        $this->style = '';
        $this->border = null;
    }

    /**
     * Worker method for the view helper
     *
     * @return string
     */
    private function render()
    {
        $this->style .= ' border-top:' . $this->view->escape($this->border) . ';';

        return $this->style;
    }

    /**
     * This allows us to echo the results of the object directly
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
