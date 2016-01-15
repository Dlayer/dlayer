<?php
/**
* Image library library model
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
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
				$sort_field = 'usilvm.`size`';
				break;

			case 'uploaded':
				$sort_field = 'usilv.`uploaded`';
				break;

			default:
				$sort_field = 'usil.`name`';
				break;
		}

		$sql = "SELECT SQL_CALC_FOUND_ROWS usil.`name`, usil.id AS image_id,
				usilv.id AS version_id, usilvm.extension, usilvm.size,
				DATE_FORMAT(usilv.uploaded, '%e %b %Y') AS uploaded, 
				(SELECT COUNT(versions.id) 
					FROM user_site_image_library_version versions 
					WHERE versions.library_id = usil.id) AS versions 
				FROM user_site_image_library usil
				JOIN user_site_image_library_link usill
				ON usil.id = usill.library_id
				AND usill.site_id = :site_id
				JOIN user_site_image_library_version usilv
				ON usill.version_id = usilv.id
				AND usilv.site_id = :site_id
				JOIN user_site_image_library_version_meta usilvm
				ON usilv.id = usilvm.version_id
				AND usil.id = usilvm.library_id
				AND usilvm.site_id = :site_id
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
	
	/**
	* Fetch the list of images for the insert image select
	* 
	* @todo Temp code, won't be need once image picker is in place
	* 
	* @param integer $site_id
	* @param integer $category_id
	* @param integer $sub_category_id
	* @return array
	*/
	public function imagesArrayForSelect($site_id) 
	{
		$sql = 'SELECT usill.version_id, usil.`name`, usilvm.width, 
				usilvm.height 
				FROM user_site_image_library usil 
				JOIN user_site_image_library_link usill 
					ON usil.id = usill.library_id 
					AND usill.site_id = :site_id 
				JOIN user_site_image_library_version usilv 
					ON usill.version_id = usilv.id 
					AND usilv.site_id = :site_id 
				JOIN user_site_image_library_version_meta usilvm 
					ON usilv.id = usilvm.version_id 
					AND usil.id = usilvm.library_id 
					AND usilvm.site_id = :site_id 
				WHERE usil.site_id = :site_id 
				ORDER BY usil.`name` ASC';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetchAll();
		
		$images = array();
		
		foreach($result as $row) {
			$images[$row['version_id']] = $row['name'] . 
				' (' . $row['width'] . ' x ' . $row['height'] . ')';
		}
		
		return $images;
	}	
	
	/**
	* Check to see if the supplied version id is a valid value from within the 
	* users Image library
	* 
	* @param integer $site_id
	* @param integer $version_id
	* @return boolean TRUE if the version id is valid
	*/
	public function valid($site_id, $version_id) 
	{
		$sql = 'SELECT usilv.id  
				FROM user_site_image_library_version usilv 
				WHERE usilv.site_id = :site_id 
				AND usilv.id = :version_id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':version_id', $version_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}