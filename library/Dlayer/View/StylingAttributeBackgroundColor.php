<?php

/**
 * Styling view helper, generates the background color attribute
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_View_StylingAttributeBackgroundColor extends Zend_View_Helper_Abstract
{
    /**
     * @var string The complete style attribute
     */
    private $style;

    /**
     * @var string $hex
     */
    private $hex;

    /**
     * View helper constructor, pass in anything that may be needed to create the object
     *
     * @param string $hex The background color
     *
     * @return Dlayer_View_StylingAttributeBackgroundColor
     */
    public function stylingAttributeBackgroundColor($hex)
    {
        $this->resetParams();

        $this->hex = $hex;

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
        $this->id = null;
    }

    /**
     * Worker method for the view helper
     *
     * @return string
     */
    private function render()
    {
        $this->style .= 'background-color:' . $this->view->escape($this->hex) . ';';

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
