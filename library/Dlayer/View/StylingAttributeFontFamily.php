<?php

/**
 * Styling view helper, generates the font family attribute
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_View_StylingAttributeFontFamily extends Zend_View_Helper_Abstract
{
    /**
     * @var string The complete style attribute
     */
    private $style;

    /**
     * @var string $hex
     */
    private $font_family;

    /**
     * View helper constructor, pass in anything that may be needed to create the object
     *
     * @param string $font_family The font family setting
     *
     * @return Dlayer_View_StylingAttributeFontFamily
     */
    public function stylingAttributeFontFamily($font_family)
    {
        $this->resetParams();

        $this->font_family = $font_family;

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
        $this->font_family = null;
    }

    /**
     * Worker method for the view helper
     *
     * @return string
     */
    private function render()
    {
        $this->style .= ' font-family:' . $this->view->escape($this->font_family) . ';';

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
