<?php

/**
 * Styling view helper for the rows, calls child view helpers for each styling group
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_View_StylingRow extends Zend_View_Helper_Abstract
{
    /**
     * Override the hinting for the view property so that we can see the view helpers that have been defined
     *
     * @var Dlayer_View_Codehinting
     */
    public $view;

    /**
     * @var array The complete style array
     */
    private $styles;

    /**
     * @var integer The id of the column currently being looked at
     */
    private $id;

    /**
     * View helper constructor, pass in anything that may be needed to create the object
     *
     * @return Dlayer_View_StylingRow
     */
    public function stylingRow()
    {
        return $this;
    }

    /**
     * Set the base styles data array
     *
     * @param array $styles Styles data array for all the rows that make up the page
     * @return Dlayer_View_StylingRow
     */
    public function setStyles(array $styles)
    {
        $this->styles = $styles;

        return $this;
    }

    /**
     * Set the id of the row the view helper needs to generate styles for
     *
     * @param integer $id
     * @return Dlayer_View_StylingRow
     */
    public function setRow($id)
    {
        $this->resetParams();

        $this->id = $id;

        return $this;
    }

    /**
     * Reset any internal params, allows us to call the view helper multiple times within the same view. The base
     * styles data array is not reset, that will not change for additional calls
     *
     * @return void
     */
    private function resetParams()
    {
        $this->id = null;
    }

    /**
     * Worker method for the view helper
     *
     * @return string
     */
    private function render()
    {
        $styles = '';

        if(array_key_exists('background_color', $this->styles) === true &&
        array_key_exists($this->id, $this->styles['background_color']) === true) {
            $styles .= $this->view->stylingAttributeBackgroundColor($this->styles['background_color'][$this->id]);
        }

        if(strlen($styles) > 0) {
            $styles = ' style="' . $styles . '"';
        }

        return $styles;
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
