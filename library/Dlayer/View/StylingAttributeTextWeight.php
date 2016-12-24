<?php

/**
 * Styling view helper, generates the text weight attribute
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_View_StylingAttributeTextWeight extends Zend_View_Helper_Abstract
{
    /**
     * @var string The complete style attribute
     */
    private $style;

    /**
     * @var integer $text_weight
     */
    private $text_weight;

    /**
     * View helper constructor, pass in anything that may be needed to create the object
     *
     * @param integer $text_weight The text weight setting
     *
     * @return Dlayer_View_StylingAttributeTextWeight
     */
    public function stylingAttributeTextWeight($text_weight)
    {
        $this->resetParams();

        $this->text_weight = $text_weight;

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
        $this->text_weight = null;
    }

    /**
     * Worker method for the view helper
     *
     * @return string
     */
    private function render()
    {
        $this->style .= ' font-weight:' . $this->text_weight . ';';

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
