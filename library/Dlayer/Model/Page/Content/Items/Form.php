<?php
/**
* Content form model, all the database changes for adding or editing a form
* content item
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Form.php 1894 2014-06-03 00:10:11Z Dean.Blackborough $
*/
class Dlayer_Model_Page_Content_Items_Form extends Dlayer_Model_Page_Content_Item
{
    /**
    * Fetch the existing width and padding values for the form container
    *
    * @param integer $content_id
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @return array|FALSE
    */
    public function boxDimensions($content_id, $site_id, $page_id, $div_id)
    {
        $sql = "SELECT uspcf.width, uspcf.padding
                FROM user_site_page_content_form uspcf 
                JOIN user_site_page_content uspc
                    ON uspcf.content_id = uspc.id
                    AND uspc.div_id = :div_id
                WHERE uspcf.content_id = :content_id
                AND uspcf.site_id = :site_id
                AND uspcf.page_id = :page_id
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }
    
    /**
    * Add the form content item details 
    * 
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $content_id
    * @param array $params Form content items details, id, width, padding and 
    *                        the form_id
    * @return void
    */
    public function addContentItemData($site_id, $page_id, $content_id, array $params) 
    {
        $sql = 'INSERT INTO user_site_page_content_form 
                (site_id, page_id, content_id, width, padding, form_id) 
                VALUES 
                (:site_id, :page_id, :content_id, :width, :padding, :form_id)';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
        $stmt->bindValue(':width', $params['width'], PDO::PARAM_INT);
        $stmt->bindValue(':padding', $params['padding'], PDO::PARAM_INT);
        $stmt->bindValue(':form_id', $params['form_id'], PDO::PARAM_INT);
        $stmt->execute();
    }
    
    /**
    * Edit the details for the imported form
    *
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $content_id
    * @param array $params Form content items details, form_id, width and 
    *                        padding
    * @return void
    */
    public function editContentItemData($site_id, $page_id, $content_id,
    array $params)
    {
        $sql = "UPDATE user_site_page_content_form 
                SET form_id = :form_id, width = :width, padding = :padding 
                WHERE site_id = :site_id
                AND page_id = :page_id
                AND content_id = :content_id 
                LIMIT 1";

        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':form_id', $params['form_id'], PDO::PARAM_INT);
        $stmt->bindValue(':width', $params['width'], PDO::PARAM_INT);
        $stmt->bindValue(':padding', $params['padding'], PDO::PARAM_INT);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    /**
    * Fetch the exisiting data for the imported form, id, width and padding, 
    * this will be passed to the tool forms when in edit mode
    *
    * @param integer $content_id
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @return array|FALSE
    */
    public function formParams($content_id, $site_id, $page_id, $div_id)
    {
        $sql = "SELECT uspc.id, uspcf.width, uspcf.padding, uspcf.form_id 
                FROM user_site_page_content_form uspcf 
                JOIN user_site_page_content uspc 
                    ON uspcf.content_id = uspc.id
                    AND uspc.div_id = :div_id 
                WHERE uspcf.content_id = :content_id
                AND uspcf.site_id = :site_id
                AND uspcf.page_id = :page_id
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }
    
    /**
    * Fetch the width for the requested form
    * 
    * @param integer $site_id
    * @param integer $form_id
    * @param boolean $default Return the deafult value if no width value found
    * @return integer|FALSE Minimum width for form
    */
    public function minimumWidth($site_id, $form_id, $default=TRUE) 
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
            return intval($result['width']);
        } else {
            if($default == TRUE) {
                return Dlayer_Config::FORM_MINIMUM_WIDTH;
            } else {
                return FALSE;
            }
        }
    }
    
    /**
    * Fetch the id of the form in the Form builder by the content id
    * 
    * @param integer $site_id
    * @param integer $content_id
    * @return integer|FALSE
    */
    public function formId($site_id, $content_id) 
    {
		$sql = "SELECT form_id 
				FROM user_site_page_content_form 
				WHERE site_id = :site_id 
				AND content_id = :content_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();
        
        $result = $stmt->fetch();
        
        if($result != FALSE) {
            return intval($result['form_id']);
        } else {
            return FALSE;
        }
    }
}