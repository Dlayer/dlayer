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
        $sql = "SELECT usilc.`name` AS category, usilsc.`name` AS sub_category, 
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
                    AND usilsc.site_id = 1 
                JOIN dlayer_identities di 
                    ON usilv.identity_id = di.id 
                WHERE usil.site_id = 1 
                AND usil.id = 1;";
    }
}