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
                usilv.size, usilv.uploaded 
                FROM user_site_image_library usil 
                JOIN user_site_image_library_links usill 
                    ON usil.id = usill.library_id 
                    AND usill.site_id = 1 
                JOIN user_site_image_library_versions usilv 
                    ON usill.version_id = usilv.id 
                    AND usilv.site_id = 1 
                WHERE usil.site_id = 1 
                AND usil.category_id = 1 
                AND usil.sub_category_id = 4 
                ORDER BY usil.`name` ASC";
    }
}