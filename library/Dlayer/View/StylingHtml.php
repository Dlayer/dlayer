<?php

/**
 * Styling view helper for the HTML, calls child view helpers for each styling group
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_View_StylingHtml extends Zend_View_Helper_Abstract
{
    /**
     * Override the hinting for the view property so that we can see the view helpers that have been defined
     *
     * @var Dlayer_View_Codehinting
     */
    public $view;

    /**
     * @var array Styles data array
     */
    private $styles;

    /**
     * @var integer The id of the page currently being looked at
     */
    private $id;

    /**
     * View helper constructor, pass in anything that may be needed to create the object
     *
     * @return Dlayer_View_StylingHtml
     */
    public function stylingHtml()
    {
        return $this;
    }

    /**
     * Set the base styles data array
     *
     * @param array $styles Styles data array for the page
     * @return Dlayer_View_StylingHtml
     */
    public function setStyles(array $styles)
    {
        $this->styles = $styles;

        return $this;
    }

    /**
     * Worker method for the view helper
     *
     * @return string
     */
    private function render()
    {
        $styles = '';

        if (array_key_exists('background_color', $this->styles) === true &&
            $this->styles['background_color'] !== false) {
            $styles .= $this->view->stylingAttributeBackgroundColor($this->styles['background_color']);
        }

        if (strlen($styles) > 0) {
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
