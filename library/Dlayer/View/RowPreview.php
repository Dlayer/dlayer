<?php

/**
 * Preview version of the row view helper
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_View_RowPreview extends Zend_View_Helper_Abstract
{
	/**
	 * Override the hinting for the view property so that we can see the view
	 * helpers that have been defined
	 *
	 * @var Dlayer_View_Codehinting
	 */
	public $view;

	/**
	 * @var array Rows array for the entire content page
	 */
	private $rows;

	/**
	 * @var integer Id of the current column
	 */
	private $column_id;

	/**
	 * Constructor for view helper, data is set via the setter methods
	 *
	 * @return Dlayer_View_RowPreview
	 */
	public function rowPreview()
	{
		return $this;
	}

	/**
	 * Set the column id for the column for which we need to generate the rows, 0 is a valid value, these rows will
	 * be applied top the base container div
	 *
	 * @param integer $id
	 * @return Dlayer_View_RowPreview
	 */
	public function setColumnId($id)
	{
		$this->column_id = $id;

		return $this;
	}

	/**
	 * Pass in the rows data for the content page. The rows data is passed in using this setter because the view helper
	 * will be called many times to generate a content page and we only want to pass what could be a very large data
	 * array once
	 *
	 * @param array $rows
	 * @return Dlayer_View_Row
	 */
	public function setRows(array $rows)
	{
		$this->rows = $rows;

		return $this;
	}

	/**
	 * Generate the html for the content rows, it checks to see if there are any rows for the currently set column and
	 * then generate the required html
	 *
	 * Unlike the majority of the view helpers within Dlayer the render method is public, we will be calling it
	 * directly from other view helpers
	 */
	public function render()
	{
		$html = '';

		if(array_key_exists($this->column_id, $this->rows) === TRUE)
		{
			foreach($this->rows[$this->column_id] as $row)
			{
				$this->view->columnPreview()->setRowId($row['id']);
				$columns = $this->view->columnPreview()->render();

				if(strlen($columns) > 0)
				{
					$html .= '<div class="row" id="row-' . $row['id'] . '">' . $columns . '</div>';
				}
			}
		}

		return $html;
	}
}
