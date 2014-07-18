<?php
/**
* Image library image model, handles everything relating to a single image
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Model_Image_Image extends Zend_Db_Table_Abstract
{
    /**
    * Fetch the detail for the selected image
    * 
    * @param integer $site_id
    * @param integer $image_id 
    * @param integer $version_id 
    * @return array|FALSE Contains all the details required for the details 
    *                     column of the image detail page or FALSE if unable to 
    *                     select image
    */
    public function detail($site_id, $image_id, $version_id) 
    {
        $sql = "SELECT usil.`name`, usilc.`name` AS category, 
                usilsc.`name` AS sub_category, usil.description, 
                usilv.width, usilv.height, usilv.size, 
                DATE_FORMAT(usilv.uploaded, '%e %b %Y') AS uploaded, 
                di.identity AS email 
                FROM user_site_image_library usil 
                JOIN user_site_image_library_links usill 
                    ON usil.id = usill.library_id 
                    AND usill.site_id = :site_id 
                JOIN user_site_image_library_versions usilv 
                    ON usill.version_id = usilv.id 
                    AND usilv.site_id = :site_id 
                JOIN user_site_image_library_categories usilc 
                    ON usil.category_id = usilc.id 
                    AND usilc.site_id = :site_id 
                JOIN user_site_image_library_sub_categories usilsc 
                    ON usil.sub_category_id = usilsc.id 
                    AND usilc.id = usilsc.category_id 
                    AND usilsc.site_id = :site_id 
                JOIN dlayer_identities di 
                    ON usilv.identity_id = di.id 
                WHERE usil.site_id = :site_id 
                AND usil.id = :image_id 
                AND usilv.id = :version_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':image_id', $image_id, PDO::PARAM_INT);
        $stmt->bindValue(':version_id', $version_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
    * Fetch the version info for the requested library images, data array 
    * contains all the versions of an image in chronological order, these 
    * include the shallow versions created each time an image is attached
    * to an item
    * 
    * @param integer $site_id
    * @param integer $image_id
    * @return array|FALSE There should always be at least 1 version, FALSE is 
    *                     returned if for somereason there isn't at least one 
    *                     row in the result set
    *                     The result array is indexed by version_id
    */
    public function versions($site_id, $image_id) 
    {
        $sql = "SELECT usilv.library_id AS image_id, usilv.id AS version_id, 
                usilv.width, usilv.height, 
                DATE_FORMAT(usilv.uploaded, '%e %b %Y') AS uploaded, 
                dmt.`name` AS tool 
                FROM user_site_image_library_versions usilv 
                JOIN dlayer_module_tools dmt 
                    ON usilv.tool_id = dmt.id 
                    AND dmt.module_id = 8 
                WHERE usilv.site_id = :site_id 
                AND usilv.library_id = :library_id 
                ORDER BY usilv.uploaded DESC";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':library_id', $image_id, PDO::PARAM_INT);#
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        
        if(count($result) > 0) {
            $images = array();
            
            $i = 1;
            
            foreach($result as $row) {
                $row['version'] = "Version " . $i;
                $images[$row['version_id']] = $row;
                
                $i++;
            }
            
            return $images;
        } else {
            return FALSE;
        }
    }
}