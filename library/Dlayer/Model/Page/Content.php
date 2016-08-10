<?php

/**
 * Page content model, handles all structural changes to the page
 *
 * @todo Review this model when all the tools are working
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Model_Page_Content extends Zend_Db_Table_Abstract
{
	/**
	 * Add one or more columns to the selected row
	 *
	 * @since 0.99
	 * @param integer $number_of_columns The number of columns to create
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $row_id
	 * @param string $column_type
	 * @return integer|FALSE Id of the newly created column
	 */
	public function addColumns($number_of_columns, $site_id, $page_id, $row_id, $column_type = 'md')
	{
		if($number_of_columns === 1)
		{
			$column_id = $this->addSingleColumn($site_id, $page_id, $row_id, 12);
		}
		else
		{
			$modulus = 12 % $number_of_columns;
			$size = (12 - $modulus) / $number_of_columns;

			$column_id = $this->addSingleColumn($site_id, $page_id, $row_id, $size);

			for($i = 2; $i <= $number_of_columns; $i++)
			{
				if($i === $number_of_columns)
				{
					$size += $modulus;
				}
				$this->addSingleColumn($site_id, $page_id, $row_id, $size);
			}
		}

		return $column_id;
	}

	/**
	 * Add one or more rows to the selected page or column
	 *
	 * @since 0.99
	 * @param integer $number_of_rows The number of rows to add
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer|NULL $column_id
	 * @return integer|FALSE Id of the newly created row
	 */
	public function addRows($number_of_rows, $site_id, $page_id, $column_id = NULL)
	{
		if($number_of_rows === 1)
		{
			$row_id = $this->addSingleRow($site_id, $page_id, $column_id);
		}
		else
		{
			$row_id = $this->addSingleRow($site_id, $page_id, $column_id);

			for($i = 2; $i <= $number_of_rows; $i++)
			{
				$this->addSingleRow($site_id, $page_id, $column_id);
			}
		}

		return $row_id;
	}

	/**
	 * Add a single column to the selected row
	 *
	 * @since 0.99
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $row_id
	 * @return integer|FALSE Id of the newly created column
	 */
	private function addSingleColumn($site_id, $page_id, $row_id, $size = 12, $column_type = 'md')
	{
		$sort_order = $this->sortOrderForNewColumn($site_id, $page_id, $row_id);
		if($sort_order === FALSE)
		{
			$sort_order = 1;
		}

		$sql = 'INSERT INTO user_site_page_structure_column 
                (site_id, page_id, row_id, size, column_type, offset, sort_order) 
				VALUES 
				(:site_id, :page_id, :row_id, :size, :column_type, 0, :sort_order)';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':row_id', $row_id, PDO::PARAM_INT);
		$stmt->bindValue(':size', $size, PDO::PARAM_INT);
		$stmt->bindValue(':column_type', $column_type, PDO::PARAM_STR);
		$stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
		$result = $stmt->execute();

		if($result === TRUE)
		{
			return intval($this->_db->lastInsertId('user_site_page_structure_column'));
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Add a single row to the selected page or column
	 *
	 * @since 0.99
	 * @todo Move sort call into add rows, will be called multiple times with the current setup when add rows is
	 * called for more than one row
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer|NULL $column_id
	 * @return integer|FALSE Id of the newly created row
	 */
	private function addSingleRow($site_id, $page_id, $column_id = NULL)
	{
		$sort_order = $this->sortOrderForNewRow($site_id, $page_id, $column_id);
		if($sort_order === FALSE)
		{
			$sort_order = 1;
		}

		$sql = 'INSERT INTO user_site_page_structure_row
                (site_id, page_id, column_id, sort_order) 
				VALUES 
				(:site_id, :page_id, :column_id, :sort_order)';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		if($column_id !== NULL)
		{
			$stmt->bindValue(':column_id', column_id, PDO::PARAM_INT);
		}
		else
		{
			$stmt->bindValue(':column_id', NULL, PDO::PARAM_NULL);
		}
		$stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
		$result = $stmt->execute();

		if($result === TRUE)
		{
			return intval($this->_db->lastInsertId('user_site_page_structure_row'));
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Calculate the sort order for the row that is about to be created, fetches the current max for a column or page
	 * and then adds one
	 *
	 * @since 0.99
	 * @todo Move sort call into add columns, will be called multiple times with the current setup when add columns
	 * is called for more than one column
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer|NULL $column_id
	 * @return integer|FALSE The new sort order
	 */
	private function sortOrderForNewRow($site_id, $page_id, $column_id = NULL)
	{
		$sql = "SELECT IFNULL(MAX(sort_order), 0) + 1 AS sort_order
				FROM user_site_page_structure_row  
				WHERE site_id = :site_id
				AND page_id = :page_id ";
		if($column_id === NULL)
		{
			$sql .= "AND column_id IS NULL";
		}
		else
		{
			$sql .= "AND column_id = :column_id";
		}

		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		if($column_id !== NULL)
		{
			$stmt->bindValue(':column_id', $column_id, PDO::PARAM_INT);
		}
		$stmt->execute();
		$result = $stmt->fetch();

		if($result !== FALSE)
		{
			return intval($result['sort_order']);
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Calculate the sort order for the new column that is about to be created, fetches the current max for a row and
	 * then adds one
	 *
	 * @since 0.99
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $row_id
	 * @return integer|FALSE The new sort order
	 */
	private function sortOrderForNewColumn($site_id, $page_id, $row_id = NULL)
	{
		$sql = "SELECT IFNULL(MAX(sort_order), 0) + 1 AS sort_order
				FROM user_site_page_structure_column   
				WHERE site_id = :site_id
				AND page_id = :page_id 
				AND row_id = :row_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':row_id', $row_id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();

		if($result !== FALSE)
		{
			return intval($result['sort_order']);
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Calculate the sort order for the new content item that is about to be created in the specified row, fetch the
	 * current MAX and then adds one
	 *
	 * @since 0.99
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $column_id
	 * @return integer|FALSE The new sort order
	 */
	private function sortOrderForNewContentItem($site_id, $page_id, $column_id)
	{
		$sql = "SELECT IFNULL(MAX(sort_order), 0) + 1 AS sort_order
				FROM user_site_page_structure_content 
				WHERE site_id = :site_id
				AND page_id = :page_id 
				AND column_id = :column_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':column_id', $column_id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();

		if($result !== FALSE)
		{
			return intval($result['sort_order']);
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Add a new content items to the content structure table, also adds the entry to the table for the content item
	 * type
	 *
	 * @since 0.99
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $column_id
	 * @param string $content_type
	 * @param array $params
	 * @return integer|FALSE
	 */
	public function addContentItem($site_id, $page_id, $column_id, $content_type, array $params)
	{
		$content_id = FALSE;

		$sort_order = $this->sortOrderForNewContentItem($site_id, $page_id, $column_id);
		if($sort_order === FALSE)
		{
			$sort_order = 1;
		}

		$sql = "INSERT INTO user_site_page_structure_content 
				(site_id, page_id, column_id, content_type, sort_order) 
				VALUES 
				(:site_id, :page_id, :column_id, 
				(SELECT id FROM designer_content_type WHERE `name` = :content_type LIMIT 1), 
				:sort_order)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':column_id', $column_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_type', $content_type, PDO::PARAM_STR);
		$stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
		$result = $stmt->execute();

		if($result === TRUE)
		{
			$content_id = intval($this->_db->lastInsertId('user_site_page_structure_content'));

			switch($content_type)
			{
				case 'text':
					$model_text = new Dlayer_Model_Page_Content_Items_Text();
					$result = $model_text->add($site_id, $page_id, $content_id, $params);
					if($result === FALSE)
					{
						$content_id = FALSE;
					}
				break;

				case 'text':
					$model_heading = new Dlayer_Model_Page_Content_Items_Heading();
					$result = $model_heading->add($site_id, $page_id, $content_id, $params);
					if($result === FALSE)
					{
						$content_id = FALSE;
					}
				break;

				default:
					$content_id = FALSE;
				break;
			}
		}

		return $content_id;
	}

	/**
	 * Check to see if the requested content item is valid, needs to exist in the given location and also be of the
	 * correct type
	 *
	 * @since 0.99
	 * @param integer $content_id
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $column_id
	 * @param string $content_type
	 * @return boolean
	 */
	public function validItem($content_id, $site_id, $page_id, $column_id, $content_type)
	{
		$sql = "SELECT id 
		        FROM user_site_page_structure_content
		        WHERE id = :content_id 
		        AND site_id = :site_id 
		        AND page_id = :page_id 
		        AND column_id = :column_id 
		        AND content_type = (
		            SELECT id 
		            FROM designer_content_type 
		            WHERE `name` = :content_type 
		            LIMIT 1
		        )";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':column_id', $column_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_type', $content_type, PDO::PARAM_STR);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result !== FALSE)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Fetch the sort order for the requested row
	 *
	 * @since 0.99
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer|NULL $column_id
	 * @param integer $row_id
	 * @return integer|FALSE The sort order for the requested row or FALSE upon failure
	 */
	private function rowSortOrder($site_id, $page_id, $column_id, $row_id)
	{
		$column_id = ($column_id !== NULL) ? $column_id : 0;

		$sql = 'SELECT sort_order 
				FROM user_site_page_structure_row 
				WHERE site_id = :site_id 
				AND page_id = :page_id
				AND column_id = :column_id 
				AND id = :row_id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':column_id', $column_id, PDO::PARAM_INT);
		$stmt->bindValue(':row_id', $row_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result !== FALSE)
		{
			return intval($result['sort_order']);
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Fetch the sort order for the requested column
	 *
	 * @since 0.99
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $row_id
	 * @param integer $column_id
	 * @return integer|FALSE The sort order for the requested column or FALSE upon failure
	 */
	private function columnSortOrder($site_id, $page_id, $row_id, $column_id)
	{
		$sql = 'SELECT sort_order 
				FROM user_site_page_structure_column 
				WHERE site_id = :site_id 
				AND page_id = :page_id
				AND row_id = :row_id 
				AND id = :column_id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':row_id', $row_id, PDO::PARAM_INT);
		$stmt->bindValue(':column_id', $column_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result !== FALSE)
		{
			return intval($result['sort_order']);
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Fetch a row by its position on the page and current sort order
	 *
	 * @since 0.99
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $column_id
	 * @param integer $sort_order
	 * @return integer The sort order of the requested item ot FALSE if the row doesn't exist
	 */
	private function getRowIdBySortOrder($site_id, $page_id, $column_id, $sort_order)
	{
		$sql = "SELECT id 
				FROM user_site_page_structure_row 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND column_id = :column_id 
				AND sort_order = :sort_order 
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':column_id', $column_id, PDO::PARAM_INT);
		$stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result !== FALSE)
		{
			return intval($result['id']);
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Fetch a column by its position on the page and current sort order
	 *
	 * @since 0.99
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $row_id
	 * @param integer $sort_order
	 * @return integer The sort order of the requested item ot FALSE if the column doesn't exist
	 */
	private function getColumnIdBySortOrder($site_id, $page_id, $row_id, $sort_order)
	{
		$sql = "SELECT id 
				FROM user_site_page_structure_column 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND row_id = :row_id 
				AND sort_order = :sort_order 
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':row_id', $row_id, PDO::PARAM_INT);
		$stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result !== FALSE)
		{
			return intval($result['id']);
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Set the sort order for the selected row
	 *
	 * @since 0.99
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $column_id
	 * @param integer $row_id
	 * @param integer $sort_order
	 * @return void
	 */
	private function setRowSortOrder($site_id, $page_id, $column_id, $row_id, $sort_order)
	{
		$sql = "UPDATE user_site_page_structure_row 
				SET sort_order = :sort_order 
				WHERE id = :row_id 
				AND site_id = :site_id 
				AND page_id = :page_id 
				AND column_id = :column_id 
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':column_id', $column_id, PDO::PARAM_INT);
		$stmt->bindValue(':row_id', $row_id, PDO::PARAM_INT);
		$stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
		$stmt->execute();
	}

	/**
	 * Set the sort order for the selected column
	 *
	 * @since 0.99
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $row_id
	 * @param integer $column_id
	 * @param integer $sort_order
	 * @return void
	 */
	private function setColumnSortOrder($site_id, $page_id, $row_id, $column_id, $sort_order)
	{
		$sql = "UPDATE user_site_page_structure_column 
				SET sort_order = :sort_order 
				WHERE id = :column_id  
				AND site_id = :site_id 
				AND page_id = :page_id 
				AND row_id = :row_id 
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':row_id', $row_id, PDO::PARAM_INT);
		$stmt->bindValue(':column_id', $column_id, PDO::PARAM_INT);
		$stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
		$stmt->execute();
	}

	/**
	 * Move the row in the requested direction
	 *
	 * @since 0.99
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $column_id
	 * @param integer $row_id
	 * @param string $direction
	 * @return void
	 */
	public function moveRow($site_id, $page_id, $column_id, $row_id, $direction)
	{
		$current_sort_order = $this->rowSortOrder($site_id, $page_id, $column_id, $row_id);
		$new_sort_order = FALSE;
		$sibling_row_id = FALSE;
		$sibling_sort_order = FALSE;

		if($current_sort_order !== FALSE)
		{
			switch($direction)
			{
				case 'up':
					if($current_sort_order > 0)
					{
						$sibling_row_id = $this->getRowIdBySortOrder($site_id, $page_id, $column_id,
							($current_sort_order - 1));

						if($sibling_row_id !== FALSE)
						{
							$new_sort_order = $current_sort_order - 1;
							$sibling_sort_order = $current_sort_order;
						}
					}
				break;

				case 'down':
					if($current_sort_order > 0)
					{
						$sibling_row_id = $this->getRowIdBySortOrder($site_id, $page_id, $column_id,
							($current_sort_order + 1));

						if($sibling_row_id !== FALSE)
						{
							$new_sort_order = $current_sort_order + 1;
							$sibling_sort_order = $current_sort_order;
						}
					}
				break;

				default:
				break;
			}
		}

		if($new_sort_order !== FALSE && $sibling_row_id !== FALSE && $sibling_sort_order !== FALSE)
		{
			$this->setRowSortOrder($site_id, $page_id, $column_id, $row_id, $new_sort_order);
			$this->setRowSortOrder($site_id, $page_id, $column_id, $sibling_row_id, $sibling_sort_order);
		}
	}

	/**
	 * Move the column in the requested direction
	 *
	 * @since 0.99
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $row_id
	 * @param integer $column_id
	 * @param string $direction
	 * @return void
	 */
	public function moveColumn($site_id, $page_id, $row_id, $column_id, $direction)
	{
		$current_sort_order = $this->columnSortOrder($site_id, $page_id, $row_id, $column_id);
		$new_sort_order = FALSE;
		$sibling_column_id = FALSE;
		$sibling_sort_order = FALSE;

		var_dump($current_sort_order);

		if($current_sort_order !== FALSE)
		{
			switch($direction)
			{
				case 'up':
					if($current_sort_order > 0)
					{
						$sibling_column_id = $this->getColumnIdBySortOrder($site_id, $page_id, $row_id,
							($current_sort_order - 1));

						if($sibling_column_id !== FALSE)
						{
							$new_sort_order = $current_sort_order - 1;
							$sibling_sort_order = $current_sort_order;
						}
					}
				break;

				case 'down':
					if($current_sort_order > 0)
					{
						$sibling_column_id = $this->getColumnIdBySortOrder($site_id, $page_id, $row_id,
							($current_sort_order + 1));

						if($sibling_column_id !== FALSE)
						{
							$new_sort_order = $current_sort_order + 1;
							$sibling_sort_order = $current_sort_order;
						}
					}
				break;

				default:
				break;
			}
		}



		if($new_sort_order !== FALSE && $sibling_column_id !== FALSE && $sibling_sort_order !== FALSE)
		{
			$this->setColumnSortOrder($site_id, $page_id, $row_id, $column_id, $new_sort_order);
			$this->setColumnSortOrder($site_id, $page_id, $row_id, $sibling_column_id, $sibling_sort_order);
		}
	}














	/**
	 * Calculate the new sort order value for the new content item,
	 * fetches the current MAX value and then increments by 1
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $content_row_id
	 * @return integer New sort order
	 */
	private function newItemSortOrderValue($site_id, $page_id, $content_row_id)
	{
		$sql = "SELECT IFNULL(MAX(sort_order), 0) + 1 AS sort_order
				FROM user_site_page_content_item 
				WHERE site_id = :site_id
				AND page_id = :page_id
				AND content_row_id = :content_row_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		return intval($result['sort_order']);
	}

	/**
	 * Check to see if the given content row id is valid, it has to belong to
	 * the supplied div id, page and site
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $div_id
	 * @param integer $content_row_id
	 * @return boolean TRUE if the content row id is valid
	 */
	public function validContentRowId($site_id, $page_id, $div_id,
		$content_row_id)
	{
		$sql = 'SELECT uspcr.id
				FROM user_site_page_content_rows uspcr
				WHERE uspcr.site_id = :site_id 
				AND uspcr.page_id = :page_id 
				AND uspcr.div_id = :div_id 
				AND uspcr.id = :content_row_id';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Check to see if the given content row id is valid, it has to belong to
	 * the supplied site and page, we don't not however check the div id
	 *
	 * @todo THis is used by the move item tool, see how it goes but
	 *    essentially this is a duplicate of the validContentRowId() method
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $content_row_id
	 * @return boolean TRUE if the content row id is valid
	 */
	public function validContentRowIdSansDiv($site_id, $page_id,
		$content_row_id)
	{
		$sql = 'SELECT uspcr.id
				FROM user_site_page_content_rows uspcr
				WHERE uspcr.site_id = :site_id 
				AND uspcr.page_id = :page_id 
				AND uspcr.id = :content_row_id';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Move the requested content item, either moves up or down increasing or
	 * descreasing the display sort order
	 *
	 * Once the sort order of the current item has been calculated and the
	 * id of the sibling item that needs to be altered has been calcualted two
	 * requests are sent to update the sort orders
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $div_id
	 * @param integer $content_row_id
	 * @param integer $content_id
	 * @param string $content_type
	 * @param string $direction
	 * @return void
	 */
	public function moveContentItem($site_id, $page_id, $div_id,
		$content_row_id, $content_id, $content_type, $direction)
	{
		$sort_order = $this->itemSortOrder($site_id, $page_id, $div_id,
			$content_row_id, $content_id);

		$process = FALSE;

		if($sort_order != FALSE)
		{
			switch($direction)
			{
				case 'up':
					if($sort_order > 1)
					{
						$sibling_content_id =
							$this->contentItemBySortOrder($site_id, $page_id,
								$content_row_id, $sort_order - 1);

						if($sibling_content_id != FALSE)
						{
							$process = TRUE;
							$new_sort_order = $sort_order - 1;
							$sibling_sort_order = $sort_order;
						}
					}
				break;

				case 'down':
					if($sort_order < $this->numberOfContentItems($site_id,
							$page_id, $content_row_id)
					)
					{
						$sibling_content_id =
							$this->contentItemBySortOrder($site_id, $page_id,
								$content_row_id, $sort_order + 1);

						if($sibling_content_id != FALSE)
						{
							$process = TRUE;
							$new_sort_order = $sort_order + 1;
							$sibling_sort_order = $sort_order;
						}
					}
				break;

				default:
					throw new Exception('Direction \'' . $direction . '\' not
					found in Dlayer_Model_Page_Content::moveContentItem()');
				break;
			}

			// Update the sort orders for the selected content item and the 
			// affected content item
			if($process == TRUE)
			{
				$this->setContentItemSortOrder($site_id, $page_id,
					$content_row_id, $content_id, $new_sort_order);

				$this->setContentItemSortOrder($site_id, $page_id,
					$content_row_id, $sibling_content_id, $sibling_sort_order);
			}
		}
		else
		{
			throw new Exception('Error returned when trying to fetch the 
				sort order of the content item in 
				Dlayer_Model_Page_Content::moveContentItem();');
		}
	}

	/**
	 * Update the sort order for a content item
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $content_row_id
	 * @param integer $content_id
	 * @param integer $sort_order
	 * @return void
	 */
	private function setContentItemSortOrder($site_id, $page_id,
		$content_row_id, $content_id, $sort_order)
	{
		$sql = "UPDATE user_site_page_content_item 
				SET sort_order = :sort_order
				WHERE id = :content_id 
				AND site_id = :site_id 
				AND page_id = :page_id 
				AND content_row_id = :content_row_id 
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();
	}

	/**
	 * Fetch the current sort order for the requested content item
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $div_id
	 * @param integer $content_row_id
	 * @param integer $content_id
	 * @return integer|FALSE The sort order for the selected content item or
	 *    FALSE if unable to pull the data
	 */
	private function itemSortOrder($site_id, $page_id, $div_id,
		$content_row_id, $content_id)
	{
		$sql = 'SELECT uspci.sort_order 
				FROM user_site_page_content_item uspci 
				JOIN user_site_page_content_rows uspcr 
					ON uspcr.id = uspci.content_row_id 
					AND uspcr.id = :content_row_id 
					AND uspcr.site_id = :site_id 
					AND uspcr.page_id = :page_id
				WHERE uspci.site_id = :site_id 
				AND uspci.page_id = :page_id 
				AND uspci.content_row_id = :content_row_id
				AND uspci.id = :content_id';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE)
		{
			return intval($result['sort_order']);
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Fetch the content item which has the requested sort order
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $content_row_id
	 * @param integer $sort_order
	 * @return integer|FALSE $content_id
	 */
	private function contentItemBySortOrder($site_id, $page_id,
		$content_row_id, $sort_order)
	{
		$sql = "SELECT id
				FROM user_site_page_content_item 
				WHERE site_id = :site_id
				AND page_id = :page_id
				AND content_row_id = :content_row_id 
				AND sort_order = :sort_order
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE)
		{
			return intval($result['id']);
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Fetch the total number of content rows that have been defined for the
	 * template div id
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $div_id
	 * @return integer Number of content rows in the template div id
	 */
	private function numberOfContentRows($site_id, $page_id, $div_id)
	{
		$sql = 'SELECT id 
				FROM user_site_page_content_rows 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND div_id = :div_id';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
		$stmt->execute();

		return count($stmt->fetchAll());
	}

	/**
	 * Fetch the total number of content items that have been defined for the
	 * selected content row id
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $content_row_id
	 * @return integer Number of content items in the content row
	 */
	private function numberOfContentItems($site_id, $page_id, $content_row_id)
	{
		$sql = "SELECT id
				FROM user_site_page_content_item 
				WHERE site_id = :site_id
				AND page_id = :page_id
				AND content_row_id = :content_row_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->execute();

		return count($stmt->fetchAll());
	}

	/**
	 * Set a new div id (content area) for the requested content row
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $div_id
	 * @param integer $new_div_id
	 * @param integer $content_row_id
	 * @return void
	 */
	public function setContentRowParent($site_id, $page_id, $div_id,
		$new_div_id, $content_row_id)
	{
		$current_sort_order = $this->rowSortOrder($site_id, $page_id,
			$div_id, $content_row_id);

		$new_sort_order = $this->newRowSortOrderValue($site_id, $page_id,
			$new_div_id);

		$sql = 'UPDATE user_site_page_content_rows 
				SET div_id = :div_id, sort_order = :sort_order  
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND id = :content_row_id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $new_div_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->bindValue(':sort_order', $new_sort_order, PDO::PARAM_INT);
		$stmt->execute();

		$this->reorderContentRows($site_id, $page_id, $div_id,
			$current_sort_order);
	}

	/**
	 * Reorder the content rows within an area, when a row is moved out there
	 * will be a gap in all the sort orders above the sort order of the row
	 * being moved need to be reduced by one
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $div_id
	 * @param integer $sort_order
	 * @return void
	 */
	private function reorderContentRows($site_id, $page_id, $div_id,
		$sort_order)
	{
		$sql = 'UPDATE user_site_page_content_rows 
				SET sort_order = sort_order - 1 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND div_id = :div_id 
				AND sort_order > :sort_order';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
		$stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
		$stmt->execute();
	}

	/**
	 * Reorder the content items within a row, when an item is moved out there
	 * will be a gap and all the sort orders above the sort order of the item
	 * being moved need to be reduced by one
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $content_row_id
	 * @param integer $sort_order
	 * @return void
	 */
	private function reorderContentItems($site_id, $page_id, $content_row_id,
		$sort_order)
	{
		$sql = 'UPDATE user_site_page_content_item 
				SET sort_order = sort_order - 1 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND content_row_id = :content_row_id 
				AND sort_order > :sort_order';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
		$stmt->execute();
	}

	/**
	 * Move the requested content row, either moves up or down.
	 *
	 * Once the sort order of the current item has been calculated and the
	 * id of the sibling item that needs to be altered two requests are sent
	 * to update the sort orders
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $div_id
	 * @param integer $content_row_id
	 * @param string $direction
	 * @return void
	 */
	public function moveContentRow($site_id, $page_id, $div_id,
		$content_row_id, $direction)
	{
		$sort_order = $this->rowSortOrder($site_id, $page_id, $div_id,
			$content_row_id);

		$process = FALSE;

		if($sort_order != FALSE)
		{
			switch($direction)
			{
				case 'up':
					if($sort_order > 1)
					{
						$sibling_content_row_id =
							$this->contentRowBySortOrder($site_id, $page_id,
								$div_id, $sort_order - 1);

						if($sibling_content_row_id != FALSE)
						{
							$process = TRUE;
							$new_sort_order = $sort_order - 1;
							$sibling_sort_order = $sort_order;
						}
					}
				break;

				case 'down':
					if($sort_order < $this->numberOfContentRows($site_id,
							$page_id, $div_id)
					)
					{
						$sibling_content_row_id =
							$this->contentRowBySortOrder($site_id, $page_id,
								$div_id, $sort_order + 1);

						if($sibling_content_row_id != FALSE)
						{
							$process = TRUE;
							$new_sort_order = $sort_order + 1;
							$sibling_sort_order = $sort_order;
						}
					}
				break;

				default:
					throw new Exception('Direction \'' . $direction . '\' not
					found in Dlayer_Model_Page_Content::moveContentRow()');
				break;
			}

			// Update the sort orders for the selected content row and the 
			// affected content row
			if($process == TRUE)
			{
				$this->setContentRowSortOrder($site_id, $page_id, $div_id,
					$content_row_id, $new_sort_order);

				$this->setContentRowSortOrder($site_id, $page_id, $div_id,
					$sibling_content_row_id, $sibling_sort_order);
			}
		}
		else
		{
			throw new Exception('Error returned when trying to fetch the 
				sort order of the content row in 
				Dlayer_Model_Page_Content::moveContentRow();');
		}
	}

	/**
	 * Fetch the content rows that have been defined for the request page
	 * ignoring the currently selected content row
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $seleted_content_row_id
	 * @return array Returns an array containing all the content rows that have
	 *    been defined for the requested page
	 */
	public function contentRows($site_id, $page_id, $selected_content_row_id)
	{
		$sql = 'SELECT uspcr.id
				FROM user_site_page_content_rows uspcr 
				WHERE uspcr.site_id = :site_id 
				AND uspcr.page_id = :page_id 
				AND uspcr.id != :selected_content_row_id';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':selected_content_row_id', $selected_content_row_id,
			PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll();
	}

	/**
	 * Set the parent for a content item, new content row id
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param inetegr $div_id
	 * @param integer $content_row_id
	 * @param integer $new_content_row_id
	 * @param integer $content_id
	 * @return integer The div id belong to the new content row
	 */
	public function setContentItemParent($site_id, $page_id, $div_id,
		$content_row_id, $new_content_row_id, $content_id)
	{
		$current_sort_order = $this->itemSortOrder($site_id, $page_id, $div_id,
			$content_row_id, $content_id);

		$new_sort_order = $this->newItemSortOrderValue($site_id, $page_id,
			$new_content_row_id);

		$sql = 'UPDATE user_site_page_content_item 
				SET content_row_id = :content_row_id, sort_order = :sort_order 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND id = :content_id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $new_content_row_id,
			PDO::PARAM_INT);
		$stmt->bindValue(':sort_order', $new_sort_order, PDO::PARAM_INT);
		$stmt->execute();

		$this->reorderContentItems($site_id, $page_id, $content_row_id,
			$current_sort_order);

		return $this->contentRowDivId($site_id, $page_id, $new_content_row_id);
	}

	/**
	 * Fetch the div id for the requested content row
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $content_row_id
	 * @return integer|FALSE Returns wither the div id that the content row
	 *    row belongs to or FALSE if unable to be selected
	 */
	public function contentRowDivId($site_id, $page_id, $content_row_id)
	{
		$sql = 'SELECT div_id 
				FROM user_site_page_content_rows 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND id = :content_row_id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE)
		{
			return intval($result['div_id']);
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Fetch the content type and content manager tool for the given content id
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $content_id
	 * @return array|FALSE Either returns an array containing tool and content
	 *    content type or FALSE if data cannot be fetched
	 */
	public function contentTypeAndToolByContentId($site_id, $page_id,
		$content_id)
	{
		$sql = 'SELECT dct.`name` AS content_type, dmt.tool 
				FROM user_site_page_content_item uspci 
				JOIN designer_content_type dct 
					ON uspci.content_type = dct.id 
				JOIN dlayer_module_tool dmt 
					ON dct.tool_id = dmt.id 
				WHERE uspci.site_id = :site_id 
				AND uspci.page_id = :page_id 
				AND uspci.id = :content_id';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE)
		{
			return $result;
		}
		else
		{
			return FALSE;
		}
	}
}
