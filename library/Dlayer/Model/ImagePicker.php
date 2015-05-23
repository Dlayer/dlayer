<?php
/**
* Image picker model
* 
* Used by the image picker tool to fetch the data to build the image picker
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @category Model
*/
class Dlayer_Model_ImagePicker extends Zend_Db_Table_Abstract
{
	/**
	* Fetch the categories from the image library that have images assigned 
	* to them along witrh the number of images in each category
	* 
	* @param integer $site_id
	* @return array Simple array to be passed to a select input 
	*/
	public function categories($site_id) 
	{
		$sql = 'SELECT usilc.id, usilc.`name`, 
					COUNT(usil.id) AS number_of_images 
				FROM user_site_image_library usil 
				JOIN user_site_image_library_category usilc 
					ON usil.category_id = usilc.id 
					AND usilc.site_id = :site_id 
				WHERE usil.site_id = :site_id 
				GROUP BY usil.category_id 
				ORDER BY usilc.`name` ASC ';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetchAll();
		
		$options = array('null'=>'Select category');
		
		foreach($result as $row) {
			$options[intval($row['id'])] = $row['name'] . '(' . 
				$row['number_of_images'] . ')';
		}
		
		return $options;
	}
	
	/**
	* Fetch the details for the requested category, need the name and the 
	* number of images in the category
	* 
	* @param integer $site_id
	* @param integer $category_id
	* @return array
	*/
	public function category($site_id, $category_id) 
	{
		$sql = 'SELECT usilc.id, usilc.`name`, 
					(SELECT COUNT(usil.id) 
					FROM user_site_image_library usil 
					WHERE usil.site_id = :site_id 
					AND usil.category_id = :category_id) AS number_of_images 
				FROM user_site_image_library_category usilc 
				WHERE usilc.site_id = :site_id 
				AND usilc.id = :category_id';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetch();
	}
	
	/**
	* Fetch the sub category from the image library for the requested site id 
	* and category id that have images. An all category should be appended to 
	* to the array
	* 
	* @param integer $site_id
	* @param integer $category_id
	* @return array Simple array to be assign to a select input 
	*/
	public function subCategories($site_id, $category_id) 
	{
		$sql = 'SELECT usilsc.id, usilsc.`name`, 
					COUNT(usil.id) AS number_of_images 
				FROM user_site_image_library usil 
				JOIN user_site_image_library_sub_category usilsc 
					ON usil.sub_category_id = usilsc.id 
					AND usilsc.category_id = :category_id 
					AND usilsc.site_id = :site_id 
				WHERE usil.site_id = :site_id 
				AND usil.category_id = :category_id 
				GROUP BY usilsc.id 
				ORDER BY usilsc.`name` ASC ';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetchAll();
		
		$options = array('null'=>'Select sub category');
		
		foreach($result as $row) {
			$options[intval($row['id'])] = $row['name'] . '(' . 
				$row['number_of_images'] . ')';
		}
		
		$options[0] = 'Show all';
		
		return $options;
	}
	
	/**
	* Fetch the details for the requested sub category, need the name and the 
	* number of images in the sub category.
	* 
	* If 0 is provided as the sub category id we returns the details for all 
	* the images in the category.
	* 
	* @param integer $site_id
	* @param integer $category_id
	* @param integer $sub_category_id
	* @return array
	*/
	public function subCategory($site_id, $category_id, $sub_category_id) 
	{
		if($sub_category_id !== 0) {
			$sql = 'SELECT usilsc.id, usilsc.`name`, 
						(SELECT COUNT(usil.id) 
						FROM user_site_image_library usil 
						WHERE usil.site_id = :site_id
						AND usil.category_id = :category_id 
						AND usil.sub_category_id = :sub_category_id) AS number_of_images
					FROM user_site_image_library_sub_category usilsc 
					WHERE usilsc.site_id = :site_id 
					AND usilsc.category_id = :category_id 
					AND usilsc.id = :sub_category_id';
			$stmt = $this->_db->prepare($sql);
			$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
			$stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
			$stmt->bindValue(':sub_category_id', $sub_category_id, PDO::PARAM_INT);
			$stmt->execute();
			
			return $stmt->fetch();
		} else {
			$result = $this->category($site_id, $category_id);
			
			$result['name'] = 'All images';
			
			return $result;
		}
	}
	
	/**
	* Fetch the images for a category and sub category, if the sub category is 
	* set to 0 we don't include it in the query and retuirn all the images for 
	* the category
	* 
	* @param integer $site_id
	* @param integer $category_id
	* @param integer $sub_category
	* @return array Contains all the images assigned to the category and 
	* 	sub category
	*/
	public function images($site_id, $category_id, $sub_category_id) 
	{
		$sql = 'SELECT usil.`name`, usil.id AS image_id, usilv.id AS version_id, 
				usilvm.extension, usilvm.width, usilvm.height, usilvm.size, 
				(SELECT COUNT(versions.id) 
					FROM user_site_image_library_version versions 
					WHERE versions.library_id = usil.id 
					AND versions.site_id = 1) AS versions
				FROM user_site_image_library usil 
				JOIN user_site_image_library_link usill 
					ON usil.id = usill.library_id 
					AND usill.site_id = :site_id 
				JOIN user_site_image_library_version usilv 
					ON usill.version_id = usilv.id 
					AND usill.library_id = usilv.library_id 
					AND usill.site_id = :site_id 
				JOIN user_site_image_library_version_meta usilvm 
					ON usilv.id = usilvm.version_id 
					AND usilv.library_id = usilvm.library_id 
					AND usilv.site_id = :site_id 
				WHERE usil.site_id = :site_id 
				AND usil.category_id = :category_id ';
		if($sub_category_id != 0) {
			$sql .= 'AND usil.sub_category_id = :sub_category_id ';
		}
		$sql .= 'ORDER BY usil.`name` ASC';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
		if($sub_category_id != 0) {
			$stmt->bindValue(':sub_category_id', $sub_category_id, 
			PDO::PARAM_INT);
		}
		$stmt->execute();
		
		$images = array();
		
		$result = $stmt->fetchAll();

		foreach($result as $row) {
			$row['size'] = Dlayer_Helper::readableFilesize($row['size']);
			$images[] = $row;
		}

		return $images;
	}
	
	/**
	* Fetch the details for the selected image, name and number of versions, 
	* sub category id is not passed to method because it may be set as 0, for 
	* all images, the three included values are enought to limit the query
	* 
	* @param integer $site_id
	* @param integer $category_id
	* @param integer $image_id
	*/
	public function image($site_id, $category_id, $image_id) 
	{
		$sql = 'SELECT usil.`name`, 
				(SELECT COUNT(versions.id) 
					FROM user_site_image_library_version versions 
					WHERE versions.library_id = usil.id 
					AND versions.site_id = :site_id) AS number_of_versions  
				FROM user_site_image_library usil 
				WHERE usil.site_id = :site_id 
				AND usil.category_id = :category_id 
				AND usil.id = :image_id';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
		$stmt->bindValue(':image_id', $image_id, PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetch();
	}
	
	/**
	* Fetch all the versions for the selected image
	* 
	* @param integer $site_id
	* @param integer $category_id 
	* @param integer $image_id 
	* @return array
	*/
	public function versions($site_id, $category_id, $image_id) 
	{
		$sql = 'SELECT usil.`name`, usil.id AS image_id, 
				usilv.id AS version_id, usilvm.extension, 
				usilvm.width, usilvm.height, usilvm.size 
				FROM user_site_image_library_version usilv 
				JOIN user_site_image_library usil 
					ON usilv.library_id = usil.id 
					AND usil.site_id = :site_id 
					AND usil.category_id = :category_id 
				JOIN user_site_image_library_version_meta usilvm 
					ON usilv.id = usilvm.version_id 
					AND usilv.library_id = usilvm.library_id 
				WHERE usilv.site_id = :site_id 
				AND usilv.library_id = :image_id 
				ORDER BY usilv.id DESC';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
		$stmt->bindValue(':image_id', $image_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$images = array();
		
		$result = $stmt->fetchAll();

		foreach($result as $row) {
			$row['size'] = Dlayer_Helper::readableFilesize($row['size']);
			$images[] = $row;
		}

		return $images;
	}
	
	/**
	* Check that the given image id and version id are valid
	* 
	* @param integer $site_id 
	* @param integer $image_id 
	* @param integer $version_id 
	* @return array|FALSE Either returns an array containing the image name 
	* 	name of FALSE if the image cannot be selected
	*/
	public function validateImage($site_id, $image_id, $version_id) 
	{
		$sql = 'SELECT usil.`name` 
				FROM user_site_image_library_version usilv 
				JOIN user_site_image_library usil 
					ON usilv.library_id = usil.id 
					AND usil.id = :image_id 
					AND usil.site_id = :site_id 
				WHERE usilv.id = :version_id 
				AND usilv.library_id = :image_id 
				AND usilv.site_id = :site_id';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':image_id', $image_id, PDO::PARAM_INT);
		$stmt->bindValue(':version_id', $version_id, PDO::PARAM_INT);
		$stmt->execute();
		
		return $result->fetch();
	}
}