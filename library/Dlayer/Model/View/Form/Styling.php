<?php

/**
 * Styles view model
 *
 * The styles view model is responsible for fetching all the styles that have
 * been defined for the form fields and form field rows.
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 * @category View model
 */
class Dlayer_Model_View_Form_Styling extends Zend_Db_Table_Abstract
{
    /**
     * Fetch all the row background colors indexed by field id
     *
     * @param integer $site_id
     * @param integer $form_id
     *
     * @return array
     */
    public function rowBackgroundColors($site_id, $form_id)
    {
        $sql = "SELECT 
                    `field_id`, 
                    `background_color`
				FROM 
				    `user_site_form_field_styling_row_background_color`
				WHERE 
				    `site_id` = :site_id AND 
				    `form_id` = :form_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll();

        $background_colors = array();

        foreach ($result as $row) {
            $background_colors[$row['field_id']] = $row['background_color'];
        }

        return $background_colors;
    }
}
