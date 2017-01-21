<?php

/**
* Add column model
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_DesignerTool_ContentManager_AddColumn_Model extends Zend_Db_Table_Abstract
{
	/**
	 * Add one or more columns to the selected row
	 *
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
	 * Add a single column to the selected row
	 *
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

		$sql = "INSERT INTO user_site_page_structure_column 
                (
                    `site_id`, 
                    `page_id`, 
                    `row_id`, 
                    `size`,
                    `column_type_id`, 
                    `offset`, 
                    `sort_order`
                ) 
				VALUES 
				(
				    :site_id, 
				    :page_id, 
				    :row_id, 
				    :size, 
				    ( 
				        SELECT 
				            `id` 
                        FROM 
                            `designer_column_type`
                         WHERE 
                            `column_type` = :column_type                        
				    ), 
				    0, 
				    :sort_order
                )";
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
	 * Calculate the sort order for the new column that is about to be created, fetches the current max for a row and
	 * then adds one
	 *
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
}
