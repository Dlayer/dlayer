<?php

/**
 * Content heading item data model, all the methods required to manage a
 * the content heading items
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Heading_Model extends Zend_Db_Table_Abstract
{
    /**
     * Add a new heading content item
     *
     * @since 0.99
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $content_id
     * @param array $params The params data array from the tool
     * @return boolean
     */
    public function add($site_id, $page_id, $content_id, array $params)
    {
        $result = false;

        if (strlen($params['sub_heading']) > 0) {
            $content = $params['heading'] . Dlayer_Config::CONTENT_DELIMITER . $params['sub_heading'];
        } else {
            $content = $params['heading'];
        }

        $data_id = $this->existingDataId($site_id, $content);

        if ($data_id === false) {
            $data_id = $this->addData($site_id, $params['name'], $content);
        }

        if ($data_id !== false) {
            $sql = "INSERT INTO user_site_page_content_item_heading 
                    (site_id, page_id, content_id, heading_id, data_id) 
                    VALUES 
                    (:site_id, :page_id, :content_id, :heading_id, :data_id)";
            $stmt = $this->_db->prepare($sql);
            $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
            $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
            $stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
            $stmt->bindValue(':heading_id', $params['heading_type'], PDO::PARAM_INT);
            $stmt->bindValue(':data_id', $data_id, PDO::PARAM_INT);
            $result = $stmt->execute();
        }

        return $result;
    }

    /**
     * Check to see if the content exists in the data tables, if so we re-use the data from a previous content item
     *
     * @since 0.99
     * @param integer $site_id
     * @param string $content
     * @param integer|NULL $ignore_id
     * @return integer|FALSE Id of the existing data array or FALSE if a new content item
     */
    private function existingDataId($site_id, $content, $ignore_id = null)
    {
        $sql = "SELECT id 
                FROM user_site_content_heading 
                WHERE site_id = :site_id  
				AND UPPER(content) = :content";
        if ($ignore_id !== null) {
            $sql .= " AND id != :ignore_id LIMIT 1";
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
     * Add the new content item data into the content table for text items
     *
     * @since 0.99
     * @param integer $site_id
     * @param string $name
     * @param string $content
     * @return integer|FALSE The id for the new data or FALSE upon failure
     */
    private function addData($site_id, $name, $content)
    {
        $sql = "INSERT INTO user_site_content_heading 
				(site_id, `name`, content) 
				VALUES 
				(:site_id, :name, :content)";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':content', $content, PDO::PARAM_STR);
        $result = $stmt->execute();

        if ($result === true) {
            return intval($this->_db->lastInsertId('user_site_content_heading'));
        } else {
            return false;
        }
    }

    /**
     * Fetch the existing data for the content item
     *
     * @since 0.99
     * @param integer $site_id
     * @param integer $id
     * @return array|FALSE The data array for the content or FALSE upon failure
     */
    public function existingData($site_id, $id)
    {
        $sql = "SELECT uspcih.heading_id, usch.`name`, usch.content
				FROM user_site_page_content_item_heading uspcih 
				JOIN user_site_content_heading usch 
					ON uspcih.data_id = usch.id
					AND usch.site_id = :site_id 
				WHERE uspcih.site_id = :site_id
				AND uspcih.content_id = :content_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Check to see how many instances there are of the content item data within the site
     *
     * @since 0.99
     * @param integer $site_id
     * @param integer $content_id
     * @return integer Number of instances
     */
    public function instancesOfData($site_id, $content_id)
    {
        $sql = "SELECT COUNT(content.id) AS instances
				FROM user_site_page_content_item_heading content
				WHERE content.data_id = (
					SELECT uspcit.data_id 
					FROM user_site_page_content_item_heading uspcit 
					WHERE uspcit.site_id = :site_id  
					AND uspcit.content_id = :content_id 
					LIMIT 1
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
     * Fetch the current data id for a content item
     *
     * @since 0.99
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $content_id
     * @return integer|FALSE Should only return FALSE if the query failed for some reason
     */
    private function currentDataId($site_id, $page_id, $content_id)
    {
        $sql = "SELECT data_id
				FROM user_site_page_content_item_heading 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND content_id = :content_id 
				LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result !== false) {
            return intval($result['data_id']);
        } else {
            return false;
        }
    }

    /**
     * Update the data for the existing data id
     *
     * @param integer $site_id
     * @param integer $id
     * @param string $name
     * @param string $content
     * @return boolean
     */
    private function updateData($site_id, $id, $name, $content)
    {
        $sql = "UPDATE user_site_content_heading 
				SET `name` = :name, content = :content 
				WHERE site_id = :site_id 
				AND id = :data_id 
				LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':data_id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':content', $content, PDO::PARAM_STR);
        $result = $stmt->execute();

        return $result;
    }

    /**
     * Assign a new data id to the content items that use the supplied data id
     *
     * @since 0.99
     * @param integer $site_id
     * @param integer $new_data_id
     * @param integer $current_data_id
     * @return boolean
     */
    private function assignNewDataId($site_id, $new_data_id, $current_data_id)
    {
        $sql = "UPDATE user_site_page_content_item_heading 
				SET data_id = :new_data_id 
				WHERE site_id = :site_id 
				AND data_id = :current_data_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':new_data_id', $new_data_id, PDO::PARAM_INT);
        $stmt->bindValue(':current_data_id', $current_data_id, PDO::PARAM_INT);
        $result = $stmt->execute();

        return $result;
    }

    /**
     * Assign a new data id to a content item
     *
     * @since 0.99
     * @param integer $site_id
     * @param integer $new_data_id
     * @param integer $content_id
     * @return boolean
     */
    private function assignNewDataIdToContentItem($site_id, $new_data_id, $content_id)
    {
        $sql = "UPDATE user_site_page_content_item_heading 
				SET data_id = :new_data_id 
				WHERE site_id = :site_id 
				AND content_id = :content_id";
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
     * @param integer $delete_id
     * @return void
     */
    private function deleteDataId($site_id, $delete_id)
    {
        $sql = "DELETE FROM user_site_content_heading  
					WHERE site_id = :site_id 
					AND id = :delete_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':delete_id', $delete_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Edit the existing data
     *
     * @since 0.99
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $content_id
     * @param array $params The params data array from the tool
     * @return TRUE
     * @throws Exception
     */
    public function edit($site_id, $page_id, $content_id, array $params)
    {
        /**
         * @var FALSE|integer If not false delete the data for this data id
         */
        $delete = false;

        $current_data_id = $this->currentDataId($site_id, $page_id, $content_id);
        if ($current_data_id === false) {
            throw new Exception('Error fetching the existing data id for content id: ' . $current_data_id);
        }

        if (strlen($params['sub_heading']) > 0) {
            $content = $params['heading'] . Dlayer_Config::CONTENT_DELIMITER . $params['sub_heading'];
        } else {
            $content = $params['heading'];
        }

        $new_data_id = $this->existingDataId($site_id, $content, $current_data_id);

        if (array_key_exists('instances', $params) === true) {
            if ($params['instances'] === 1) {
                if ($new_data_id === false) {
                    if ($this->updateData($site_id, $current_data_id, $params['name'], $content) === false) {
                        throw new Exception('Error updating the data for content id: ' . $current_data_id);
                    }
                } else {
                    if ($this->assignNewDataId($site_id, $new_data_id, $current_data_id) === false) {
                        throw new Exception('Error updating data id for text content items using data id: ' .
                            $current_data_id);
                    }

                    $delete = $current_data_id;
                }
            } else {
                if ($new_data_id === false) {
                    $new_data_id = $this->addData($site_id, $params['name'], $content);
                    $this->assignNewDataIdToContentItem($site_id, $new_data_id, $content_id);
                } else {
                    $this->assignNewDataIdToContentItem($site_id, $new_data_id, $content_id);
                }
            }
        } else {
            if ($new_data_id === false) {
                if ($this->updateData($site_id, $current_data_id, $params['name'], $content) === false) {
                    throw new Exception('Error updating the data for content id: ' . $current_data_id);
                }
            } else {
                if ($this->assignNewDataIdToContentItem($site_id, $new_data_id, $content_id) === false) {
                    throw new Exception('Error updating data id for content id: ' . $content_id);
                }

                $delete = $current_data_id;
            }
        }

        if ($delete !== false) {
            $this->deleteDataId($site_id, $delete);
        }

        if ($this->updateContentItem($site_id, $page_id, $content_id, $params) === true) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Fetch all the heading types supported by Dlayer (and HTML)
     *
     * @return array
     */
    public function headingTypesForSelect()
    {
        $sql = "SELECT dch.id, dch.`name`
				FROM designer_content_heading dch
				ORDER BY dch.sort_order ASC";
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
     * Update the custom data for a content item, stored in the content item structure table
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id
     * @param array $params
     * @return boolean
     */
    private function updateContentItem($site_id, $page_id, $id, array $params)
    {
        $sql = "UPDATE user_site_page_content_item_heading  
				SET heading_id = :heading_id   
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND content_id = :content_id 
				LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':heading_id', $params['heading_type'], PDO::PARAM_STR);
        $result = $stmt->execute();

        return $result;
    }
}
