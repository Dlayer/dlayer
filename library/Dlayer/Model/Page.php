<?php

/**
 * Page content model, handles all structural changes to the page not covered by tools
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Model_Page extends Zend_Db_Table_Abstract
{
    /**
     * Calculate the sort order for the new content item that is about to be created in the specified row, fetch the
     * current MAX and then adds one
     *
     * @since 0.99
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $column_id
     *
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

        if ($result !== false) {
            return intval($result['sort_order']);
        } else {
            return false;
        }
    }

    /**
     * Add a new content items to the content structure table, also adds the entry to the table for the content item
     * type
     *
     * @since 0.99
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $column_id
     * @param string $content_type
     * @param array $params
     *
     * @return integer|FALSE
     */
    public function addContentItem($site_id, $page_id, $column_id, $content_type, array $params)
    {
        $content_id = false;

        $sort_order = $this->sortOrderForNewContentItem($site_id, $page_id, $column_id);
        if ($sort_order === false) {
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

        if ($result === true) {
            $content_id = intval($this->_db->lastInsertId('user_site_page_structure_content'));
        }

        return $content_id;
    }

    /**
     * Check to see if the requested content item is valid, needs to exist in the given location and also be of the
     * correct type
     *
     * @since 0.99
     *
     * @param integer $content_id
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $column_id
     * @param string $content_type
     *
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

        if ($result !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Fetch the sort order for the requested row
     *
     * @since 0.99
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer|NULL $column_id
     * @param integer $row_id
     *
     * @return integer|FALSE The sort order for the requested row or FALSE upon failure
     */
    private function rowSortOrder($site_id, $page_id, $column_id, $row_id)
    {
        $column_id = ($column_id !== null) ? $column_id : 0;

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

        if ($result !== false) {
            return intval($result['sort_order']);
        } else {
            return false;
        }
    }

    /**
     * Fetch the sort order for the requested column
     *
     * @since 0.99
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $row_id
     * @param integer $column_id
     *
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

        if ($result !== false) {
            return intval($result['sort_order']);
        } else {
            return false;
        }
    }

    /**
     * Fetch the sort order for the requested content item
     *
     * @since 0.99
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $column_id
     * @param integer $id
     *
     * @return integer|FALSE The sort order for the requested content item or FALSE upon failure
     */
    private function contentSortOrder($site_id, $page_id, $column_id, $id)
    {
        $sql = 'SELECT sort_order 
				FROM user_site_page_structure_content 
				WHERE site_id = :site_id 
				AND page_id = :page_id
				AND column_id = :column_id 
				AND id = :content_id 
				LIMIT 1';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':column_id', $column_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result !== false) {
            return intval($result['sort_order']);
        } else {
            return false;
        }
    }

    /**
     * Fetch a row by its position on the page and current sort order
     *
     * @since 0.99
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $column_id
     * @param integer $sort_order
     *
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

        if ($result !== false) {
            return intval($result['id']);
        } else {
            return false;
        }
    }

    /**
     * Fetch a column by its position on the page and current sort order
     *
     * @since 0.99
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $row_id
     * @param integer $sort_order
     *
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

        if ($result !== false) {
            return intval($result['id']);
        } else {
            return false;
        }
    }

    /**
     * Fetch a content item by its position in a column
     *
     * @since 0.99
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $column_id
     * @param integer $sort_order
     *
     * @return integer The sort order of the requested content item ot FALSE if the content item doesn't exist
     */
    private function getContentIdBySortOrder($site_id, $page_id, $column_id, $sort_order)
    {
        $sql = "SELECT id 
				FROM user_site_page_structure_content 
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

        if ($result !== false) {
            return intval($result['id']);
        } else {
            return false;
        }
    }

    /**
     * Set the sort order for the selected row
     *
     * @since 0.99
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $column_id
     * @param integer $row_id
     * @param integer $sort_order
     *
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
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $row_id
     * @param integer $column_id
     * @param integer $sort_order
     *
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
     * Set the sort order for the selected content item
     *
     * @since 0.99
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $column_id
     * @param integer $id
     * @param integer $sort_order
     *
     * @return void
     */
    private function setContentSortOrder($site_id, $page_id, $column_id, $id, $sort_order)
    {
        $sql = "UPDATE user_site_page_structure_content  
				SET sort_order = :sort_order 
				WHERE id = :content_id  
				AND site_id = :site_id 
				AND page_id = :page_id 
				AND column_id = :column_id 
				LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':column_id', $column_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Move the row in the requested direction
     *
     * @since 0.99
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $column_id
     * @param integer $row_id
     * @param string $direction
     *
     * @return void
     */
    public function moveRow($site_id, $page_id, $column_id, $row_id, $direction)
    {
        $current_sort_order = $this->rowSortOrder($site_id, $page_id, $column_id, $row_id);
        $new_sort_order = false;
        $sibling_row_id = false;
        $sibling_sort_order = false;

        if ($current_sort_order !== false) {
            switch ($direction) {
                case 'up':
                    if ($current_sort_order > 0) {
                        $sibling_row_id = $this->getRowIdBySortOrder($site_id, $page_id, $column_id,
                            ($current_sort_order - 1));

                        if ($sibling_row_id !== false) {
                            $new_sort_order = $current_sort_order - 1;
                            $sibling_sort_order = $current_sort_order;
                        }
                    }
                    break;

                case 'down':
                    if ($current_sort_order > 0) {
                        $sibling_row_id = $this->getRowIdBySortOrder($site_id, $page_id, $column_id,
                            ($current_sort_order + 1));

                        if ($sibling_row_id !== false) {
                            $new_sort_order = $current_sort_order + 1;
                            $sibling_sort_order = $current_sort_order;
                        }
                    }
                    break;

                default:
                    break;
            }
        }

        if ($new_sort_order !== false && $sibling_row_id !== false && $sibling_sort_order !== false) {
            $this->setRowSortOrder($site_id, $page_id, $column_id, $row_id, $new_sort_order);
            $this->setRowSortOrder($site_id, $page_id, $column_id, $sibling_row_id, $sibling_sort_order);
        }
    }

    /**
     * Move the column in the requested direction
     *
     * @since 0.99
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $row_id
     * @param integer $column_id
     * @param string $direction
     *
     * @return void
     */
    public function moveColumn($site_id, $page_id, $row_id, $column_id, $direction)
    {
        $current_sort_order = $this->columnSortOrder($site_id, $page_id, $row_id, $column_id);
        $new_sort_order = false;
        $sibling_column_id = false;
        $sibling_sort_order = false;

        if ($current_sort_order !== false) {
            switch ($direction) {
                case 'up':
                    if ($current_sort_order > 0) {
                        $sibling_column_id = $this->getColumnIdBySortOrder($site_id, $page_id, $row_id,
                            ($current_sort_order - 1));

                        if ($sibling_column_id !== false) {
                            $new_sort_order = $current_sort_order - 1;
                            $sibling_sort_order = $current_sort_order;
                        }
                    }
                    break;

                case 'down':
                    if ($current_sort_order > 0) {
                        $sibling_column_id = $this->getColumnIdBySortOrder($site_id, $page_id, $row_id,
                            ($current_sort_order + 1));

                        if ($sibling_column_id !== false) {
                            $new_sort_order = $current_sort_order + 1;
                            $sibling_sort_order = $current_sort_order;
                        }
                    }
                    break;

                default:
                    break;
            }
        }

        if ($new_sort_order !== false && $sibling_column_id !== false && $sibling_sort_order !== false) {
            $this->setColumnSortOrder($site_id, $page_id, $row_id, $column_id, $new_sort_order);
            $this->setColumnSortOrder($site_id, $page_id, $row_id, $sibling_column_id, $sibling_sort_order);
        }
    }

    /**
     * Move the content in the requested direction
     *
     * @since 0.99
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $column_id
     * @param integer $id
     * @param string $direction
     *
     * @return void
     */
    public function moveContent($site_id, $page_id, $column_id, $id, $direction)
    {
        $current_sort_order = $this->contentSortOrder($site_id, $page_id, $column_id, $id);
        $new_sort_order = false;
        $sibling_content_id = false;
        $sibling_sort_order = false;

        if ($current_sort_order !== false) {
            switch ($direction) {
                case 'up':
                    if ($current_sort_order > 0) {
                        $sibling_content_id = $this->getContentIdBySortOrder($site_id, $page_id, $column_id,
                            ($current_sort_order - 1));

                        if ($sibling_content_id !== false) {
                            $new_sort_order = $current_sort_order - 1;
                            $sibling_sort_order = $current_sort_order;
                        }
                    }
                    break;

                case 'down':
                    if ($current_sort_order > 0) {
                        $sibling_content_id = $this->getContentIdBySortOrder($site_id, $page_id, $column_id,
                            ($current_sort_order + 1));

                        if ($sibling_content_id !== false) {
                            $new_sort_order = $current_sort_order + 1;
                            $sibling_sort_order = $current_sort_order;
                        }
                    }
                    break;

                default:
                    break;
            }
        }

        if ($new_sort_order !== false && $sibling_content_id !== false && $sibling_sort_order !== false) {
            $this->setContentSortOrder($site_id, $page_id, $column_id, $id, $new_sort_order);
            $this->setContentSortOrder($site_id, $page_id, $column_id, $sibling_content_id, $sibling_sort_order);
        }
    }

    /**
     * Fetch the parent id for a column
     *
     * @param integer $column_id
     * @return integer|false
     */
    public function parentRowId($column_id)
    {
        $sql = "SELECT 
                    `row_id` 
                FROM 
                    `user_site_page_structure_column` 
                WHERE 
                    `id` = :column_id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':column_id', $column_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result !== false) {
            return intval($result['row_id']);
        } else {
            return false;
        }
    }

    /**
     * Fetch the parent id for a row
     *
     * @param integer $row_id
     * @return integer|false
     */
    public function parentColumnId($row_id)
    {
        $sql = "SELECT 
                    `column_id` 
                FROM 
                    `user_site_page_structure_row` 
                WHERE 
                    `id` = :row_id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':row_id', $row_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result !== false) {
            return intval($result['column_id']);
        } else {
            return false;
        }
    }

    /**
     * Check to see if the selected column has any child row
     *
     * @param integer $column_id
     * @return boolean
     */
    public function columnContainsRows($column_id)
    {
        $sql = "SELECT 
                    `id` 
                FROM 
                    `user_site_page_structure_row` 
                WHERE 
                    `column_id` = :column_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':column_id', $column_id, PDO::PARAM_INT);
        $stmt->execute();

        if (count($stmt->fetchAll()) === 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Check to see if the selected column has any content
     *
     * @param integer $column_id
     * @return boolean
     */
    public function columnContainsContent($column_id)
    {
        $sql = "SELECT 
                    `id` 
                FROM 
                    `user_site_page_structure_content` 
                WHERE 
                    `column_id` = :column_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':column_id', $column_id, PDO::PARAM_INT);
        $stmt->execute();

        if (count($stmt->fetchAll()) === 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Content item siblings for next and previous selection buttons
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $column_id
     * @param integer $content_id
     * @return array
     */
    public function contentSiblings($site_id, $page_id, $column_id, $content_id)
    {
        $sql = "SELECT 
                    `uspsc`.`id`, 
                    `dct`.`name` AS `content_type`, 
	                `dmt`.`model` AS `tool` 
                FROM 
                    `user_site_page_structure_content` `uspsc` 
                INNER JOIN 
	                `designer_content_type` `dct` ON 
		                `uspsc`.`content_type` = `dct`.`id` 
                INNER JOIN 
                    `dlayer_module_tool` `dmt` ON  
		                `dct`.`tool_id` = `dmt`.`id`
                WHERE 
                    `uspsc`.`site_id` = :site_id AND 
                    `uspsc`.`page_id` = :page_id AND 
                    `uspsc`.`column_id` = :column_id 
                ORDER BY 
                    `uspsc`.`sort_order` ASC";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':column_id', $column_id, PDO::PARAM_INT);
        $stmt->execute();

        $content = array();
        $data = array();
        foreach ($stmt->fetchAll() as $row) {
            $content[] = intval($row['id']);
            $data[] = array(
                'tool' => $row['tool'],
                'content_type' => $row['content_type']
            );
        }

        $result = array(
            'previous' => false,
            'next' => false
        );

        if (count($result) > 1) {
            $key = array_search($content_id, $content);

            if ($key > 0) {
                if (array_key_exists(($key-1), $content) === true) {
                    $result['previous'] = $content[($key-1)];
                    $result['previous_data'] = $data[($key-1)];
                }
            }

            if (array_key_exists(($key+1), $content) === true) {
                $result['next'] = $content[($key+1)];
                $result['next_data'] = $data[($key+1)];
            }
        }

        return $result;
    }
}
