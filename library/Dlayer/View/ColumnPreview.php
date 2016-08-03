<?php

/**
 * Preview version of the column view helper
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_View_ColumnPreview extends Zend_View_Helper_Abstract
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
	 * Constructor for view helper, data is set via the setter methods
	 *
	 * @return Dlayer_View_ColumnPreview
	 */
	public function columnPreview()
	{
		return $this;
	}

	/**
	 * Set the row id for the row for which we need to generate the columns
	 *
	 * @param integer $id
	 * @return Dlayer_View_ColumnPreview
	 */
	public function setRowId($id)
	{
		$this->row_id = $id;

		return $this;
	}

	/**
	 * Pass in the columns data for the content page. The columns data is passed in using this setter because the
	 * view helper will be called many times to generate a content page and we only want to pass what could be a
	 * very large data array once
	 *
	 * @param array $columns
	 * @return Dlayer_View_ColumnPreview
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
				$this->view->rowPreview()->setColumnId($column['id']);
				$rows = $this->view->rowPreview()->render();

				$html .= '<div class="column col-' . $column['class'] . '-' . $column['size'] .
					'" id="column-' . $column['id'] . '">';

				if(strlen($rows) > 0)
				{
					$html .= '<p>' . $rows . '</p>';
				}
				else
				{
					$this->view->contentPreview()->setColumnId($column['id']);
					$content = $this->view->contentPreview()->render();

					if(strlen($content) > 0)
					{
						$html .= $content;
					}
					else
					{
						$html .= '<p>Empty column</p>';
					}
				}

				$html .= '</div>';
			}
		}

		return $html;
	}
}
