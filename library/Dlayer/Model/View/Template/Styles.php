<?php
/**
* Styles view model
* 
* The styles model is responsible for fetching all the styles data for an 
* entire template. 
* 
* The styles are fetched individually and then grouped later in the template 
* designer class
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Styles.php 1042 2013-10-02 01:34:02Z Dean.Blackborough $
* @category View model
*/
class Dlayer_Model_View_Template_Styles extends Zend_Db_Table_Abstract
{
    /**
    * Fetch all the defined background colors for the divs in the given 
    * template, returns an array indexed by div id. If a div is currently 
    * selected in the designer we don't includes its background color in the 
    * returned array because we don't want to override the selected background 
    * color
    *
    * @param integer $site_id
    * @param integer $template_id
    * @param integer|NULL $selected_div
    * @return array|FALSE An array of the background colors indexed by div id,
    *                     if no colors have been assigned we return FALSE
    */
    public function backgroundColors($site_id, $template_id,
    $selected_div=NULL)
    {
        $sql = "SELECT ustdbc.div_id, ustdbc.color_hex
                FROM user_site_template_div_background_colors ustdbc
                WHERE ustdbc.site_id = :site_id
                AND ustdbc.template_id = :template_id";
        if($selected_div != NULL) {
                $sql .= " AND ustdbc.div_id != :div_id";
        }
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
        if($selected_div != NULL) {
            $stmt->bindValue(':div_id', $selected_div, PDO::PARAM_INT);
        }
        $stmt->execute();

        $result = $stmt->fetchAll();

        if(count($result) > 0) {
            $rows = array();

            foreach($result as $row) {
                $rows[$row['div_id']] = $row['color_hex'];
            }

            return $rows;
        } else {
            return FALSE;
        }
    }

    /**
    * Fetches all the defined borders for the div template, returns an array
    * grouped by div id with an array as the value, the array will contain all
    * the defined borders for the div, upto 4
    *
    * @param integer $site_id
    * @param integer $template_id
    * @return array|FALSE An array of the borders or FALSE if no borers have
    *                     been defined for the template
    */
    public function borders($site_id, $template_id)
    {
        $sql = "SELECT ustdb.div_id, ustdb.position, ustdb.style,
                ustdb.width, ustdb.color_hex
                FROM user_site_template_div_borders ustdb
                WHERE ustdb.site_id = :site_id
                AND ustdb.template_id = :template_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll();

        if(count($result) > 0) {
            $rows = array();

            foreach($result as $row) {
                $rows[$row['div_id']][] = array('position'=>$row['position'],
                                                'style'=>$row['style'],
                                                'width'=>$row['width'],
                                                'color_hex'=>$row['color_hex']);
            }

            return $rows;
        } else {
            return FALSE;
        }
    }
}