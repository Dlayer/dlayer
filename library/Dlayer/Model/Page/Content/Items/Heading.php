<?php
/**
* Content heading model, all the database changes for adding or editing  a
* heading content item
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Heading.php 1949 2014-06-16 00:34:49Z Dean.Blackborough $
*/
class Dlayer_Model_Page_Content_Items_Heading extends Dlayer_Model_Page_Content_Item
{
    /**
    * Add a heading content block
    *
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $content_id
    * @param array $heading Heading data array
    * @return void
    */
    public function addContentItemData($site_id, $page_id, $content_id,
    array $heading)
    {
    	$data_id = $this->contentDataExists($site_id, $heading['heading']);
		
		if($data_id == FALSE) {
			$data_id = $this->addToDataTable($site_id, $heading['name'], 
			$heading['heading']);
		}
    	
        $sql = "INSERT INTO user_site_page_content_heading
                (site_id, page_id, content_id, heading_id, data_id, width,
                padding_top, padding_bottom, padding_left)
                VALUES
                (:site_id, :page_id, :content_id, :heading_id, :data_id,
                :width, :padding_top, :padding_bottom, :padding_left)";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
        $stmt->bindValue(':heading_id', $heading['heading_type'],
        PDO::PARAM_INT);
        $stmt->bindValue(':data_id', $data_id, PDO::PARAM_INT);
        $stmt->bindValue(':width', $heading['width'], PDO::PARAM_INT);
        $stmt->bindValue(':padding_top', $heading['padding_top'], 
        PDO::PARAM_INT);
        $stmt->bindValue(':padding_bottom', $heading['padding_bottom'],
        PDO::PARAM_INT);
        $stmt->bindValue(':padding_left', $heading['padding_left'],
        PDO::PARAM_INT);
        $stmt->execute();
    }
    
    /**
    * Check to see if the text content exists in the heading data table
    * 
    * @param integer $site_id
    * @param string $content Text content to check for, will be trimmed before 
    * 						 being bound to statement
    * @return integer|FALSE Either the id of the content in the data table 
    * 						or FALSE if a new content item needs to be created
    */
    private function contentDataExists($site_id, $content) 
    {
    	$sql = "SELECT usch.id 
				FROM user_site_content_heading usch 
				WHERE usch.site_id = :site_id 
				AND usch.content = :content 
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':content', trim($content), PDO::PARAM_STR);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			return intval($result['id']);
		} else {
			return FALSE;
		}
    }
    
    /** 
    * Add content to content data table
    * 
    * @param integer $site_id
    * @param string $name Name for the content data
    * @param string $content
    * @return integer Id of the text in the content data table
    */
    private function addToDataTable($site_id, $name, $content) 
    {
		$sql = "INSERT INTO user_site_content_heading 
				(site_id, `name`, content) 
				VALUES 
				(:site_id, :name, :content)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':content', $content, PDO::PARAM_STR);
		$stmt->execute();
		
		return $this->_db->lastInsertId('user_site_content_heading');
    }
    
    /**
    * Fetch the content data id used by an existing content item
    * 
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $content_id
    * @return integer Id for the updated content
    */
    private function updateContentData($site_id, $page_id, $content_id, 
    $name, $content) 
    {
    	$sql = "UPDATE user_site_content_heading 
				SET `name` = :name, content = :content 
				WHERE site_id = :site_id 
				AND id = (SELECT uspch.data_id 
				FROM user_site_page_content_heading uspch 
				WHERE uspch.content_id = :content_id 
				AND uspch.site_id = :site_id 
				AND uspch.page_id = :page_id 
				LIMIT 1)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':content', $content, PDO::PARAM_LOB);
		$stmt->execute();
    	
    	return $this->contentDataExists($site_id, $content);
    }

    /**
    * Edit the data for the heading
    *
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $content_id
    * @param array $heading Heading data array
    * @return void
    */
    public function editContentItemData($site_id, $page_id, $content_id,
    array $heading)
    {
    	if($heading['instances'] == FALSE) {
			$data_id = $this->contentDataExists($site_id, 
			$heading['heading']);
			
			if($data_id == FALSE) {
				$data_id = $this->addToDataTable($site_id, $heading['name'], 
				$heading['heading']);
			}
    	} else {
    		$data_id = $this->updateContentData($site_id, $page_id, 
    		$content_id, $heading['name'], $heading['heading']);
		}
    	
        $sql = "UPDATE user_site_page_content_heading
                SET heading_id = :heading_id, data_id = :data_id,
                width = :width, padding_top = :padding_top,
                padding_bottom = :padding_bottom, padding_left = :padding_left
                WHERE site_id = :site_id
                AND page_id = :page_id
                AND content_id = :content_id
                LIMIT 1";

        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':heading_id', $heading['heading_type'],
        PDO::PARAM_INT);
        $stmt->bindValue(':data_id', $data_id, PDO::PARAM_INT);
        $stmt->bindValue(':width', $heading['width'], PDO::PARAM_INT);
        $stmt->bindValue(':padding_top', $heading['padding_top'], 
        PDO::PARAM_INT);
        $stmt->bindValue(':padding_bottom', $heading['padding_bottom'],
        PDO::PARAM_INT);
        $stmt->bindValue(':padding_left', $heading['padding_left'],
        PDO::PARAM_INT);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
    * Fetch the heading data for the ribbon edit form
    *
    * @param integer $content_id
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @return array|FALSE
    */
    public function formData($content_id, $site_id, $page_id, $div_id)
    {
        $sql = "SELECT uspc.id, usch.content AS heading, usch.`name`, 
        		uspch.padding_top, uspch.padding_bottom, uspch.heading_id, 
        		uspch.padding_left, uspch.width 
                FROM user_site_page_content_heading uspch 
                JOIN user_site_content_heading usch 
                	ON uspch.data_id = usch.id 
                	AND usch.site_id = :site_id 
                JOIN user_site_page_content uspc
                    ON uspch.content_id = uspc.id
                    AND uspc.div_id = :div_id
                WHERE uspch.content_id = :content_id
                AND uspch.site_id = :site_id
                AND uspch.page_id = :page_id
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();
        
        if($result != FALSE) {
			$result['instances'] = $this->contentDataInstances($site_id, 
			$content_id);
			return $result;
        } else {
			return FALSE;
        }
    }
    
    /**
    * Fetch the existing width and margin values for the heading block
    *
    * @param integer $content_id
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @return array|FALSE
    */
    public function boxDimensions($content_id, $site_id, $page_id, $div_id)
    {
        $sql = "SELECT uspch.width, uspch.padding_left 
                FROM user_site_page_content_heading uspch
                JOIN user_site_page_content uspc
                    ON uspch.content_id = uspc.id
                    AND uspc.div_id = :div_id
                WHERE uspch.content_id = :content_id
                AND uspch.site_id = :site_id
                AND uspch.page_id = :page_id
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
    * Fetch the number of instances for the content data being used by 
    * the selected heading content item
    * 
    * @param integer $site_id
    * @param integer $content_id 
    * @return integer Number of instances for content data
    */
    private function contentDataInstances($site_id, $content_id) 
    {
		$sql = "SELECT COUNT(uspch.id) AS instances 
				FROM user_site_page_content_heading uspch 
				WHERE uspch.site_id = :site_id 
				AND uspch.data_id = (SELECT ref_data.data_id 
				FROM user_site_page_content_heading ref_data 
				WHERE ref_data.content_id = :content_id 
				AND ref_data.site_id = :site_id)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			return intval($result['instances']);
		} else {
			return 0;
		}
    }
    
    /**
    * Fetch import data from the heading data tabe
    * 
    * @param integer $site_id
    * @param integer $data_id
    * @return array|FALSE
    */
    public function importData($site_id, $data_id) 
    {
		$sql = "SELECT `name`, content 
				FROM user_site_content_heading 
				WHERE site_id = :site_id 
				AND id = :data_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':data_id', $data_id, PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetch();
    }
    
    /**
    * Fetch options form the import data select
    * 
    * @param integer $site_id
    * @return array
    */
    public function importDataOptions($site_id)
    {
		$sql = "SELECT id, `name` 
				FROM user_site_content_heading 
				WHERE site_id = :site_id
				ORDER BY `name` ASC";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetchAll();
    }
}