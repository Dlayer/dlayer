<?php

/**
 * Base class for all content item models, handles management of the content data
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Shared_Model_Content_Item extends Zend_Db_Table_Abstract
{
    /**
     * Check to see if the content exists in the data tables, if so we re-use the content
     *
     * @param integer $site_id
     * @param string $content
     * @param string $content_type
     * @param integer|null $ignore_id
     *
     * @return integer|false Id of the existing data array or FALSE if a new content item
     * @throws Exception
     */
    protected function existingDataIdOrFalse($site_id, $content, $content_type, $ignore_id = null)
    {
        $table = $this->contentItemDataTable($content_type);

        $sql = "SELECT 
                    `id` 
                FROM 
                    `{$table}` 
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
     * Fetch the current data id for a content item
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $content_id
     * @param string $content_type
     *
     * @return false|int Should only return false if the query failed for some reason
     * @throws Exception
     */
    protected function assignedContentDataId($site_id, $page_id, $content_id, $content_type)
    {
        $table = $this->contentItemTable($content_type);

        $sql = "SELECT 
                    `data_id`
				FROM 
				    `{$table}` 
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

        if ($result !== false) {
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
     * @param string $content_type
     *
     * @return boolean
     * @throws Exception
     */
    protected function updateDataTable($site_id, $id, $name, $content, $content_type)
    {
        $table = $this->contentItemDataTable($content_type);

        $sql = "UPDATE 
                    `{$table}`
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
     * @param string $content_type
     *
     * @return boolean
     * @throws Exception
     */
    protected function assignNewDataIdToContentItem($site_id, $new_data_id, $content_id, $content_type)
    {
        $table = $this->contentItemTable($content_type);

        $sql = "UPDATE 
                    `{$table}`  
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
     * @param string $content_type
     *
     * @return boolean
     * @throws Exception
     */
    protected function deleteDataId($site_id, $id, $content_type)
    {
        $table = $this->contentItemDataTable($content_type);

        $sql = "DELETE FROM 
                    `{$table}`
                WHERE 
                    `site_id` = :site_id AND 
                    `id` = :delete_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':delete_id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Assign a new data id to the content items that use the supplied data id
     *
     * @param integer $site_id
     * @param integer $new_data_id
     * @param integer $current_data_id
     * @param string $content_type
     *
     * @return boolean
     * @throws Exception
     */
    protected function assignNewDataIdToContentItems($site_id, $new_data_id, $current_data_id, $content_type)
    {
        $table = $this->contentItemTable($content_type);

        $sql = "UPDATE 
                    `{$table}`  
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

    /**
     * Fetch the name of the content item table for the given content type
     *
     * @param $content_type
     *
     * @return string
     * @throws Exception
     */
    protected function contentItemTable($content_type)
    {
        switch ($content_type) {
            case 'BlogPost':
                $table = 'user_site_page_content_item_blog_post';
                break;

            case 'HeadingDate':
                $table = 'user_site_page_content_item_heading_date';
                break;

            case 'Heading':
                $table = 'user_site_page_content_item_heading';
                break;

            case 'Html':
                $table = 'user_site_page_content_item_html';
                break;

            case 'Jumbotron':
                $table = 'user_site_page_content_item_jumbotron';
                break;

            case 'RichText':
                $table = 'user_site_page_content_item_rich_text';
                break;

            case 'Text':
                $table = 'user_site_page_content_item_text';
                break;

            default:
                throw new Exception('Shared_Model::contentItemTable Content type not supported: ' . $content_type);
                break;
        }

        return $table;
    }

    /**
     * Fetch the name of the content item data table for the given content type
     *
     * @param string $content_type
     *
     * @return string
     * @throws Exception
     */
    protected function contentItemDataTable($content_type)
    {
        switch ($content_type) {
            case 'BlogPost':
                $table = 'user_site_content_blog_post';
                break;

            case 'HeadingDate':
                $table = 'user_site_content_heading_date';
                break;

            case 'Heading':
                $table = 'user_site_content_heading';
                break;

            case 'Html':
                $table = 'user_site_content_html';
                break;

            case 'Jumbotron':
                $table = 'user_site_content_jumbotron';
                break;

            case 'RichText':
                $table = 'user_site_content_rich_text';
                break;

            case 'Text':
                $table = 'user_site_content_text';
                break;

            default:
                throw new Exception('Shared_Model::contentItemDataTable Content type not supported: ' . $content_type);
                break;
        }

        return $table;
    }

    /**
     * Check to see how many instances there are of the requested content item
     *
     * @param integer $site_id
     * @param integer $content_id
     * @param string $content_type
     *
     * @return integer The number of instances
     */
    public function instancesOfData($site_id, $content_id, $content_type)
    {
        $table = $this->contentItemTable($content_type);

        $sql = "SELECT 
                    COUNT(`content`.`id`) AS `instances`
				FROM 
				    `{$table}` `content`
				WHERE 
				    `content`.`data_id` = (
				        SELECT 
				            `content_instances`.`data_id`
				        FROM 
				            `{$table}` `content_instances`
				        WHERE 
				            `content_instances`.`site_id` = :site_id AND 
				            `content_instances`.`content_id` = :content_id 
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
}
