<?php
/**
* Form content item view model
* 
* Responsible for fetching the data required to generate the form 
* from the database.
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Form.php 1813 2014-05-09 15:32:06Z Dean.Blackborough $
* @category View model
*/
class Dlayer_Model_View_Content_Items_Form extends Zend_Db_Table_Abstract 
{
    /**
    * Fetch the data for the form content item, this includes the 
    * container width, padding, form id as well as additional values 
    * required by the designer content object and view helper
    *
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $content_id Content id
    * @return array|FALSE Either the content data array including the content 
    * 					  id or FALSE is nothing can be found
    */
    private function item($site_id, $page_id, $content_id) 
    {
        $sql = "SELECT uspcf.content_id, uspcf.padding, uspcf.width, 
        		uspcf.form_id, uspc.sort_order, uspc.div_id, uspc.page_id 
                FROM user_site_page_content_form uspcf 
                JOIN user_site_page_content uspc 
                    ON uspcf.content_id = uspc.id 
                    AND uspc.site_id = :site_id 
                    AND uspc.page_id = :page_id 
                JOIN user_site_pages usp 
                    ON uspcf.page_id = usp.id 
                    AND usp.site_id = :site_id 
                WHERE uspcf.content_id = :content_id 
                AND uspcf.site_id = :site_id 
                AND uspcf.page_id = :page_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
    * Fetch the combined left and right margin values for the content item, 
    * margin values can be defined using the position tab of the text tool. 
    * 
    * Value is required to allow the view helpers to set the correct size for 
    * the container and controls for the content item
    * 
    * @todo this method is duplicated, remedy that
    * 
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $content_id
    * @return integer Combined extra margin width
    */
    private function containerCombinedMargin($site_id, $page_id, $content_id) 
    {
		$sql = "SELECT uspccm.`left`, uspccm.`right` 
				FROM user_site_page_content_container_margins uspccm 
				JOIN designer_content_types dct ON uspccm.content_type = dct.id 
				WHERE uspccm.site_id = :site_id
				AND uspccm.page_id = :page_id  
				AND uspccm.content_id = :content_id 
				AND dct.`name` = :content_type";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_type', 'form', PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			return intval($result['left']) + intval($result['right']);
		} else {
			return 0;
		}
    }
    
    /**
    * Fetch all the form content data and any additional values required by 
    * the content item view helpers
    * 
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $content_id Content id
    * @return array|FALSE Either the full content data array including the 
    * 					  content id or FALSE if the data can't be pulled
    */
    public function data($site_id, $page_id, $content_id) 
    {
    	$item = $this->item($site_id, $page_id, $content_id);   	
    	
    	if($item != FALSE) {    		
    		$item['container_margin'] = $this->containerCombinedMargin(
    		$site_id, $page_id, $content_id);
    	}
    	
    	return $item;
    }
}