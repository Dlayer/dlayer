<?php

/**
 * Styling view helper for the content items, calls child view helpers for each styling group
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_View_StylingContentItem extends Zend_View_Helper_Abstract
{
    /**
     * @var string The complete style attribute
     */
    private $style;

    /**
     * @var integer The id of the content item currently being looked at
     */
    private $id;

    /**
     * View helper constructor, pass in anything that may be needed to create the object
     *
     * @return Dlayer_View_StylingContentItem
     */
    public function stylingContentItem()
    {
        return $this;
    }

    /**
     * Set the base styles data array
     *
     * @param array $styles Styles data array for all the content items that make up the page
     * @return Dlayer_View_StylingContentItem
     */
    public function setStyles(array $styles)
    {
        $this->style = $styles;

        return $this;
    }

    /**
     * Set the id of the content item the view helper needs to generate styles for
     *
     * @param integer $id
     * @return Dlayer_View_StylingContentItem
     */
    public function setContentItem($id)
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
        $this->styles = '';
        $this->id = null;
    }

    /**
     * Worker method for the view helper
     *
     * @return string
     */
    private function render()
    {
        $this->styles .= 'style="background-color:green;"';

        return $this->styles;
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
