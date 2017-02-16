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
}
