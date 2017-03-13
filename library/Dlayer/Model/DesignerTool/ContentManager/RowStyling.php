<?php

/**
 * Row styling model class, tool 'models' interact with this to protect underlying structure
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Model_DesignerTool_ContentManager_RowStyling extends Zend_Db_Table_Abstract
{
    /**
     * Fetch an attribute that has been assigned to the requested row
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id
     * @param string $attribute
     *
     * @return array|false
     */
    public function getAttributeValue($site_id, $page_id, $id, $attribute)
    {
        $sql = "SELECT 
                    `value` 
                FROM 
                    `user_site_row_styling`
                WHERE 
                    `site_id` = :site_id AND 
                    `page_id` = :page_id AND 
                    `row_id` = :row_id AND 
                    `attribute` = :attribute
                LIMIT 
                    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':row_id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':attribute', $attribute, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result !== false) {
            return $result['value'];
        } else {
            return false;
        }
    }

    /**
     * Check to see if an attribute exists on the requested row
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id
     * @param string $attribute
     *
     * @return integer|false
     */
    public function existingAttributeId($site_id, $page_id, $id, $attribute)
    {
        $sql = "SELECT 
                    `id` 
                FROM 
                    `user_site_row_styling` 
                WHERE 
                    `site_id` = :site_id AND 
                    `page_id` = :page_id AND 
                    `row_id` = :row_id AND 
                    `attribute` = :attribute 
                LIMIT 
                    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':row_id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':attribute', $attribute, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch();
        if ($result !== false) {
            return intval($result['id']);
        } else {
            return false;
        }
    }

    /**
     * Add a new attribute/value to the requested row
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id
     * @param string $attribute
     * @param string $value
     *
     * @return boolean
     */
    public function addAttributeValue($site_id, $page_id, $id, $attribute, $value)
    {
        $sql = "INSERT INTO `user_site_row_styling`  
                (
                    `site_id`, 
                    `page_id`, 
                    `row_id`,
                    `attribute`, 
                    `value`
                ) 
                VALUES 
                (
                    :site_id, 
                    :page_id, 
                    :row_id, 
                    :attribute,
                    :value
                )";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':row_id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':attribute', $attribute, PDO::PARAM_STR);
        $stmt->bindValue(':value', $value, PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * Edit an attribute value
     *
     * @param integer $id
     * @param string $value
     *
     * @return boolean
     */
    public function editAttributeValue($id, $value)
    {
        if (strlen($value) !== 0) {
            return $this->updateAttributeValue($id, $value);
        } else {
            return $this->deleteAttributeValue($id);
        }
    }

    /**
     * Update an attribute value
     *
     * @param integer $id
     * @param string $value
     *
     * @return boolean
     */
    private function updateAttributeValue($id, $value)
    {
        $sql = "UPDATE 
                    `user_site_row_styling` 
                SET 
                    `value` = :value 
                WHERE 
                    `id` = :id
                LIMIT 
                    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':value', $value);

        return $stmt->execute();
    }

    /**
     * Remove an attribute value
     *
     * @param integer $id
     *
     * @return boolean
     */
    private function deleteAttributeValue($id)
    {
        $sql = "DELETE FROM `user_site_row_styling` 
                WHERE 
                    `id` = :id 
                LIMIT 
                    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }
}
