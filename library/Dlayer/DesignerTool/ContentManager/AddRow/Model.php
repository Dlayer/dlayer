<?php

/**
* Add row model
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_DesignerTool_ContentManager_AddRow_Model extends Zend_Db_Table_Abstract
{
	/**
	 * Add one or more rows to the selected page or column
	 *
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
	 * Add a single row to the selected page or column
	 *
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
			$stmt->bindValue(':column_id', $column_id, PDO::PARAM_INT);
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
}
