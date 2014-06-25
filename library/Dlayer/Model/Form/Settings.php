<?php
/**
* Form settings model
* 
* manages all the settings for the form
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @category Model
*/
class Dlayer_Model_Form_Settings extends Zend_Db_Table_Abstract
{
    /**
    * Set the width for the selected form
    * 
    * @param integer $site_id
    * @param integer $form_id
    * @param integer $width
    * @return void
    */
    public function setWidth($site_id, $form_id, $width) 
    {
        if($this->existingWidth($site_id, $form_id) != $width) {
            $sql = "UPDATE user_site_form_settings 
                    SET width = :width 
                    WHERE site_id = :site_id 
                    AND form_id = :form_id";
            $stmt = $this->_db->prepare($sql);
            $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
            $stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
            $stmt->bindValue(':width', $width, PDO::PARAM_INT);
            $stmt->execute();
        }
    }
    
    /**
    * Set the legend for the selected form
    * 
    * @param integer $site_id
    * @param integer $form_id
    * @param string $legend
    * @return void
    */
    public function setLegend($site_id, $form_id, $legend) 
    {
        if($this->existingLegend($site_id, $form_id) != $legend) {
            $sql = "UPDATE user_site_form_settings 
                    SET legend = :legend 
                    WHERE site_id = :site_id 
                    AND form_id = :form_id";
            $stmt = $this->_db->prepare($sql);
            $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
            $stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
            $stmt->bindValue(':legend', $legend, PDO::PARAM_STR);
            $stmt->execute();
        }
    }
    
    /**
    * Fetch the existing width for the form, we only update the value if 
    * the new width is different to the existing width
    * 
    * @param integer $site_id
    * @param integer $form_id
    * @return integer $width
    */
    private function existingWidth($site_id, $form_id) 
    {
        $sql = "SELECT width 
                FROM user_site_form_settings 
                WHERE site_id = :site_id 
                AND form_id = :form_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch();
        
        if($result != FALSE) {
            return $result['width'];
        } else {
            return Dlayer_Config::FORM_MINIMUM_WIDTH;
        }
    }
    
    /**
    * Fetch the existing legend for the form, we only update the value if 
    * the new legend is different to the existing legend
    * 
    * @param integer $site_id
    * @param integer $form_id
    * @return string $legend
    */
    private function existingLegend($site_id, $form_id) 
    {
        $sql = "SELECT legend 
                FROM user_site_form_settings 
                WHERE site_id = :site_id 
                AND form_id = :form_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch();
        
        if($result != FALSE) {
            return $result['legend'];
        } else {
            return Dlayer_Config::FORM_LEGEND;
        }
    }
    
    /**
    * Fetch all the setting for a form
    * 
    * @param integer $site_id
    * @param integer $form_id
    * @return array|FALSE
    */
    public function settings($site_id, $form_id) 
    {
        $sql = "SELECT usfs.width, usfs.legend 
                FROM user_site_form_settings usfs 
                WHERE usfs.site_id = :site_id 
                AND usfs.form_id = :form_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
    * Fetch all the settings required by the form builder
    * 
    * @param integer $form_id
    * @return array|FALSE
    */
    public function formBuilderSettings($form_id) 
    {
        $sql = "SELECT usfs.legend 
                FROM user_site_form_settings usfs 
                WHERE usfs.form_id = :form_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }
}