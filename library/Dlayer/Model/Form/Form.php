<?php

/**
 * Form model, handles Dlayer changes to form that are separate to tools
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Model_Form_Form extends Zend_Db_Table_Abstract
{
    /**
     * Check to see if the given form field is valid, needs to belong to both the site and form
     *
     * @param integer $id
     * @param integer $site_id
     * @param integer $field_id
     * @return boolean
     */
    public function fieldValid($id, $site_id, $field_id)
    {
        $sql = "SELECT 
                    `uff`.`id`
				FROM 
				    `user_site_form_field` `uff`
				WHERE 
				    `uff`.`form_id` = :form_id AND 
				    `uff`.`site_id` = :site_id AND 
				    `uff`.`id` = :field_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':form_id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':field_id', $field_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();

        if($result !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Move the form field
     *
     * @param integer $id
     * @param integer $site_id
     * @param integer $field_id
     * @param string $direction
     *
     * @return void
     */
    public function moveField($id, $site_id, $field_id, $direction)
    {
        $current_sort_order = $this->fieldSortOrder($id, $site_id, $field_id);
        $new_sort_order = false;
        $sibling_field_id = false;
        $sibling_sort_order = false;

        if ($current_sort_order !== false) {
            switch ($direction) {
                case 'up':
                    if ($current_sort_order > 0) {
                        $sibling_field_id = $this->getFieldIdBySortOrder($id, $site_id, ($current_sort_order - 1));

                        if ($sibling_field_id !== false) {
                            $new_sort_order = $current_sort_order - 1;
                            $sibling_sort_order = $current_sort_order;
                        }
                    }
                    break;

                case 'down':
                    if ($current_sort_order > 0) {
                        $sibling_field_id = $this->getFieldIdBySortOrder($id, $site_id, ($current_sort_order + 1));

                        if ($sibling_field_id !== false) {
                            $new_sort_order = $current_sort_order + 1;
                            $sibling_sort_order = $current_sort_order;
                        }
                    }
                    break;

                default:
                    break;
            }
        }

        if ($new_sort_order !== false && $sibling_field_id !== false && $sibling_sort_order !== false) {
            $this->setFieldSortOrder($id, $site_id, $field_id, $new_sort_order);
            $this->setFieldSortOrder($id, $site_id, $sibling_field_id, $sibling_sort_order);
        }
    }

    /**
     * Fetch the sort order for a form field
     *
     * @param integer $id
     * @param integer $site_id
     * @param integer $field_id
     *
     * @return integer|false
     */
    private function fieldSortOrder($id, $site_id, $field_id)
    {
        $sql = "SELECT 
                    `sort_order` 
				FROM 
				    `user_site_form_field`  
				WHERE 
				    `form_id` = :form_id AND 
				    `site_id` = :site_id AND 
				    `id` = :field_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':form_id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':field_id', $field_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result !== false) {
            return intval($result['sort_order']);
        } else {
            return false;
        }
    }

    /**
     * Fetch the id of a form fields by its sort order
     *
     * @param integer $id
     * @param integer $site_id
     * @param integer $sort_order
     *
     * @return integer|false
     */
    private function getFieldIdBySortOrder($id, $site_id, $sort_order)
    {
        $sql = "SELECT 
                    `id` 
				FROM 
				    `user_site_form_field`  
				WHERE 
				    `form_id` = :form_id AND 
				    `site_id` = :site_id AND 
				    `sort_order` = :sort_order";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':form_id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result !== false) {
            return intval($result['id']);
        } else {
            return false;
        }
    }

    /**
     * Set the sort order for a form field
     *
     * @param integer $id
     * @param integer $site_id
     * @param integer $field_id
     * @param integer $sort_order
     *
     * @return boolean
     */
    private function setFieldSortOrder($id, $site_id, $field_id, $sort_order)
    {
        $sql = "UPDATE 
                    `user_site_form_field`  
				SET 
				    `sort_order` = :sort_order 
				WHERE 
				    `id` = :field_id AND 
				    `site_id` = :site_id AND 
				    `form_id` = :form_id
				LIMIT 
				    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':form_id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':field_id', $field_id, PDO::PARAM_INT);
        $stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
