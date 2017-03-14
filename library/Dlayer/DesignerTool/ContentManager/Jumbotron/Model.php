<?php

/**
 * Content jumbotron item data model, all the methods required to manage a
 * Jumbotron data item
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Jumbotron_Model extends
    Dlayer_DesignerTool_ContentManager_Shared_Model_Content_Item
{
    /**
     * Fetch the existing data for the content item
     *
     * @param integer $site_id
     * @param integer $id
     *
     * @return array|FALSE The data array for the content item or FALSE upon failure
     */
    public function existingData($site_id, $id)
    {
        $sql = "SELECT 
                    `uscj`.`name`, 
                    `uscj`.`content`, 
                    `uspcij`.`button_label`
				FROM 
				    `user_site_page_content_item_jumbotron` `uspcij` 
				INNER JOIN 
				    `user_site_content_jumbotron` `uscj` ON 
				        `uspcij`.`data_id` = `uscj`.`id` AND 
				        `uscj`.`site_id` = :site_id 
				WHERE 
				    `uspcij`.`site_id` = :site_id AND 
				    `uspcij`.`content_id` = :content_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Add a new jumbotron content item
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

        if (strlen($params['intro']) > 0) {
            $content = $params['title'] . Dlayer_Config::CONTENT_DELIMITER . $params['intro'];
        } else {
            $content = $params['title'];
        }

        $data_id = $this->existingDataIdOrFalse($site_id, $content, 'Jumbotron');

        if ($data_id === false) {
            $data_id = $this->addData($site_id, $params['name'], $content);
        }

        if ($data_id !== false) {
            $sql = "INSERT INTO `user_site_page_content_item_jumbotron` 
                    (
                        `site_id`, 
                        `page_id`, 
                        `content_id`, 
                        `data_id`, 
                        `button_label`
                    ) 
                    VALUES 
                    (
                        :site_id, 
                        :page_id, 
                        :content_id, 
                        :data_id, 
                        :button_label
                    )";
            $stmt = $this->_db->prepare($sql);
            $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
            $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
            $stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
            $stmt->bindValue(':data_id', $data_id, PDO::PARAM_INT);
            $stmt->bindValue(':button_label', $params['button_label'], PDO::PARAM_STR);
            $result = $stmt->execute();
        }

        return $result;
    }


    /**
     * Edit the existing data
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $content_id
     * @param array $params The params data array from the tool
     *
     * @return boolean
     * @throws Exception
     */
    public function edit($site_id, $page_id, $content_id, array $params)
    {
        /**
         * @var false|integer If not false delete the data for this data id
         */
        $delete = false;
        $content_type = 'Jumbotron';

        // Fetch the current data id, validity check, no real reason to fail
        $assigned_data_id = $this->assignedContentDataId($site_id, $page_id, $content_id, $content_type);
        if ($assigned_data_id === false) {
            throw new Exception('Error fetching the existing data id for content id: ' . $content_id);
        }

        // Build the new? content string
        if (strlen($params['intro']) > 0) {
            $content = $params['title'] . Dlayer_Config::CONTENT_DELIMITER . $params['intro'];
        } else {
            $content = $params['title'];
        }

        // Get the data id for the content string ignoring the existing item
        $data_id_by_content_id = $this->existingDataIdOrFalse($site_id, $content, $content_type, $assigned_data_id);

        if (array_key_exists('instances', $params) === true) {
            if ($params['instances'] === 1) {
                // Update all instances of the data
                if ($data_id_by_content_id === false) {
                    if ($this->updateDataTable($site_id, $assigned_data_id, $params['name'], $content,
                            $content_type) === false
                    ) {
                        throw new Exception('Error updating the data for content id: ' . $content_id);
                    }
                } else {
                    if ($this->assignNewDataIdToContentItems($site_id, $data_id_by_content_id, $assigned_data_id,
                            $content_type) === false
                    ) {
                        throw new Exception('Error updating data id for text content items using data id: ' .
                            $assigned_data_id);
                    }

                    $delete = $assigned_data_id;
                }
            } else {
                // Only update the current instance
                if ($data_id_by_content_id === false) {
                    $data_id_by_content_id = $this->addData($site_id, $params['name'], $content);
                }

                $this->assignNewDataIdToContentItem($site_id, $data_id_by_content_id, $content_id, $content_type);
            }
        } else {
            if ($data_id_by_content_id === false) {
                if ($this->updateDataTable($site_id, $assigned_data_id, $params['name'], $content, $content_type) ===
                    false
                ) {
                    throw new Exception('Error updating the data for content id: ' . $content_id);
                }
            } else {
                if ($this->assignNewDataIdToContentItem($site_id, $data_id_by_content_id, $content_id,
                        $content_type) === false
                ) {
                    throw new Exception('Error updating data id for content id: ' . $content_id);
                }

                // $delete = $assigned_data_id;
                // @todo Not safe to delete, may be in use
            }
        }

        // Delete redundant data if necessary
        if ($delete !== false) {
            $this->deleteDataId($site_id, $delete, $content_type);
        }

        // Update content data table if necessary
        if ($this->updateContentItem($site_id, $page_id, $content_id, $params) === true) {
            return true;
        } else {
            return false;
        }
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
                    `user_site_page_content_item_jumbotron`  
				SET 
				    `button_label` = :button_label
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
        $stmt->bindValue(':button_label', $params['button_label'], PDO::PARAM_STR);
        $result = $stmt->execute();

        return $result;
    }

    /**
     * Add the new content item data into the content table for text items
     *
     * @param integer $site_id
     * @param string $name
     * @param string $content
     *
     * @return integer|false The id for the new data or FALSE upon failure
     */
    private function addData($site_id, $name, $content)
    {
        $sql = "INSERT INTO `user_site_content_jumbotron` 
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
            return intval($this->_db->lastInsertId('user_site_content_jumbotron'));
        } else {
            return false;
        }
    }
}
