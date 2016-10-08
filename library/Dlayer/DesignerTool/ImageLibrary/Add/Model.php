<?php

/**
 * Image library Add tool model
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ImageLibrary_Add_Model extends Zend_Db_Table_Abstract
{
	/**
	 * Fetch the image library categories set up for the requested site
	 *
	 * @param integer $site_id
	 * @param boolean $include_please_select Include the please select option
	 *
	 * @return array Categories indexed by category id
	 */
	public function categories($site_id, $include_please_select = FALSE)
	{
		$sql = "SELECT usilc.id, usilc.`name`
				FROM user_site_image_library_category usilc
				WHERE usilc.site_id = :site_id
				ORDER BY usilc.`name` ASC";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetchAll();

		$categories = array();

		if($include_please_select === TRUE)
		{
			$categories[0] = 'Please select';
		}

		foreach($result as $row)
		{
			$categories[intval($row['id'])] = $row['name'];
		}

		return $categories;
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
		$sql = "SELECT usilc.id
				FROM user_site_image_library_category usilc
				WHERE usilc.site_id = :site_id
				AND usilc.id = :category_id
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result === FALSE)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	/**
	 * Check to see if the requested sub category id exists for the selected site and category id
	 *
	 * @param integer $site_id
	 * @param integer $category_id
	 * @param integer $sub_category_id
	 * @return boolean TRUE if the sub category id exists
	 */
	public function subCategoryIdExists($site_id, $category_id, $sub_category_id)
	{
		$sql = "SELECT usilsc.id
				FROM user_site_image_library_sub_category usilsc
				WHERE usilsc.site_id = :site_id
				AND usilsc.category_id = :category_id
				AND usilsc.id = :sub_category_id
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
		$stmt->bindValue(':sub_category_id', $sub_category_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result === FALSE)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}
