<?php

/**
 * Form builder view model. The view model is responsible for fetching all the form and field data required to generate
 * the requested form
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 * @category View model
 */
class Dlayer_Model_View_Form extends Zend_Db_Table_Abstract
{
    /**
     * @var integer
     */
    private $site_id;

    /**
     * @var integer
     */
    private $id;

    /**
     * Pass in the properties required by the model
     *
     * @param integer $site_id
     * @param integer $id
     *
     * @return void
     */
    public function setUp($site_id, $id)
    {
        $this->site_id = $site_id;
        $this->id = $id;
    }

    /**
     * Fetch all the form fields that have been added to the requested form
     *
     * @return array Array of the forms field
     */
    public function fields()
    {
        $attributes = $this->attributes();

        $sql = "SELECT 
                    `uff`.`id`, 
                    `uff`.`label`, 
                    `uff`.`description`, 
                    `fft`.`type`,
                    `dmt`.`model` 
				FROM 
				    `user_site_form_field` `uff`
				INNER JOIN 
				    `designer_form_field_type` `fft` ON 
				        `uff`.`field_type_id` = `fft`.`id` 
                INNER JOIN 
                    `dlayer_module_tool` `dmt` ON 
                        `uff`.`tool_id` = `dmt`.`id` AND 
                        `dmt`.`enabled` = 1 
                INNER JOIN 
                    `dlayer_module` `dm` ON 
                        `dmt`.`module_id` = `dm`.`id` AND 
                        `dm`.`name` = :module
				WHERE 
				    `uff`.`site_id` = :site_id AND 
				    `uff`.`form_id` = :form_id
				ORDER BY 
				    `uff`.`sort_order` ASC";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $this->site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':module', 'form', PDO::PARAM_STR);
        $stmt->execute();

        $results = $stmt->fetchAll();

        $fields = array();

        foreach ($results as $row) {
            if (array_key_exists($row['id'], $attributes) == true) {
                $row['attributes'] = $attributes[$row['id']];
            } else {
                $row['attributes'] = array();
            }
            $fields[] = $row;
        }

        return $fields;
    }

    /**
     * Fetch the ids of the form fields that have been added to this form,
     * returns an array with the field ids as the keys and an empty array as
     * the value
     *
     * @return array
     */
    public function fieldIds()
    {
        $sql = "SELECT 
                    `id`
				FROM 
				    `user_site_form_field`
				WHERE 
				    `site_id` = :site_id AND 
				    `form_id` = :form_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $this->site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $this->id, PDO::PARAM_INT);
        $stmt->execute();

        $results = $stmt->fetchAll();

        $field_ids = array();

        foreach ($results as $row) {
            $field_ids[$row['id']] = array();
        }

        return $field_ids;
    }

    /**
     * Fetch all the attributes that are assign to fields for the requested form
     *
     * @return array Array of attributes indexed by field id
     */
    private function attributes()
    {
        $sql = "SELECT 
                    `uffa`.`field_id`, 
                    `uffa`.`attribute` AS `value`,
                    `ffa`.`attribute`, 
                    `ffat`.`type`
				FROM 
				    `user_site_form_field_attribute` `uffa`
				INNER JOIN 
				    `designer_form_field_attribute` `ffa` ON 
				        `uffa`.`attribute_id` = `ffa`.`id` 
                INNER JOIN 
                    `designer_form_field_attribute_type` `ffat` ON 
                        `ffa`.`attribute_type_id` = `ffat`.`id` 
				WHERE 
				    `uffa`.`site_id` = :site_id AND 
				    `uffa`.`form_id` = :form_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $this->site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $this->id, PDO::PARAM_INT);
        $stmt->execute();

        $results = $stmt->fetchAll();

        $attributes = array();

        foreach ($results as $row) {
            switch ($row['type']) {
                case 'integer':
                    $value = intval($row['value']);
                    break;

                default:
                    $value = $row['value'];
                    break;
            }

            $attributes[$row['field_id']][$row['attribute']] = $value;
        }

        return $attributes;
    }
}
