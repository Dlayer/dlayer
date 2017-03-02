<?php

/**
 * Blog post item data model
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_BlogPost_Model extends
    Dlayer_DesignerTool_ContentManager_Shared_Model_Content
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
				    `user_site_page_content_item_blog_post` `content`
				WHERE 
				    `content`.`data_id` = (
				        SELECT 
				            `uspcibp`.`data_id`
				        FROM 
				            `user_site_page_content_item_blog_post` `uspcibp`
				        WHERE 
				            `uspcibp`.`site_id` = :site_id AND 
				            `uspcibp`.`content_id` = :content_id 
					LIMIT 
					    1)";
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
     * Add a new blog post content item
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

        $content = $params['heading'] . Dlayer_Config::CONTENT_DELIMITER .
            $params['date'] . Dlayer_Config::CONTENT_DELIMITER . $params['content'];

        $data_id = $this->existingDataIdOrFalse($site_id, $content, 'BlogPost');

        if ($data_id === false) {
            $data_id = $this->addData($site_id, $params['name'], $content);
        }

        if ($data_id !== false) {
            $sql = "INSERT INTO `user_site_page_content_item_blog_post` 
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
     * Add the new content item data into the content table for blog posts
     *
     * @param integer $site_id
     * @param string $name
     * @param string $content
     * @return integer|false The id for the new data or false upon failure
     */
    private function addData($site_id, $name, $content)
    {
        $sql = "INSERT INTO `user_site_content_blog_post` 
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
            return intval($this->_db->lastInsertId('user_site_content_blog_post'));
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
                    `uscbp`.`name`, 
                    `uscbp`.`content`, 
                    `uspcibp`.`format`, 
                    `uspcibp`.`heading_id`
				FROM 
				    `user_site_page_content_item_blog_post` `uspcibp` 
				INNER JOIN 
				    `user_site_content_blog_post` `uscbp` ON 
				        `uspcibp`.`data_id` = uscbp.id AND 
				        `uscbp`.`site_id` = :site_id 
				WHERE 
				    `uspcibp`.`site_id` = :site_id AND 
				    `uspcibp`.`content_id` = :content_id";
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
        $content_type = 'BlogPost';

        // Fetch the current data id, validity check, no real reason to fail
        $assigned_data_id = $this->assignedContentDataId($site_id, $page_id, $content_id, $content_type);
        if($assigned_data_id === false) {
            throw new Exception('Error fetching the existing data id for content id: ' . $content_id);
        }

        // Build the new? content string
        $content = $params['heading'] . Dlayer_Config::CONTENT_DELIMITER .
            $params['date'] . Dlayer_Config::CONTENT_DELIMITER . $params['content'];

        // Get the data id for the content string ignoring the existing item
        $data_id_by_content_id = $this->existingDataIdOrFalse($site_id, $content, $content_type, $assigned_data_id);

        if (array_key_exists('instances', $params) === true) {
            if ($params['instances'] === 1) {
                // Update all instances of the data
                if ($data_id_by_content_id === false) {
                    if ($this->updateDataTable($site_id, $assigned_data_id, $params['name'], $content, $content_type) === false) {
                        throw new Exception('Error updating the data for content id: ' . $content_id);
                    }
                } else {
                    if ($this->assignNewDataIdToContentItems($site_id, $data_id_by_content_id, $assigned_data_id, $content_type) === FALSE) {
                        throw new Exception('Error updating data id for text content items using data id: ' . $assigned_data_id);
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
                if ($this->updateDataTable($site_id, $assigned_data_id, $params['name'], $content, $content_type) === false) {
                    throw new Exception('Error updating the data for content id: ' . $content_id);
                }
            } else {
                if ($this->assignNewDataIdToContentItem($site_id, $data_id_by_content_id, $content_id, $content_type) === false) {
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
                    `user_site_page_content_item_blog_post`
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
}
