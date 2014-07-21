<?php
/**
* Image library categories model, handles everything relating to the categories 
* and sub categories
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Model_Image_Categories extends Zend_Db_Table_Abstract
{
    /**
    * Fetch the name and id for the selected category, if for some reason 
    * the supplied params don't match a real category the default category is 
    * returned and/or created
    * 
    * @param integer $site_id
    * @param integer $category_id
    * @return array Always returns an array, if the supplied params are 
    *               invalid the default is return and/or created
    */
    public function category($site_id, $category_id) 
    {
        $sql = "SELECT id, `name` 
                FROM user_site_image_library_categories 
                WHERE site_id = :site_id 
                AND id = :category_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch();
        
        if($result != FALSE) {
            return $result;
        } else {
            $default_category_id = $this->defaultCategoryId($site_id);
            
            if($default_category_id == FALSE) {
                $default_category_id = $this->addCategory($site_id, 
                Dlayer_Config::IMAGE_LIBRARY_DEFAULT_CATEGORY);
            }
            
            return array('id'=>$default_category_id, 
            'name'=>Dlayer_Config::IMAGE_LIBRARY_DEFAULT_CATEGORY);
        }
    }
    
    /**
    * Fetch the name and id for the selected sub category, if for some reason 
    * the supplied params don't match a real sub category the default sub 
    * category is returned and/or created
    * 
    * @param integer $site_id
    * @param integer $category_id
    * @param integer $sub_category_id
    * @return array Always returns an array, if the supplied params are 
    *               invalid the default is return and/or created
    */
    public function subCategory($site_id, $category_id, $sub_category_id) 
    {
        $sql = "SELECT id, category_id, `name` 
                FROM user_site_image_library_sub_categories 
                WHERE site_id = :site_id 
                AND category_id = :category_id 
                AND id = :sub_category_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindValue(':sub_category_id', $sub_category_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch();
        
        if($result != FALSE) {
            return $result;
        } else {
            $default_sub_category_id = $this->defaultSubCategoryId($site_id);
            
            if($default_sub_category_id == FALSE) {
                 $default_category_id = $this->defaultCategoryId($site_id);
            
                if($default_category_id == FALSE) {
                    $default_category_id = $this->addCategory($site_id, 
                    Dlayer_Config::IMAGE_LIBRARY_DEFAULT_CATEGORY);
                }
                
                $default_sub_category_id = $this->defaultSubCategoryId(
                $site_id);
                
                if($default_sub_category_id == FALSE) {
                    $default_sub_category_id = $this->addSubCategory($site_id, 
                    $default_category_id, 
                    Dlayer_Config::IMAGE_LIBRARY_DEFAULT_SUB_CATEGORY);
                }
            }
            
             return array('id'=>$default_sub_category_id, 
             'category_id'=>$category_id,
             'name'=>Dlayer_Config::IMAGE_LIBRARY_DEFAULT_SUB_CATEGORY);
        }
    }
    
    /**
    * Fetch the id for the default category
    * 
    * @param integer $site_id
    * @return integer|FALSE Id of the default category
    */
    private function defaultCategoryId($site_id) 
    {
        $sql = "SELECT id 
                FROM user_site_image_library_categories 
                WHERE site_id = :site_id 
                AND `name` = :category";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':category', 
        Dlayer_Config::IMAGE_LIBRARY_DEFAULT_CATEGORY, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch();
        
        if($result != FALSE) {
            return intval($result['id']);
        } else {
            return FALSE;
        }
    }
    
    /**
    * Fetch the id for the default sub category, uses the default catergory 
    * in query
    * 
    * @param integer $site_id
    * @return integer|FALSE Id of the default category
    */
    private function defaultSubCategoryId($site_id) 
    {
        $sql = "SELECT id 
                FROM user_site_image_library_sub_categories 
                WHERE site_id = :site_id 
                AND category_id = (SELECT id 
                    FROM user_site_image_library_categories 
                    WHERE site_id = :site_id 
                    AND `name` = :category)
                AND `name` = :sub_category";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':category', 
        Dlayer_Config::IMAGE_LIBRARY_DEFAULT_CATEGORY, PDO::PARAM_STR);
        $stmt->bindValue(':sub_category', 
        Dlayer_Config::IMAGE_LIBRARY_DEFAULT_SUB_CATEGORY, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch();
        
        if($result != FALSE) {
            return intval($result['id']);
        } else {
            return FALSE;
        }
    }
    
    /**
    * Create the requested image library category
    * 
    * @param integer $site_id
    * @param string $category Name of category
    * @return integer Id of the newly created category
    */
    public function addCategory($site_id, $category) 
    {
        $sql = "INSERT INTO user_site_image_library_categories 
                (site_id, `name`) 
                VALUES 
                (:site_id, :category)";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':category', $category, PDO::PARAM_STR);
        $stmt->execute();
        
        return $this->_db->lastInsertId('user_site_image_library_categories');
    }
    
    /**
    * Edit the details for the selected image library category
    * 
    * @param integer $site_id
    * @param integer $category_id 
    * @param integer $category New category name
    * @return void
    */
    public function editCategory($site_id, $category_id, $category) 
    {
        $sql = "UPDATE user_site_image_library_categories 
                SET `name` = :category 
                WHERE id = :category_id 
                AND site_id = :site_id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':category', $category, PDO::PARAM_STR);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    /**
    * Edit the details for the selected image library sub category
    * 
    * @param integer $site_id
    * @param integer $sub_category_id 
    * @param integer $sub_category New sub category name
    * @return void
    */
    public function editSubCategory($site_id, $sub_category_id, $sub_category) 
    {
        $sql = "UPDATE user_site_image_library_sub_categories 
                SET `name` = :sub_category 
                WHERE id = :sub_category_id 
                AND site_id = :site_id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':sub_category', $sub_category, PDO::PARAM_STR);
        $stmt->bindValue(':sub_category_id', $sub_category_id, PDO::PARAM_INT);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    /**
    * Create the requested image library sub category
    * 
    * @param integer $site_id
    * @param integer $category_id
    * @param string $sub_category Name of sub category
    * @return integer Id of the newly created sub category
    */
    public function addSubCategory($site_id, $category_id, $sub_category) 
    {
        $sql = "INSERT INTO user_site_image_library_sub_categories 
                (site_id, category_id, `name`) 
                VALUES 
                (:site_id, :category_id, :sub_category)";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindValue(':sub_category', $sub_category, PDO::PARAM_STR);
        $stmt->execute();
        
        return $this->_db->lastInsertId(
        'user_site_image_library_sub_categories');
    }
    
    /**
    * Fetch the image library categories for the selected site
    * 
    * @param integer $site_id
    * @return array Array containing all the image library categories for the 
    *               selected site
    */
    public function categories($site_id) 
    {
        $sql = "SELECT id, `name` 
                FROM user_site_image_library_categories 
                WHERE site_id = :site_id 
                ORDER BY `name` ASC";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        
        $categories = array();
        
        foreach($result as $row) {
            $categories[$row['id']] = $row['name'];
        }
        
        return $categories;
    }
    
    /**
    * Fetch the image library sub categories for the selected site and 
    * category, an all option can be added to the end of the array if required
    * 
    * @param integer $site_id
    * @param integer $category_id
    * @param boolean $all Add an all option
    * @return array Array containing all the image library sub categories for 
    *               the selected category and site
    */
    public function subCategories($site_id, $category_id, $all=TRUE) 
    {
        $sql = "SELECT id, `name` 
                FROM user_site_image_library_sub_categories 
                WHERE site_id = :site_id 
                AND category_id = :category_id 
                ORDER BY `name` ASC";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        
        $sub_categories = array();
        
        foreach($result as $row) {
            $sub_categories[$row['id']] = $row['name'];
        }
        
        if($all == TRUE) {
            $sub_categories[0] = Dlayer_Config::IMAGE_LIBRARY_ALL_SUB_CATEGORY;
        }
        
        return $sub_categories;
    }
    
    /**
    * Check to see if the category exists
    * 
    * @param integer $site_id
    * @param string $category Name of category to check
    * @param integer|NULL $ignore_id Category to exclude from query if 
    *                                doing a check on an edit form
    * @return boolean
    */
    public function categoryExists($site_id, $category, $ignore_id=NULL) 
    {
        $sql = "SELECT id 
                FROM user_site_image_library_categories 
                WHERE site_id = :site_id 
                AND UPPER(`name`) = :category ";
        if($ignore_id != NULL) {
            $sql .= "AND id <> :ignore_id ";
        }
        $sql .= "LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':category', strtoupper($category), PDO::PARAM_STR);
        if($ignore_id != NULL) {
            $stmt->bindValue(':ignore_id', $ignore_id, PDO::PARAM_INT);
        }
        $stmt->execute();
        
        $result = $stmt->fetch();
        
        if($result == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    /**
    * Check to see if the requested category id exists for the selected site
    * 
    * @param integer $site_id
    * @param integer $category_id
    * @return boolean TRUE if the category id exists
    */
    public function categoryIdExists($site_id, $category_id) 
    {
        $sql = "SELECT id 
                FROM user_site_image_library_categories 
                WHERE site_id = :site_id 
                AND id = :category_id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch();
        
        if($result != FALSE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
    * Check to see if the requested sub category exists for the selected site 
    * and category
    * 
    * @param integer $site_id
    * @param integer $category_id
    * @param integer $sub_category_id
    * @return boolean TRUE if the sub category id exists
    */
    public function subCategoryIdExists($site_id, $category_id, 
    $sub_category_id) 
    {
        $sql = "SELECT id 
                FROM user_site_image_library_sub_categories 
                WHERE site_id = :site_id 
                AND category_id = :category_id 
                AND id = :sub_category_id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindValue(':sub_category_id', $sub_category_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch();
        
        if($result != FALSE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
    * Check to see if the sub category exists
    * 
    * @param integer $site_id
    * @param integer $category_id
    * @param string $sub_category Name of sub category to check
    * @param integer|NULL $ignore_id Sub cdategory to exclude from query if 
    *                                doing a check on an edit form
    * @return boolean
    */
    public function subCategoryExists($site_id, $category_id, $sub_category, 
    $ignore_id=NULL) 
    {
        $sql = "SELECT id 
                FROM user_site_image_library_sub_categories 
                WHERE site_id = :site_id 
                AND category_id = :category_id 
                AND UPPER(`name`) = :sub_category ";
        if($ignore_id != NULL) {
            $sql .= "AND id <> :ignore_id ";
        }
        $sql .= "LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindValue(':sub_category', strtoupper($sub_category), 
        PDO::PARAM_STR);
        if($ignore_id != NULL) {
            $stmt->bindValue(':ignore_id', $ignore_id, PDO::PARAM_INT);
        }
        $stmt->execute();
        
        $result = $stmt->fetch();
        
        if($result == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}