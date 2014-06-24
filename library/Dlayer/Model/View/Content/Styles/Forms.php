<?php
/**
* View model for the form content items
* 
* Fetches all the styles assigned to form content items, the field rows, 
* forms theselves and the inputs and labels.
* 
* The model has a single public method which returns all the styles for the 
* forms assigned to the content page, the styles however are fetched by 
* group
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Forms.php 1894 2014-06-03 00:10:11Z Dean.Blackborough $
* @category View model
*/
class Dlayer_Model_View_Content_Styles_Forms extends Zend_Db_Table_Abstract
{
    private $styles = array();
    
    /**
    * Return the styles data for all the imported form content items. The 
    * returned array is indexed by form_id. The value will be an array indexed 
    * by field id with entries for each of the assigned styles
    * 
    * @param integer $site_id
    * @param integer $page_id
    * @return array
    */
    public function fieldStyles($site_id, $page_id) 
    {
        $form_ids = $this->assignedForms($site_id, $page_id);
        
        if($form_ids != FALSE) {
            $this->rowBackgroundColors($site_id, $form_ids);
        }
        
        return $this->styles;
    }
    
    /**
    * Fetch the ids of all the forms that have been assigned to the current 
    * page in the Content manager
    * 
    * @param integer $site_id
    * @param integer $page_id
    * @return array|FALSE Array of assigned forms or FALSE
    */
    private function assignedForms($site_id, $page_id) 
    {
        $sql = "SELECT uspcf.form_id  
                FROM user_site_page_content uspc 
                JOIN designer_content_types dct ON uspc.content_type = dct.id 
                    AND dct.`name` = 'form' 
                JOIN user_site_page_content_form uspcf 
                    ON uspc.id = uspcf.content_id 
                    AND uspcf.site_id = :site_id 
                    AND uspcf.page_id = :page_id 
                WHERE uspc.site_id = :site_id 
                AND uspc.page_id = :page_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        
        if(count($result) > 0) {
            $forms = array();
            
            foreach($result as $row) {
                $forms[] = intval($row['form_id']);
            }
            
            return $forms;
        } else {
            return FALSE;
        }
        
    }
    
    /**
    * Fetch all the defined background colors for the imported forms, writes 
    * all the defined styles to the $this->styles array
    * 
    * @param integer $site_id
    * @param array $form_ids
    * @return void Data written to $this->styles
    */
    private function rowBackgroundColors($site_id, array $form_ids) 
    {
        $sql = "SELECT uspcf.content_id, usffrbc.field_id, usffrbc.color_hex 
                FROM user_site_form_field_row_background_colors usffrbc 
                JOIN user_site_page_content_form uspcf 
                    ON usffrbc.form_id = uspcf.form_id 
                    AND uspcf.site_id = :site_id
                WHERE usffrbc.site_id = :site_id 
                AND usffrbc.form_id IN (" . implode(', ', $form_ids) . ")";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        
        if(count($result) > 0) {
            
            $styles = array();
            
            foreach($result as $row) {
                $styles[$row['content_id']][$row['field_id']] = 
                'background-color: ' . $row['color_hex'];
            }
            
            $this->assignValues($styles);
        }
    }
    
    /**
    * Add the styles to the base style array
    * 
    * @param array $styles
    * @return void
    */
    private function assignValues(array $styles) 
    {
        foreach($styles as $form_id => $field_style) {
            foreach($field_style as $field_id => $style) {
                $this->styles[$form_id][$field_id][] = $style;
            }
        }
    }
}