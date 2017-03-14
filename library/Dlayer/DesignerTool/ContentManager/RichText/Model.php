<?php

/**
 * Data model for the rich text content item
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_RichText_Model extends
    Dlayer_DesignerTool_ContentManager_Shared_Model_Content_Item
{
    /**
     * Add a new text content item
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

        $data_id = $this->existingDataIdOrFalse($site_id, $params['content'], 'RichText');

        if ($data_id === false) {
            $data_id = $this->addData($site_id, $params['name'], $params['content']);
        }

        if ($data_id !== false) {
            $sql = "INSERT INTO `user_site_page_content_item_rich_text` 
                    (
                        `site_id`, 
                        `page_id`, 
                        `content_id`, 
                        `data_id`
                    ) 
                    VALUES 
                    (
                        :site_id, 
                        :page_id, 
                        :content_id, 
                        :data_id
                    )";
            $stmt = $this->_db->prepare($sql);
            $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
            $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
            $stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
            $stmt->bindValue(':data_id', $data_id, PDO::PARAM_INT);
            $result = $stmt->execute();
        }

        return $result;
    }

    /**
     * Add the new content item data into the content table for rich text items
     *
     * @param integer $site_id
     * @param string $name
     * @param string $content
     * @return integer|FALSE The id for the new data or FALSE upon failure
     */
    private function addData($site_id, $name, $content)
    {
        $sql = "INSERT INTO `user_site_content_rich_text` 
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

        if($result === TRUE)
        {
            return intval($this->_db->lastInsertId('user_site_content_rich_text'));
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Fetch the existing data for the content item
     *
     * @param integer $site_id
     * @param integer $id
     *
     * @return array|false The data array for the content item or false upon failure
     */
    public function existingData($site_id, $id)
    {
        $sql = "SELECT 
                    `uscrt`.`name`, 
                    `uscrt`.`content`
				FROM 
				    `user_site_page_content_item_rich_text` `uspcirt` 
				INNER JOIN 
				    `user_site_content_rich_text` `uscrt` ON 
				        `uspcirt`.`data_id` = uscrt.id AND 
				        `uscrt`.`site_id` = :site_id 
				WHERE 
				    `uspcirt`.`site_id` = :site_id AND 
				    `uspcirt`.`content_id` = :content_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Edit the existing data
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $content_id
     * @param array $params The params data array from the tool
     *
     * @return TRUE
     * @throws Exception
     */
    public function edit($site_id, $page_id, $content_id, array $params)
    {
        /**
         * @var false|integer If not false delete the data for this data id
         */
        $delete = false;
        $content_type = 'RichText';

        // Fetch the current data id, validity check, no real reason to fail
        $assigned_data_id = $this->assignedContentDataId($site_id, $page_id, $content_id, $content_type);
        if ($assigned_data_id === false) {
            throw new Exception('Error fetching the existing data id for content id: ' . $content_id);
        }

        // Build the new? content string
        $content = $params['content'];

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
                        throw new Exception('Error updating data id for content items using data id: ' .
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

        return true;
    }
}
