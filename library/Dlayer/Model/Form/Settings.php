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
    * Check the existing width for the form, we only update the value if 
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
    * Fetch all the setting for a form
    * 
    * @param integer $site_id
    * @param integer $form_id
    * @return array|FALSE
    */
    public function settings($site_id, $form_id) 
    {
        $sql = "SELECT usfs.width 
                FROM user_site_form_settings usfs 
                WHERE usfs.site_id = :site_id 
                AND usfs.form_id = :form_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }
}