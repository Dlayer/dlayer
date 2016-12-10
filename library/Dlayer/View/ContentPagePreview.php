<?php

/**
 * Preview version of the content page view helper
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_View_ContentPagePreview extends Zend_View_Helper_Abstract
{
	/**
	 * Override the hinting for the view property so that we can see the view helpers that have been defined
	 *
	 * @var Dlayer_View_Codehinting
	 */
	public $view;

	/**
	 * @var string
	 */
	private $html;

	private $page_id;

	/**
	 * Pass in anything required to set up the object
	 *
     * @param integer $page_id
	 * @param array $rows The rows that make up the content page
	 * @param array $columns The columns that make up the content page
	 * @param array $content Contains the raw data to generate the content items and assign them to their row
	 * @return Dlayer_View_ContentPagePreview
	 */
	public function contentPagePreview($page_id, array $rows, array $columns, array $content)
	{
	    $this->page_id = $page_id;
		$this->view->rowPreview()->setRows($rows);
		$this->view->columnPreview()->setColumns($columns);
		$this->view->contentPreview()->setContent($content);

		return $this;
	}

    /**
     * Pass in the styling data for the page
     *
     * @param array $page_styles
     * @param array $row_styles
     * @param array $column_styles
     * @param array $content_item_styles
     *
     * @return Dlayer_View_ContentPagePreview
     */
    public function setStyles(
        array $page_styles,
        array $row_styles,
        array $column_styles,
        array $content_item_styles)
    {
        $this->view->stylingPage()->setStyles($page_styles);
        $this->view->stylingColumn()->setStyles($column_styles);
        $this->view->stylingRow()->setStyles($row_styles);
        $this->view->stylingContentItem()->setStyles($content_item_styles);

        return $this;
    }

	/**
	 * Generates the base structure for the page and then calls a recursive method to do the rest of the work
	 *
	 * @return string
	 * @throws \Exception
	 */
	private function render()
	{
		$this->view->rowPreview()->setColumnId(0);

		$this->html = '<div class="container" ' . $this->view->stylingPage()->setPage($this->page_id) . '>';
		$this->html .= $this->view->rowPreview()->render();
		$this->html .= '</div>';

		return $this->html;
	}


	/**
	 * THis view helper can be ouput directly using print and echo, there is no
	 * need to call the render method. The __toString method is defined to allow
	 * this functionality, all it does it call the render method
	 *
	 * @return string The html generated by the render method
	 */
	public function __toString()
	{
		return $this->render();
	}
}
