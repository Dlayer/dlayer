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
	 * @param integer|NULL Id of the selected row, if any
	 */
	private $selected_row_id;

	/**
	 * @param integer|NULL Id of the selected content, if any
	 */
	private $selected_content_id;

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

		return $this;
	}

	/**
	 * Set the id of the selected content item, this controls whether the selectable css class gets applied to the
	 * content items/columns that have been assigned to the row
	 *
	 * @param integer $id Id of the selected content item, if any
	 * @return Dlayer_View_Column
	 */
	public function setSelectedContentId($id)
	{
		$this->selected_content_id = $id;

		return $this;
	}

	/**
	 * Set the id of the selected column, this controls whether or not the selected class get applied to a column
	 *
	 * @param integer $id Id of the selected column
	 * @return Dlayer_View_Column
	 */
	public function setSelectedColumnId($id)
	{
		$this->selected_column_id = $id;

		return $this;
	}

	/**
	 * Set the id of the selected row, this controls whether or not the selectable class gets applied to the columns
	 *
	 * @param integer $id Id of the selected row
	 * @return Dlayer_View_Column
	 */
	public function setSelectedRowId($id)
	{
		$this->selected_row_id = $id;

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
				$this->view->row()->setColumnId($column['id']);
				$rows = $this->view->row()->render();

				$class = "column";

				if($this->selected_content_id === NULL && $this->selected_row_id === $column['row_id'])
				{
					if($this->selected_column_id === $column['id'])
					{
						$class .= ' selected';
					}
					else
					{
						$class .= ' selectable';
					}
				}

				if(strlen($rows) > 0)
				{
					$content = '<p>' . $rows . '</p>';
				}
				else
				{
					$this->view->content()->setColumnId($column['id']);
					$this->view->content()->setSelectedColumnId($this->selected_column_id);
					$this->view->content()->setSelectedContentId($this->selected_content_id);
					$column_content = $this->view->content()->render();

					if(strlen($column_content) > 0)
					{
						$content = $column_content;
					}
					else
					{
                        if ($this->selected_column_id === $column['id']) {
                            $content = "<div style=\"padding: 3rem 0;\"><div class=\"btn-group\">
                                    <button type=\"button\" class=\"btn btn-primary dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                    Add content item <span class=\"caret\"></span></button>
                                    <ul class=\"dropdown-menu\">
                                        <li><a href=\"/content/design/set-tool/tool/Heading\">Heading</a></li>
                                        <li><a href=\"/content/design/set-tool/tool/Text\">Text</a></li>
                                        <li><a href=\"/content/design/set-tool/tool/Jumbotron\">Jumbotron</a></li>
                                        <li><a href=\"/content/design/set-tool/tool/Html\">HTML</a></li>
                                        <li role=\"separator\" class=\"divider\"></li>
                                        <li><a href=\"/content/design/set-tool/tool/Form\">Form</a></li>
                                        <li><a href=\"/content/design/set-tool/tool/Image\">Image</a></li>
                                    </ul>
                                </div></div>";
                        } else {
                            $content = '<p class="text-muted"><em>Empty column</em></p>';
                        }
						$class .= ' empty';
					}
				}

				$html .= '<div class="' . $class . ' col-' . $column['class'] . '-' . $column['size'] .
					'" data-column-id="' . $column['id'] . '" ' .
                    $this->view->stylingColumn()->setColumn($column['id']) . '>';
				$html .= $content;
				$html .= '</div>';
			}
		}

		return $html;
	}
}
