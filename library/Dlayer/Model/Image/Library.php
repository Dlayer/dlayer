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
    * @return array
    */
    public function images($site_id, $category_id, $sub_category_id, 
    $sort='name', $order='asc')
    {
        $sql = "SELECT usil.`name`, usil.id AS image_id, 
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
                AND usil.category_id = :category_id 
                AND usil.sub_category_id = :sub_category_id 
                ORDER BY usil.`" . $sort . "` " . $order;
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindValue(':sub_category_id', $sub_category_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        
        $images = array();
        
        foreach($result as $row) {
            $row['size'] = $this->readableFilesize($row['size']);
            $images[] = $row;
        }
        
        return $images;
    }
    
    /**
    * Convert filesize into readable format
    * 
    * @param integer $bytes 
    * @return string More human readable version of filesize
    */
    public function readableFilesize($bytes=0) 
    {
        if($bytes < 1024) {
            return $bytes . ' bytes';
        } else if($bytes < 1024*1024) {
            return number_format($bytes/(1024), 1) . ' kb';
        } else {
            return number_format($bytes/(1024*1024), 2) . ' mb';
        }
    }
}