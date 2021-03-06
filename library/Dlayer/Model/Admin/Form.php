<?php

/**
 * Admin module for form management
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 * @category Model
 */
class Dlayer_Model_Admin_Form extends Zend_Db_Table_Abstract
{
    /**
     * Add a new form to Dlayer
     *
     * @param integer $site_id Site the form belongs to
     * @param array $params
     *
     * @return integer|false Either the id of the new form of false upon failure
     */
    private function addForm($site_id, $params)
    {
        $sql = "INSERT INTO `user_site_form` 
				(
				    `site_id`, 
				    `name`
                ) 
				VALUES
				(
				    :site_id, 
				    :name
				)";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $params['name'], PDO::PARAM_STR);

        if ($stmt->execute() === true) {
            $id = intval($this->_db->lastInsertId('user_site_form'));

            if ($this->setDefaultLayout($site_id, $id, $params) === true) {
                return $id;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Edit the details for the selected form
     *
     * @param integer $id
     * @param string $name
     * @return boolean
     */
    private function editForm($id, $name)
    {
        $sql = "UPDATE 
                    `user_site_form`
				SET 
				    `name` = :name
				WHERE 
				    `id` = :form_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':form_id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Save the form
     *
     * @param integer $site_id
     * @param array $params
     * @param integer|null $id Form id when editing
     *
     * @return integer|false Either the form id or false
     */
    public function saveForm($site_id, $params, $id = null)
    {
        if ($id === null) {
            $id = $this->addForm($site_id, $params);
            if ($id !== false) {
                return $id;
            } else {
                return false;
            }
        } else {
            if ($this->editForm($id, $params['name']) === true) {
                if ($this->editLayout($id, $params) === true) {
                    return $id;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    /**
     * Update the layout options for the form
     *
     * @param integer $id
     * @param array $params
     *
     * @return boolean
     */
    private function editLayout($id, array $params)
    {
        $sql = "UPDATE 
                    `user_site_form_layout` 
                SET 
                    `title` = :title, 
                    `sub_title` = :subtitle, 
                    `submit_label` = :submit_label,
                    `reset_label` = :reset_label,
                    `layout_id` = :layout
                WHERE 
                    `form_id` = :form_id 
                LIMIT 
                    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':title', $params['title'], PDO::PARAM_STR);
        $stmt->bindValue(':subtitle', $params['subtitle'], PDO::PARAM_STR);
        $stmt->bindValue(':submit_label', $params['submit_label'], PDO::PARAM_STR);
        $stmt->bindValue(':reset_label', $params['reset_label'], PDO::PARAM_STR);
        $stmt->bindValue(':layout', $params['layout'], PDO::PARAM_STR);
        $stmt->bindValue(':form_id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Set the default layout options for the form
     *
     * @param integer $site_id
     * @param integer $id
     * @param array $params
     *
     * @return boolean
     */
    private function setDefaultLayout($site_id, $id, array $params)
    {
        $sql = "INSERT INTO `user_site_form_layout` 
                (
                    `site_id`, 
                    `form_id`,
                    `title`,
                    `sub_title`,
                    `submit_label`,
                    `reset_label`,
                    `layout_id`,
                    `horizontal_width_label`,
                    `horizontal_width_field`
                )
                VALUES 
                (
                    :site_id, 
                    :form_id,
                    :title, 
                    :subtitle,
                    :submit_label, 
                    :reset_label,
                    :layout_id, 
                    :horizontal_width_label,
                    :horizontal_width_field
                )";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':title', $params['title'], PDO::PARAM_STR);
        $stmt->bindValue(':subtitle', (strlen($params['subtitle']) > 0) ? $params['subtitle'] : null, PDO::PARAM_STR);
        $stmt->bindValue(':submit_label', $params['submit_label'], PDO::PARAM_STR);
        $stmt->bindValue(':reset_label', strlen($params['reset_label'] > 0) ? $params['reset_label'] : null, PDO::PARAM_STR);
        $stmt->bindValue(':layout_id', $params['layout'], PDO::PARAM_INT);
        $stmt->bindValue(':horizontal_width_label', Dlayer_Config::FORM_DEFAULT_HORIZONTAL_WIDTH_LABEL, PDO::PARAM_INT);
        $stmt->bindValue(':horizontal_width_field', Dlayer_Config::FORM_DEFAULT_HORIZONTAL_WIDTH_FIELD, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Check to see if the supplied form name is unique for the site
     *
     * @param string $name Name for form
     * @param integer $site_id Id of the site the form belongs to
     * @param integer|NULL $id Id of form to exclude from query
     * @return boolean
     */
    public function nameUnique($name, $site_id, $id = null)
    {
        $where = null;

        if ($id !== null) {
            $where = 'AND id != :form_id ';
        }

        $sql = 'SELECT 
                    `id`
				FROM 
				    `user_site_form`
				WHERE 
				    UPPER(`name`) = :name AND 
				    `site_id` = :site_id ';
        $sql .= $where;
        $sql .= 'LIMIT 1';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':name', strtoupper($name), PDO::PARAM_STR);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        if ($id != null) {
            $stmt->bindValue(':form_id', $id, PDO::PARAM_INT);
        }
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result === false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check to see if the given id is valid
     *
     * @param integer $site_id
     * @param integer $id
     *
     * @return boolean
     */
    public function valid($site_id, $id) {
        $sql = "SELECT 
                    `id` 
                FROM 
                    `user_site_form`
                WHERE 
                    `site_id` = :site_id AND 
                    `id` = :form_id 
                LIMIT 
                    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->fetch() !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Fetch the requested form
     *
     * @param integer $site_id
     * @param integer $id
     * @return array|false
     */
    public function form($site_id, $id)
    {
        $sql = "SELECT 
                    `user_site_form`.`name`,
                    `user_site_form_layout`.`title`,
                    `user_site_form_layout`.`sub_title` AS `subtitle`,
                    `user_site_form_layout`.`submit_label`,
                    `user_site_form_layout`.`reset_label`,
                    `user_site_form_layout`.`layout_id` AS `layout`
				FROM 
				    `user_site_form` 
                INNER JOIN 
                    `user_site_form_layout` ON 
                        `user_site_form`.`id` = `user_site_form_layout`.`form_id`  
				WHERE 
				    `user_site_form`.`site_id` = :site_id AND 
				    `user_site_form`.`id` = :form_id 
                LIMIT 
                    1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Fetch all the forms that have been defined for the requested site.
     *
     * @param integer $site_id
     * @return array Array of the forms for the site
     */
    public function forms($site_id)
    {
        $sql = "SELECT 
                    `user_site_form`.`id`, 
                    `user_site_form`.`name`,
                    `user_site_form_layout`.`title`, 
                    `designer_form_layout`.`layout`, 
                    (
                      SELECT COUNT(`elements`.`id`)
                      FROM `user_site_form_field` AS `elements`
                      WHERE elements.`site_id` = :site_id AND 
                      `elements`.`form_id` = `user_site_form`.`id`
                    ) AS `elements`
				FROM 
				    `user_site_form` 
                INNER JOIN 
                    `user_site_form_layout` ON 
                        `user_site_form`.`id` = `user_site_form_layout`.`form_id`  
                INNER JOIN 
                    `designer_form_layout` ON 
                        `user_site_form_layout`.`layout_id` = `designer_form_layout`.`id` 
                LEFT JOIN 
                    `user_site_form_field` ON 
                        `user_site_form`.`id` = `user_site_form_field`.`form_id` AND 
                        `user_site_form_field`.`deleted` = 0 
				WHERE 
				    `user_site_form`.`site_id` = :site_id 
				ORDER BY 
				    `user_site_form`.`name` ASC";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
