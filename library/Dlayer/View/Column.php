<?php

/**
 * Column view helper, this is called by the row view helper, it generates the html for all the columns, it will call
 * the row view helper for each column as columns can only be applied to rows
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_View_Column extends Zend_View_Helper_Abstract
{
	/**
	 * Override the hinting for the view property so that we can see the view
	 * helpers that have been defined
	 *
	 * @var Dlayer_View_Codehinting
	 */
	public $view;

	/**
	 * @var array Columns array for the entire content page
	 */
	private $columns;

	/**
	 * @var integer Id of the current row
	 */
	private $row_id;

	/**
	 * @param integer|NULL Id of the selected column, if any
	 */
	private $selected_column_id;

	/**
	 * Constructor for view helper, data is set via the setter methods
	 *
	 * @return Dlayer_View_Column
	 */
	public function column()
	{
		return $this;
	}

	/**
	 * Set the row id for the row for which we need to generate the columns
	 *
	 * @param integer $id
	 * @return Dlayer_View_Column
	 */
	public function setRowId($id)
	{
		$this->row_id = $id;
	}

	/**
	 * Set the id of the selected column, this controls whether or not the selected class get applied to a column
	 *
	 * @param integer $id Id of the selected column
	 * @return Dlayer_View_Column
	 */
	public function selectedColumnId($id)
	{
		$this->selected_column_id = $id;

		return $this;
	}

	/**
	 * Pass in the columns data for the content page. The columns data is passed in using this setter because the
	 * view helper will be called many times to generate a content page and we only want to pass what could be a
	 * very large data array once
	 *
	 * @param array $columns
	 * @return Dlayer_View_Column
	 */
	public function setColumns(array $columns)
	{
		$this->columns = $columns;

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

		if(array_key_exists($this->row_id, $this->columns) === TRUE)
		{
			foreach($this->columns[$this->row_id] as $column)
			{
				$html .= '<div class="col-' . $column['class'] . '-' . $column['size'] . '">';
				$html .= '<p>This is a column</p>';
				$html .= '</div>';
			}
		}

		return $html;
	}
}
