<?php

/**
 * Shared model class for elements
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_Shared_Model_Element extends Zend_Db_Table_Abstract
{
    /**
     * Fetch the existing field data
     *
     * @param integer $site_id
     * @param integer $form_id
     * @param integer $id
     *
     * @return array|false The data array for the field or false upon failure
     */
    public function fieldData($site_id, $form_id, $id)
    {
        $sql = "SELECT 
                    `usff`.`id`, 
                    `dffa`.`attribute`, 
                    `usffa`.`attribute` AS `value`, 
                    `dfft`.`type`, 
                    `dffat`.`type` AS `attribute_type` 
                FROM 
                    `user_site_form_field_attribute` `usffa`
                INNER JOIN 
                    `designer_form_field_attribute` `dffa` ON 
                        `usffa`.`attribute_id` = `dffa`.`id` 
                INNER JOIN 
                    `user_site_form_field` `usff` ON 
                        `usffa`.`field_id` = `usff`.`id` AND 
                        `usff`.`site_id` = :site_id AND 
                        `usff`.`form_id` = :form_id 
                INNER JOIN 
                    `designer_form_field_attribute_type` `dffat` ON 
                        `dffa`.`attribute_type_id` = `dffat`.`id` 
                INNER JOIN 
                    `designer_form_field_type` `dfft` ON 
                        `usff`.`field_type_id` = `dfft`.`id` 
                WHERE 
                    `usffa`.`site_id` = :site_id AND 
                    `usffa`.`form_id` = :form_id AND 
                    `usffa`.`field_id` = :field_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
        $stmt->bindValue(':field_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Add a new form field
     *
     * @param integer $site_id
     * @param integer $form_id
     * @param string $field_type
     *
     * @return integer|false
     */
    public function addField($site_id, $form_id, $field_type)
    {
        $field_id = false;

        $sort_order = $this->sortOrderForNewField($site_id, $form_id);
        if ($sort_order === false) {
            $sort_order = 1;
        }

        $sql = "INSERT INTO `user_site_form_field` 
				(
				    `site_id`, 
				    `form_id`, 
				    `field_type_id`, 
				    `sort_order`
                ) 
				VALUES 
				(
				    :site_id, 
				    :form_id, 
				     (
				        SELECT 
				            `id` 
                        FROM 
                            `designer_form_field_type` 
                        WHERE 
                            `type` = :field_type 
                        LIMIT 
                            1
                    ),                    
                    :sort_order
                )";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
        $stmt->bindValue(':field_type', $field_type, PDO::PARAM_INT);
        $stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
        $result = $stmt->execute();

        if ($result === true) {
            $field_id = intval($this->_db->lastInsertId('user_site_form_field'));
        }

        return $field_id;
    }

    /**
     * Delete the form field
     *
     * @param integer $site_id
     * @param integer $form_id
     * @param integer $id
     *
     * @return boolean
     */
    public function deleteField($site_id, $form_id, $id)
    {
        $sql = "DELETE FROM 
                    `user_site_form_field` 
                WHERE 
                    `site_id` = :site_id AND 
                    `form_id` = :form_id AND 
                    `id` = :field_id 
                LIMIT 
                    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
        $stmt->bindValue(':field_id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Calculate the sort order for the new form field
     *
     * @param integer $site_id
     * @param integer $form_id
     *
     * @return integer|false The new sort order
     */
    private function sortOrderForNewField($site_id, $form_id)
    {
        $sql = "SELECT 
                    IFNULL(MAX(`sort_order`), 0) + 1 AS `sort_order`
				FROM 
				    `user_site_form_field` 
				WHERE 
				    `site_id` = :site_id AND 
				    `form_id` = :form_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result !== false) {
            return intval($result['sort_order']);
        } else {
            return false;
        }
    }

    /**
     * Add attributes for form field
     *
     * @param integer $site_id
     * @param integer $form_id
     * @param integer $id
     * @param array $attributes
     * @param string $field_type
     *
     * @return boolean
     */
    public function addAttributes($site_id, $form_id, $id, array $attributes, $field_type)
    {
        $sql = "INSERT INTO `user_site_form_field_attribute` 
				(
				    `site_id`, 
				    `form_id`, 
				    `field_id`, 
				    `attribute_id`, 
				    `attribute`
                )
				VALUES
				(
				    :site_id, 
				    :form_id, 
				    :field_id,
				    (
				        SELECT 
				            `dffa`.`id` 
                        FROM 
                            `designer_form_field_attribute` `dffa` 
                        
                        INNER JOIN 
                            `designer_form_field_type` `dfft` ON 
                                `dffa`.`field_type_id` = `dfft`.`id` AND 
                                `dfft`.`type` = :field_type
                        WHERE 
                            `dffa`.`attribute` = :attribute
                        ), 
                        :value
                )";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
        $stmt->bindValue(':field_id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':field_type', $field_type, PDO::PARAM_STR);

        $results = array();

        foreach($attributes as $attribute => $value) {
            $stmt->bindValue(':attribute', $attribute, PDO::PARAM_STR);
            $stmt->bindValue(':value', $value, PDO::PARAM_STR);

            $results[] = $stmt->execute();
        }

        if (in_array(false, $results) === true) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Edit the attributes for the selected form field
     *
     * @param integer $site_id
     * @param integer $form_id
     * @param integer $id
     * @param array $attributes
     * @param string $field_type
     *
     * @return boolean
     */
    public function editAttributes($site_id, $form_id, $id, array $attributes, $field_type)
    {
        $sql = "UPDATE 
                    `user_site_form_field_attribute`
				SET 
				    `attribute` = :value
				WHERE 
				    `site_id` = :site_id AND 
				    `form_id` = :form_id AND 
				    `field_id` = :field_id AND 
				    `attribute_id` = (
				        SELECT 
				            `dffa`.`id`
                        FROM 
                            `designer_form_field_attribute` `dffa` 
                        INNER JOIN 
                            `designer_form_field_type` `dfft` ON 
                                `dffa`.`field_type_id` = `dfft`.`id` 
                        WHERE 
                            `dffa`.`attribute` = :attribute AND 
                            `dfft`.`type` = :field_type
                        )";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
        $stmt->bindValue(':field_id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':field_type', $field_type, PDO::PARAM_STR);

        $results = array();

        foreach($attributes as $attribute => $value) {
            $stmt->bindValue(':attribute', $attribute, PDO::PARAM_STR);
            $stmt->bindValue(':value', $value, PDO::PARAM_STR);

            $results[] = $stmt->execute();
        }

        if (in_array(false, $results) === true) {
            return false;
        } else {
            return true;
        }
    }
}
