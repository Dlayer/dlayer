<?php

/**
 * Fetch the styles for the rows that make up content pages
 *
 * @category View Model: These modesl are used to generate the data in the designers, the user data and later the web site
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Model_View_Style_Row extends Zend_Db_Table_Abstract
{
	/**
	 * Fetch all the defined background colour styles for the rows that make up the requested content page, results are
	 * returned indexed by row id
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @return array|FALSE Either an array indexed by row or FALSE if there are no defined style values
	 * @todo Will need to modify this as additional attribute types are supported, a single method will work better
	 */
	public function backgroundColors($site_id, $page_id)
	{
		$sql = "SELECT uspssrc.row_id, uspssrc.color_hex 
				FROM user_site_page_structure_style_row_color uspssrc 
				WHERE uspssrc.site_id = :site_id 
				AND uspssrc.page_id = :page_id 
				AND uspssrc.attribute = 'background-color'";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetchAll();

		if(count($result) > 0)
		{
			$styles = array();

			foreach($result as $row)
			{
				$styles[$row['row_id']] = $row['color_hex'];
			}

			return $styles;
		}
		else
		{
			return FALSE;
		}
	}
}
