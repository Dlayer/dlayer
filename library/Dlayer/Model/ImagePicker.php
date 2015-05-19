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
	* @return array Simple array to be passed to a select input object
	*/
	public function categories($site_id) 
	{
		$sql = 'SELECT usilc.id, usilc.`name`, COUNT(usil.id) AS number_of_images  
				FROM user_site_image_library usil 
				JOIN user_site_image_library_category usilc ON usil.category_id = usilc.id 
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
		return array(
			'id'=>1,
			'name'=>'Uncategorised', 
			'number_of_images'=>6
		);
	}
}
