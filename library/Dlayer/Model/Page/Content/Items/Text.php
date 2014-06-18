<?php
/**
* Content text model, all the database changes for adding or editing a text
* content item
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Text.php 1942 2014-06-15 12:52:34Z Dean.Blackborough $
*/
class Dlayer_Model_Page_Content_Items_Text extends Dlayer_Model_Page_Content_Item
{
    /**
    * Add a text content block
    *
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $content_id
    * @param array $text Text data array
    * @return void
    */
    public function addContentItemData($site_id, $page_id, $content_id, 
    array $text)
    {
    	$data_id = $this->contentDataExists($site_id, $text['content']);
		
		if($data_id == FALSE) {
			$data_id = $this->addToDataTable($site_id, $text['name'], 
			$text['content']);
		}
    	
        $sql = "INSERT INTO user_site_page_content_text
                (site_id, page_id, content_id, width, padding, data_id)
                VALUES
                (:site_id, :page_id, :content_id, :width, :padding, :data_id)";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
        $stmt->bindValue(':width', $text['width'], PDO::PARAM_INT);
        $stmt->bindValue(':padding', $text['padding'], PDO::PARAM_INT);
        $stmt->bindValue(':data_id', $data_id, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    /**
    * Check to see if the text content exists in the text data table
    * 
    * @param integer $site_id
    * @param string $content Text content to check for
    * @return integer|FALSE Either the id of the content in the data table 
    * 						or FALSE if a new content item needs to be created
    */
    private function contentDataExists($site_id, $content) 
    {
    	$sql = "SELECT usct.id 
				FROM user_site_content_text usct 
				WHERE usct.site_id = :site_id 
				AND usct.content = :content 
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':content', $content, PDO::PARAM_LOB);
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
		$sql = "INSERT INTO user_site_content_text 
				(site_id, `name`, content) 
				VALUES 
				(:site_id, :name, :content)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':content', $content, PDO::PARAM_LOB);
		$stmt->execute();
		
		return $this->_db->lastInsertId('user_site_content_text');
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
    	$sql = "UPDATE user_site_content_text 
				SET `name` = :name, content = :content 
				WHERE site_id = :site_id 
				AND id = (SELECT uspct.data_id 
				FROM user_site_page_content_text uspct 
				WHERE uspct.content_id = :content_id 
				AND uspct.site_id = :site_id 
				AND uspct.page_id = :page_id 
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
    * Edit the data for the text block
    *
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $content_id
    * @param array $text Text data array
    * @return void
    */
    public function editContentItemData($site_id, $page_id, $content_id, 
    array $text)
    {
    	if($text['instances'] == FALSE) {
			$data_id = $this->contentDataExists($site_id, $text['content']);
			
			if($data_id == FALSE) {
				$data_id = $this->addToDataTable($site_id, $text['name'], 
				$text['content']);
			}
    	} else {
    		$data_id = $this->updateContentData($site_id, $page_id, 
    		$content_id, $text['name'], $text['content']);
		}
    	
        $sql = "UPDATE user_site_page_content_text
                SET width = :width, padding = :padding,
                data_id = :data_id 
                WHERE site_id = :site_id
                AND page_id = :page_id
                AND content_id = :content_id
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':width', $text['width'], PDO::PARAM_INT);
        $stmt->bindValue(':padding', $text['padding'], PDO::PARAM_INT);
        $stmt->bindValue(':data_id', $data_id, PDO::PARAM_INT);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $content_id, PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
    * Fetch the text data for the ribbon edit form
    *
    * @param integer $content_id
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @return array|FALSE
    */
    public function formData($content_id, $site_id, $page_id, $div_id)
    {
        $sql = "SELECT uspc.id, usct.content, usct.`name` 
                FROM user_site_page_content_text uspct
                JOIN user_site_page_content uspc
                    ON uspct.content_id = uspc.id
                    AND uspc.div_id = :div_id 
                JOIN user_site_content_text usct 
                	ON uspct.data_id = usct.id 
                	AND usct.site_id = :site_id 
                WHERE uspct.content_id = :content_id
                AND uspct.site_id = :site_id
                AND uspct.page_id = :page_id
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
    * Fetch the existing width and padding values for the text block container
    *
    * @param integer $content_id
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @return array|FALSE
    */
    public function boxDimensions($content_id, $site_id, $page_id, $div_id)
    {
        $sql = "SELECT uspct.width, uspct.padding
                FROM user_site_page_content_text uspct
                JOIN user_site_page_content uspc
                    ON uspct.content_id = uspc.id
                    AND uspc.div_id = :div_id
                WHERE uspct.content_id = :content_id
                AND uspct.site_id = :site_id
                AND uspct.page_id = :page_id
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
    * the selected text content item
    * 
    * @param integer $site_id
    * @param integer $content_id 
    * @return integer Number of instances for content data
    */
    private function contentDataInstances($site_id, $content_id) 
    {
		$sql = "SELECT COUNT(uspct.id) AS instances 
				FROM user_site_page_content_text uspct 
				WHERE uspct.site_id = :site_id 
				AND uspct.data_id = (SELECT ref_data.data_id 
				FROM user_site_page_content_text ref_data 
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
    * Fetch import data from the text data tabe
    * 
    * @param integer $site_id
    * @param integer $data_id
    * @return array|FALSE
    */
    public function importData($site_id, $data_id) 
    {
		$sql = "SELECT `name`, content 
				FROM user_site_content_text 
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
				FROM user_site_content_text 
				WHERE site_id = :site_id
				ORDER BY `name` ASC";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetchAll();
    }
}