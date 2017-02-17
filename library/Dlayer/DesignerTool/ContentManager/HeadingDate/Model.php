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
            'dd/mm/yyyy' => '15/02/2017',
            'F j, Y' => 'February 15, 2017',
            'jS F Y' => '15th Feb 2017'
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
     * Check to see if the content exists in the data tables, if so we re-use the data from a previous content item
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
}
