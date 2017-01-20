<?php

/**
 * Data model for the responsive sub tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Column_SubTool_Responsive_Model extends Zend_Db_Table_Abstract
{
    /**
     * Fetch any assigned responsive column widths
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id Column id
     *
     * @return array
     */
    public function responsiveWidths($site_id, $page_id, $id)
    {
        $sql = "SELECT 
                    `uspscr`.`size` AS `width`, 
                    `dct`.`column_type`
                FROM 
                    `user_site_page_structure_column_responsive` `uspscr` 
                INNER JOIN 
                    `designer_column_type` dct ON 
                        `uspscr`.`column_type_id` = `dct`.`id` 
                WHERE 
                    `uspscr`.`site_id` = :site_id AND 
                    `uspscr`.`page_id` = :page_id AND 
                    `uspscr`.`column_id` = :column_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id);
        $stmt->bindValue(':page_id', $page_id);
        $stmt->bindValue(':column_id', $id);
        $stmt->execute();

        $result = $stmt->fetchAll();

        $columns = array(
            'xs' => false,
            'sm' => false,
            'lg' => false,
        );

        foreach ($result as $row) {
            $columns[$row['column_type']] = intval($row['width']);
        }

        return $columns;
    }

    /**
     * Remove the responsive definition for column
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id Column id
     * @param string $column_type
     *
     * @return boolean
     */
    public function removeResponsiveDefinition($site_id, $page_id, $id, $column_type)
    {
        $sql = "DELETE 
                    `uspscr`
                FROM 
                    `user_site_page_structure_column_responsive` `uspscr`
                INNER JOIN 
                    `designer_column_type` `dct` ON 
                        `uspscr`.`column_type_id` = `dct`.`id`
                WHERE 
                    `uspscr`.`site_id` = :site_id AND 
                    `uspscr`.`page_id` = :page_id AND 
                    `uspscr`.`column_id` = :column_id AND 
                    `dct`.`column_type` = :column_type";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id);
        $stmt->bindValue(':page_id', $page_id);
        $stmt->bindValue(':column_id', $id);
        $stmt->bindValue(':column_type', $column_type);

        return $stmt->execute();
    }

    /**
     * Add a responsive definition for column
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id Column id
     * @param string $column_type
     * @param integer $size
     *
     * @return boolean
     */
    public function addResponsiveDefinition($site_id, $page_id, $id, $column_type, $size)
    {
        $sql = "INSERT INTO `user_site_page_structure_column_responsive` 
                (
                    `site_id`, 
                    `page_id`, 
                    `column_id`, 
                    `column_type_id`, 
                    `size`
                )
                VALUES
                (
                    :site_id, 
                    :page_id, 
                    :column_id,
                    (
                        SELECT 
                            `id` 
                        FROM 
                            `designer_column_type` 
                        WHERE 
                            `column_type` = :column_type
                    ),
                    :size
                )";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id);
        $stmt->bindValue(':page_id', $page_id);
        $stmt->bindValue(':column_id', $id);
        $stmt->bindValue(':column_type', $column_type);
        $stmt->bindValue(':size', $size);

        return $stmt->execute();
    }

    /**
     * Update a responsive definition for column
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id Column id
     * @param string $column_type
     * @param integer $size
     *
     * @return boolean
     */
    public function updateResponsiveDefinition($site_id, $page_id, $id, $column_type, $size)
    {
        $sql = "UPDATE 
                    `user_site_page_structure_column_responsive` 
                INNER JOIN 
                    `designer_column_type` ON 
                        `user_site_page_structure_column_responsive`.`column_type_id` = `designer_column_type`.`id`
                SET 
                    `size` = :size
                WHERE 
                    `user_site_page_structure_column_responsive`.`site_id` = :site_id AND 
                    `user_site_page_structure_column_responsive`.`page_id` = :page_id AND 
                    `user_site_page_structure_column_responsive`.`column_id` = :column_id AND 
                    `designer_column_type`.`column_type` = :column_type";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id);
        $stmt->bindValue(':page_id', $page_id);
        $stmt->bindValue(':column_id', $id);
        $stmt->bindValue(':column_type', $column_type);
        $stmt->bindValue(':size', $size);

        return $stmt->execute();
    }
}
