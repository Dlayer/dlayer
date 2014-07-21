<?php
/**
* Image library library model
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Model_Image_Library extends Zend_Db_Table_Abstract
{
    /**
    * Fetch the images for the requested category and sub category ordered 
    * accordingly
    * 
    * The sort and order params should be supplied via the image library 
    * session class, that way the values will have been validated and we can 
    * user them directly
    * 
    * @param integer $site_id
    * @param integer $category_id
    * @param integer $sub_category_id
    * @param string $sort
    * @param string $order
    * @param integer $per_page
    * @param integer $start
    * @return array
    */
    public function images($site_id, $category_id, $sub_category_id, 
    $sort='name', $order='asc', $per_page, $start=0)
    {
        switch($sort) {
            case 'size':
                $sort_field = 'usilv.`size`';
            break;
            
            case 'uploaded':
                $sort_field = 'usilv.`uploaded`';
            break;
            
            default:
                $sort_field = 'usil.`name`';
            break;
        }
        
        $sql = "SELECT SQL_CALC_FOUND_ROWS usil.`name`, usil.id AS image_id, 
                usilv.id AS version_id, usilv.extension, 
                usilv.size, 
                DATE_FORMAT(usilv.uploaded, '%e %b %Y') AS uploaded 
                FROM user_site_image_library usil 
                JOIN user_site_image_library_links usill 
                    ON usil.id = usill.library_id 
                    AND usill.site_id = :site_id 
                JOIN user_site_image_library_versions usilv 
                    ON usill.version_id = usilv.id 
                    AND usilv.site_id = :site_id 
                WHERE usil.site_id = :site_id 
                AND usil.category_id = :category_id ";
        if($sub_category_id != 0) {
            $sql .= "AND usil.sub_category_id = :sub_category_id ";
        }    
        $sql .= "ORDER BY " . $sort_field . " " . $order;
        if($start == 0) {
            $sql .= " LIMIT :limit";
        } else {
            $sql .= " LIMIT :start, :limit";
        }
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        if($sub_category_id != 0) {
            $stmt->bindValue(':sub_category_id', $sub_category_id, 
            PDO::PARAM_INT);
        }
        $stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
        if($start > 0) {
            $stmt->bindValue(':start', $start, PDO::PARAM_INT);
        }
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        
        $stmt = $this->_db->prepare("SELECT FOUND_ROWS()");
        $stmt->execute();
        
        $count = $stmt->fetch();
        
        $images = array();
        
        foreach($result as $row) {
            $row['size'] = Dlayer_Helper::readableFilesize($row['size']);
            $images[] = $row;
        }
        
        return array('results'=>$images, 'count'=>$count['FOUND_ROWS()']);
    }
}