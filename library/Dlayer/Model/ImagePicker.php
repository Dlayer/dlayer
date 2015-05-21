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
}