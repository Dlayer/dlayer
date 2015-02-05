<?php
/**
* Content page view model
* 
* The view model is responsible for fetching all the data required to generate 
* a content page. 
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @category View model
*/
class Dlayer_Model_View_Page extends Zend_Db_Table_Abstract 
{
    private $site_id;
    private $page_id;
    
    /**
    * Fetch all the content blocks that have been defined for the given 
    * page, as we loop through the array the details for each of the content 
    * items are fetched from the relevant data tables and then the results 
    * are grouped
    * 
    * @param integer $site_id 
    * @param integer $page_id
    * @return array An array of the content indexed by div_id and content row, 
    * 	each value is an array of the content attached to that div. If there 
    * 	is no content we return an empty array
    */
    public function content($site_id, $page_id) 
    {
        $this->site_id = $site_id;
        $this->page_id = $page_id;
        
        $sql = "SELECT uspcr.div_id, uspcr.id AS content_row_id, 
        		uspc.id AS content_id, dct.`name` AS content_type 
				FROM user_site_page_content_rows uspcr 
				JOIN user_site_page_content uspc ON uspcr.id = uspc.row_id 
				JOIN designer_content_types dct ON uspc.content_type = dct.id 
					AND uspc.site_id = :site_id 
					AND uspc.page_id = :page_id 
				WHERE uspcr.site_id = :site_id 
				AND uspcr.page_id = :page_id 
				ORDER BY uspcr.sort_order, uspc.sort_order";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $this->site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $this->page_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        
        if(count($result) > 0) {
            
            $content = array();
            
            foreach($result as $row) {
                switch($row['content_type']) {
                    case 'text':
                        $data = $this->text($row['id']);
                        if($data != FALSE) {
                            $content[$row['row_id']][] = 
                            array('type'=>'text', 'data'=>$data);
                        }
                    break;
                    
                    case 'heading':
                        $data = $this->heading($row['id']);
                        if($data != FALSE) {
                            $content[$row['div_id']][$row['content_row_id']][] = 
                            array('type'=>$row['content_type'], 'data'=>$data);
                        }
                    break;
                    
                    case 'form':
                    	$data = $this->form($row['id']);
                        if($data != FALSE) {
                            $data['form'] = new Dlayer_Designer_Form(
                            $this->site_id, $data['form_id'], TRUE, NULL);
                            $content[$row['div_id']][] = 
                            array('type'=>'form', 'data'=>$data);
                        }
                    break;
                    
                    default:
                    break;
                }
            }
            
            return $content;
        } else {
            return array();
        }
    }
    
    /**
    * Fetch the text content, text sits in a container, user gets to define the 
    * container size and padding
    * 
    * @param integer $content_id Content id
    * @return array|FALSE Either the content data array or FALSE if nothing can 
    *                     be found for the content id and page id
    */
    private function text($content_id) 
    {
        $model_text = new Dlayer_Model_View_Content_Items_Text();
        return $model_text->data($this->site_id, $this->page_id, $content_id);
    }
    
    /**
    * Fetch the heding content
    * 
    * @param integer $content_id
    * @return array|FALSE Either the content data array or FALSE if nothing can 
    *                     be found for the content id and page id
    */
    private function heading($content_id) 
    {
        $model_heading = new Dlayer_Model_View_Content_Items_Heading();
        return $model_heading->data($this->site_id, $this->page_id, 
        $content_id);
    }
    
    /**
    * Fetch the form content, forms sit in a container, user will have defined 
    * the width and padding for the form container
    * 
    * @param integer $content_id
    * @return array|FALSE Either the content data array of FALSE if notrhing 
    * 					  can be found for the content id
    */
    private function form($content_id) 
    {
    	$model_form = new Dlayer_Model_View_Content_Items_Form();
    	return $model_form->data($this->site_id, $this->page_id, $content_id);
    }
}
