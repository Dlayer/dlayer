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
            'lg' => false
        );

        foreach ($result as $row) {
            $columns[$row['column_type']] = intval($row['width']);
        }

        return $columns;
    }
}
