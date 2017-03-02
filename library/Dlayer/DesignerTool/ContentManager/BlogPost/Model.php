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

        $data_id = $this->existingDataIdOrFalse($site_id, $content, 'blog-post');

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
     * Add the new content item data into the content table for rich text items
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
}
