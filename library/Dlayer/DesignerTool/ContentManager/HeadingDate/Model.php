<?php

/**
 * Content heading-date item data model, all the methods required to manage a
 * the content items
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_HeadingDate_Model extends Zend_Db_Table_Abstract
{
    /**
     * Fetch all the heading types supported by Dlayer
     *
     * @return array
     */
    public function headingTypes()
    {
        $sql = "SELECT 
                    `dch`.`id`, 
                    `dch`.`name`
				FROM 
				    `designer_content_heading` `dch`
				ORDER BY 
				    `dch`.`sort_order` ASC";
        $stmt = $this->_db->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll();

        $rows = array();

        foreach ($result as $row) {
            $rows[intval($row['id'])] = $row['name'];
        }

        return $rows;
    }

    /**
     * Date formats
     *
     * @return array
     */
    public function formats()
    {
        return array(
            'l, jS M Y' => 'Wednesday, 15th Feb 2017',
            'F j, Y' => 'February 15, 2017',
            'jS M Y' => '15th Feb 2017'
        );
    }

    /**
     * Check to see how many instances there are of the content item data within the site
     *
     * @param integer $site_id
     * @param integer $content_id
     *
     * @return integer Number of instances
     */
    public function instancesOfData($site_id, $content_id)
    {
        $sql = "SELECT 
                    COUNT(`content`.`id`) AS `instances`
				FROM 
				    `user_site_page_content_item_heading_date` `content`
				WHERE 
				    `content`.`data_id` = (
				        SELECT 
				            `uspcit`.`data_id`
				        FROM 
				            `user_site_page_content_item_heading_date` `uspcit` 
					    WHERE 
					        `uspcit`.`site_id` = :site_id  
					    AND 
					        `uspcit`.`content_id` = :content_id 
					    LIMIT 
					        1
				    )";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result !== false) {
            return intval($result['instances']);
        } else {
            return 0;
        }
    }

    /**
     * Add a new heading & date content item
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $content_id
     * @param array $params The params data array from the tool
     *
     * @return boolean
     */
    public function add($site_id, $page_id, $content_id, array $params)
    {
        $result = false;

        $content = $params['heading'] . Dlayer_Config::CONTENT_DELIMITER . $params['date'];

        $data_id = $this->existingDataId($site_id, $content);

        if ($data_id === false) {
            $data_id = $this->addData($site_id, $params['name'], $content);
        }

        if ($data_id !== false) {
            $sql = "INSERT INTO `user_site_page_content_item_heading_date` 
                    (
                        `site_id`, 
                        `page_id`, 
                        `content_id`, 
                        `heading_id`, 
                        `format`,
                        `data_id`
                    ) 
                    VALUES 
                    (
                        :site_id, 
                        :page_id, 
                        :content_id, 
                        :heading_id, 
                        :format,
                        :data_id
                    )";
            $stmt = $this->_db->prepare($sql);
            $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
            $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
            $stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
            $stmt->bindValue(':heading_id', $params['type'], PDO::PARAM_INT);
            $stmt->bindValue(':format', $params['format'], PDO::PARAM_INT);
            $stmt->bindValue(':data_id', $data_id, PDO::PARAM_INT);
            $result = $stmt->execute();
        }

        return $result;
    }

    /**
     * Check to see if the content exists in the data tables, if so we re-use the content
     *
     * @param integer $site_id
     * @param string $content
     * @param integer|null $ignore_id
     *
     * @return integer|false Id of the existing data array or FALSE if a new content item
     */
    private function existingDataId($site_id, $content, $ignore_id = null)
    {
        $sql = "SELECT 
                    `id` 
                FROM 
                    `user_site_content_heading_date` 
                WHERE 
                    `site_id` = :site_id AND 
                    UPPER(`content`) = :content";
        if ($ignore_id !== null) {
            $sql .= " AND `id` != :ignore_id LIMIT 1";
        } else {
            $sql .= " LIMIT 1";
        }
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':content', strtoupper($content), PDO::PARAM_STR);
        if ($ignore_id !== null) {
            $stmt->bindValue(':ignore_id', $ignore_id, PDO::PARAM_INT);
        }
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result !== false) {
            return intval($result['id']);
        } else {
            return false;
        }
    }

    /**
     * Add the new content item data into the content table for heading and date items
     *
     * @param integer $site_id
     * @param string $name
     * @param string $content
     *
     * @return integer|false The id for the new data or FALSE upon failure
     */
    private function addData($site_id, $name, $content)
    {
        $sql = "INSERT INTO `user_site_content_heading_date` 
				(
				    `site_id`, 
				    `name`, 
				    `content`
				) 
				VALUES 
				(
				    :site_id, 
				    :name, 
				    :content
				)";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':content', $content, PDO::PARAM_STR);
        $result = $stmt->execute();

        if ($result === true) {
            return intval($this->_db->lastInsertId('user_site_content_heading_date'));
        } else {
            return false;
        }
    }

    /**
     * Fetch the existing data for the content item
     *
     * @param integer $site_id
     * @param integer $id
     *
     * @return array|false The data array for the content or FALSE upon failure
     */
    public function existingData($site_id, $id)
    {
        $sql = "SELECT 
                    `uspcihd`.`heading_id`,
                    `uspcihd`.`format`,
                    `uschd`.`name`, 
                    `uschd`.`content`
				FROM 
				    `user_site_page_content_item_heading_date` `uspcihd`  
				INNER JOIN user_site_content_heading_date uschd ON 
				    `uspcihd`.`data_id` = `uschd`.`id` AND 
				    `uschd`.`site_id` = :site_id 
				WHERE
				    `uspcihd`.`site_id` = :site_id AND 
				    `uspcihd`.`content_id` = :content_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Edit the content item
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $content_id
     * @param array $params The params data array from the tool
     *
     * @return true
     * @throws Exception
     */
    public function edit($site_id, $page_id, $content_id, array $params)
    {
        /**
         * @var false|integer If not false delete the data for this data id
         */
        $delete = false;

        $assigned_data_id = $this->assignedDataId($site_id, $page_id, $content_id);
        if($assigned_data_id === false)
        {
            throw new Exception('Error fetching the existing data id for content id: ' . $content_id);
        }

        $content = $params['heading'] . Dlayer_Config::CONTENT_DELIMITER . $params['date'];

        $data_id_by_content_id = $this->existingDataId($site_id, $content, $assigned_data_id);

        if (array_key_exists('instances', $params) === TRUE)
        {
            if ($params['instances'] === 1)
            {
                if ($data_id_by_content_id === false) {
                    if ($this->updateData($site_id, $data_id_by_content_id, $params['name'], $content) === false) {
                        throw new Exception('Error updating the data for content id: ' . $content_id);
                    }
                } else {
                    if ($this->assignNewDataId($site_id, $data_id_by_content_id, $assigned_data_id) === FALSE) {
                        throw new Exception('Error updating data id for text content items using data id: ' . $assigned_data_id);
                    }

                    $delete = $assigned_data_id;
                }
            } else {
                if ($data_id_by_content_id === false) {
                    $data_id_by_content_id = $this->addData($site_id, $params['name'], $content);
                }

                $this->assignNewDataIdToContentItem($site_id, $data_id_by_content_id, $content_id);
            }
        }
        else
        {
            if ($data_id_by_content_id === false) {
                if ($this->updateData($site_id, $assigned_data_id, $params['name'], $content) === false) {
                    throw new Exception('Error updating the data for content id: ' . $content_id);
                }
            } else {
                if($this->assignNewDataIdToContentItem($site_id, $data_id_by_content_id, $content_id) === false) {
                    throw new Exception('Error updating data id for content id: ' . $content_id);
                }

                $delete = $data_id_by_content_id;
            }
        }

        if ($delete !== false) {
            $this->deleteDataId($site_id, $delete);
        }

        if ($this->updateContentItem($site_id, $page_id, $content_id, $params) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Fetch the current data id for a content item
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $content_id
     *
     * @todo This is a standard query, move into base class
     * @return integer|false Should only return false if the query failed for some reason
     */
    private function assignedDataId($site_id, $page_id, $content_id)
    {
        $sql = "SELECT 
                    `data_id`
				FROM 
				    `user_site_page_content_item_heading_date` 
				WHERE 
				    `site_id` = :site_id AND 
				    `page_id` = :page_id AND 
				    `content_id` = :content_id 
				LIMIT 
				    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result !== FALSE) {
            return intval($result['data_id']);
        } else {
            return false;
        }
    }

    /**
     * Update the content for the given data id
     *
     * @param integer $site_id
     * @param integer $id
     * @param string $name
     * @param string $content
     *
     * @todo This is a standard query, move into base class
     * @return boolean
     */
    private function updateData($site_id, $id, $name, $content)
    {
        $sql = "UPDATE 
                    `user_site_content_heading_date`
                SET 
                    `name` = :name, 
                    `content` = :content 
				WHERE 
				    `site_id` = :site_id AND 
				    `id` = :data_id 
				LIMIT 
				    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':data_id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':content', $content, PDO::PARAM_STR);
        $result = $stmt->execute();

        return $result;
    }

    /**
     * Assign a new data id to a content item
     *
     * @param integer $site_id
     * @param integer $new_data_id
     * @param integer $content_id
     *
     * @todo This is a standard query, move into base class
     * @return boolean
     */
    private function assignNewDataIdToContentItem($site_id, $new_data_id, $content_id)
    {
        $sql = "UPDATE 
                    `user_site_page_content_item_heading_date`  
				SET 
				    `data_id` = :new_data_id
			    WHERE 
			        `site_id` = :site_id AND 
			        `content_id` = :content_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':new_data_id', $new_data_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
        $result = $stmt->execute();

        return $result;
    }

    /**
     * Delete data id
     *
     * @param integer $site_id
     * @param integer $id
     *
     * @todo This is a standard query, move into base class
     * @return void
     */
    private function deleteDataId($site_id, $id)
    {
        $sql = "DELETE FROM 
                    `user_site_content_jumbotron`
                WHERE 
                    `site_id` = :site_id AND 
                    `id` = :delete_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':delete_id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Update the custom data for a content item, stored in the content item structure table
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id
     * @param array $params
     *
     * @return boolean
     */
    private function updateContentItem($site_id, $page_id, $id, array $params)
    {
        $sql = "UPDATE 
                    `user_site_page_content_item_heading_date`
                SET 
                    `format` = :format, 
                    `heading_id` = :type
				WHERE 
				    `site_id` = :site_id AND 
				    `page_id` = :page_id AND 
				    `content_id` = :content_id 
				LIMIT 
				    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':format', $params['format'], PDO::PARAM_STR);
        $stmt->bindValue(':type', $params['type'], PDO::PARAM_INT);
        $result = $stmt->execute();

        return $result;
    }

    /**
     * Assign a new data id to the content items that use the supplied data id
     *
     * @param integer $site_id
     * @param integer $new_data_id
     * @param integer $current_data_id
     *
     * @return boolean
     */
    private function assignNewDataId($site_id, $new_data_id, $current_data_id)
    {
        $sql = "UPDATE 
                    `user_site_page_content_item_heading_date`  
				SET 
				    `data_id` = :new_data_id
				WHERE 
				    `site_id` = :site_id AND 
				    `data_id` = :current_data_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':new_data_id', $new_data_id, PDO::PARAM_INT);
        $stmt->bindValue(':current_data_id', $current_data_id, PDO::PARAM_INT);
        $result = $stmt->execute();

        return $result;
    }
}
