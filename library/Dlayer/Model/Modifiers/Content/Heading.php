<?php
/**
* Content module heading modifier model, contains all the methods used by 
* modifiers that act upon a heading content item container
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Model_Modifiers_Content_Heading extends Zend_Db_Table_Abstract
{
    /**
    * Fetch the dimensions for the content item container, method should only 
    * ever be called by the modifier objects
    *
    * @param integer $content_id
    * @param integer $site_id
    * @return array Three indexes, full_width, width and margin
    */
    public function itemDimensions($content_id, $site_id)
    {
        $sql = "SELECT width, padding_left 
                FROM user_site_page_content_heading 
                WHERE site_id = :site_id
                AND content_id = :content_id
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();

        return array('full_width'=>intval($result['width']) +
        intval($result['padding_left']), 'width'=>intval($result['width']),
        'padding'=>intval($result['padding_left']), 'margins'=>$this->margins(
        $content_id, $site_id));
    }
    
    /**
    * Fetch the margin values for the selected content item, also includes 
    * combined margin width
    * 
    * @param integer $content_id
    * @param integer $site_id
    * @return array Three indexes, left, right and margin
    */
    private function margins($content_id, $site_id, $content_type='heading') 
    {
		$sql = "SELECT uspccm.`left`, uspccm.`right` 
				FROM user_site_page_content_container_margins uspccm 
				JOIN designer_content_types dct ON uspccm.content_type = dct.id 
				WHERE uspccm.site_id = :site_id 
				AND uspccm.content_id = :content_id 
				AND dct.`name` = :content_type";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_type', $content_type, PDO::PARAM_STR);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		$margins = array('left'=>0, 'right'=>0, 'full'=>0);
		
		if($result != FALSE) {
			$margins['left'] = intval($result['left']);
			$margins['right'] = intval($result['right']);
			$margins['full'] = intval($result['left']) + 
			intval($result['right']);
		}
		
		return $margins;
    }
    
    /**
    * Set the new width for the heading content item container, method should 
    * only ever be called by the modifier objects
    *
    * @param integer $content_id
    * @param integer $width
    * @param integer $site_id
    * @return void
    */
    public function setWidth($content_id, $width, $site_id)
    {
        $sql = "UPDATE user_site_page_content_heading 
                SET width = :width
                WHERE site_id = :site_id
                AND content_id = :content_id
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':width', $width, PDO::PARAM_INT);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
        $stmt->execute();
    }
}