<?php

/**
 * Row view helper, this is called by the content page view helper, called to generated any rows attached to the base
 * container div and then called by each column, rows can only be added to columns and the base container div. It is
 * also responsible for calling the content view helper as content con only sit in rows
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_View_Row extends Zend_View_Helper_Abstract
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
	 * @param integer|NULL Id of the selected row, if any
	 */
	private $selected_row_id;

	/**
	 * @param integer|NULL Id of the selected column, if any
	 */
	private $selected_column_id;

	/**
	 * @param integer|NULL Id of the selected content, if any
	 */
	private $selected_content_id;

	/**
	 * Constructor for view helper, data is set via the setter methods
	 *
	 * @return Dlayer_View_Row
	 */
	public function row()
	{
		return $this;
	}

	/**
	 * Set the column id for the column for which we need to generate the rows, 0 is a valid value, these rows will
	 * be applied top the base container div
	 *
	 * @param integer $id
	 * @return Dlayer_View_Row
	 */
	public function setColumnId($id)
	{
		$this->column_id = $id;

		return $this;
	}

	/**
	 * Set the id of the selected content item, this controls whether the selectable css class gets applied to the
	 * content items/columns that have been assigned to the row
	 *
	 * @param integer $id Id of the selected content item, if any
	 * @return Dlayer_View_Row
	 */
	public function setSelectedContentId($id)
	{
		$this->selected_content_id = $id;

		return $this;
	}

	/**
	 * Set the id of the selected row, this controls whether or not the selected class get applied to a row
	 *
	 * @param integer $id Id of the selected row
	 * @return Dlayer_View_Row
	 */
	public function setSelectedRowId($id)
	{
		$this->selected_row_id = $id;

		return $this;
	}

	/**
	 * Set the id of the selected column, this controls whether or not the selectable class get applied to a row
	 *
	 * @param integer $id Id of the selected column
	 * @return Dlayer_View_Row
	 */
	public function setSelectedColumnId($id)
	{
		$this->selected_column_id = $id;

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
				$class = "row";

				if($this->selected_column_id === $row['column_id'])
				{
					if($this->selected_row_id === $row['id'])
					{
						$class .= ' selected';
					}
					else
					{
						$class .= ' selectable';
					}
				}

				$this->view->column()->setRowId($row['id']);
				$this->view->column()->setSelectedRowId($this->selected_row_id);
				$this->view->column()->setSelectedColumnId($this->selected_column_id);
				$this->view->column()->setSelectedContentId($this->selected_content_id);
				$columns = $this->view->column()->render();

				if(strlen($columns) > 0)
				{
					$html .= '<div class="' . $class . '" data-row-id="' . $row['id'] . '">' . $columns . '</div>';
				}
				else
				{
					$html .= '<div class="' . $class . ' empty" data-row-id="' . $row['id'] . '"><p class="text-muted"><em>Empty row</em></p></div>';
				}
			}
		}

		return $html;
	}
}
