<?php
/**
* Styles view model
* 
* The styles view model is repsonsible for fetching all the styles that have 
* been added to the styling tab of each tool, these are all additional styles, 
* not the base styles required for the content item.
* 
* This styles model is responsible for fetching all the styles data for an 
* entire page, the styles aklthough fetched individually are later grouped 
* in the designer page clas
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Styles.php 1774 2014-04-30 16:17:34Z Dean.Blackborough $
* @category View model
*/
class Dlayer_Model_View_Content_Styles extends Zend_Db_Table_Abstract
{
    /**
    * Fetch all the defined background colors for the content item containers 
    * for a specific page, returns an array indexed by content id. 
    * 
    * If a content item is currently selected in the Content manager we don't 
    * include its background color in the returned array because we don't want 
    * to override the selected status background color
    *
    * @param integer $site_id
    * @param integer $page_id
    * @param integer|NULL $content_id Id of the currently selected content 
    * 								  item
    * @return array|FALSE An array of the background colors indexed by div
    * 					  content id, if not colors have been assigned returns 
    * 					  FALSE
    */
    public function backgroundColors($site_id, $page_id, $content_id=NULL)
    {
        $sql = "SELECT uspccbc.content_id, uspccbc.color_hex 
        		FROM user_site_page_content_container_background_colors uspccbc 
        		WHERE uspccbc.site_id = :site_id 
        		AND uspccbc.page_id = :page_id";
        if($content_id != NULL) {
                $sql .= " AND uspccbc.content_id != :content_id";
        }
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        if($content_id != NULL) {
            $stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
        }
        $stmt->execute();

        $result = $stmt->fetchAll();

        if(count($result) > 0) {
            $rows = array();

            foreach($result as $row) {
                $rows[$row['content_id']] = $row['color_hex'];
            }

            return $rows;
        } else {
            return FALSE;
        }
    }
    
    /**
    * Fetch all the defined margin values for the content item containers for 
    * a specific page, returns and array indexed by content id
    * 
    * @param integer $site_id
    * @param integer $page_id
    * @return array|FALSE An array of the margin values indexes by content id, 
    * 					  the value will be an array with indexes for each set 
    * 					  margin
    */
    public function margins($site_id, $page_id) 
    {
		$sql = "SELECT uspccm.content_id, uspccm.`top`, uspccm.`right`, 
				uspccm.`bottom`, uspccm.`left` 
				FROM user_site_page_content_container_margins uspccm 
				WHERE uspccm.site_id = :site_id 
				AND uspccm.page_id = :page_id";
				
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetchAll();
		
		if(count($result) > 0) {
			$rows = array();
			
			foreach($result as $row) {
				$rows[$row['content_id']] = $row;
			}
			
			return $rows;
		} else {
			return FALSE;
		}
    }
}