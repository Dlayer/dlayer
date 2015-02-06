<?php
/**
* Border model
*
* Any div can have a border or multiple borders, this model handles all the
* border changes
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @category Model
*/
class Dlayer_Model_Template_Div_Border extends Zend_Db_Table_Abstract
{
	/**
	* Check for existing borders, returns all the assigned borders, results
	* array contains the position as the key and the width as the value
	*
	* @param integer $site_id
	* @param integer $template_id
	* @param integer $id Div id
	* @return array|FALSE Array is indexed by position, border width is the
	*                     value
	*/
	public function existingBorders($site_id, $template_id, $id)
	{
		$sql = "SELECT position, width
				FROM user_site_template_div_border
				WHERE site_id = :site_id
				AND template_id = :template_id
				AND div_id = :div_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetchAll();

		if($result == FALSE) {
			return FALSE;
		} else {
			$borders = array();

			foreach($result as $row) {
				$borders[$row['position']] = intval($row['width']);
			}

			return $borders;
		}
	}

	/**
	* Update the border style and color, width remaining the same
	*
	* @param integer $site_id
	* @param integer $template_id
	* @param integer $id Id of the div
	* @param string $position Position of the border
	* @param string $style Border style
	* @param string $color_hex Border color
	* @return void
	*/
	public function updateBorderStyleAndColor($site_id, $template_id, $id,
		$position, $style, $color_hex)
	{
		$sql = "UPDATE user_site_template_div_border
				SET style = :style, color_hex = :color_hex
				WHERE site_id = :site_id
				AND template_id = :template_id
				AND div_id = :div_id
				AND position = :position
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':position', $position, PDO::PARAM_STR);
		$stmt->bindValue(':style', $style, PDO::PARAM_STR);
		$stmt->bindValue(':color_hex', $color_hex, PDO::PARAM_STR);
		$stmt->execute();
	}

	/**
	* Update the current border for a div
	*
	* @param integer $site_id
	* @param integer $template_id
	* @param integer $id Id of the div
	* @param string $position Position of the border
	* @param string $style Border style
	* @param integer $width New border width
	* @param string $color_hex Border color
	* @return void
	*/
	public function updateBorder($site_id, $template_id, $id, $position,
		$style, $width, $color_hex)
	{
		$sql = "UPDATE user_site_template_div_border
				SET style = :style, width = :width, color_hex = :color_hex
				WHERE site_id = :site_id
				AND template_id = :template_id
				AND div_id = :div_id
				AND position = :position
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':position', $position, PDO::PARAM_STR);
		$stmt->bindValue(':style', $style, PDO::PARAM_STR);
		$stmt->bindValue(':width', $width, PDO::PARAM_INT);
		$stmt->bindValue(':color_hex', $color_hex, PDO::PARAM_STR);
		$stmt->execute();
	}

	/**
	* Delete any border that has been defined for the given position and
	* div
	*
	* @param integer $site_id
	* @param integer $template_id
	* @param integer $id Id of the div
	* @param string $position Border position to delete
	* @return void
	*/
	public function deleteBorder($site_id, $template_id, $id, $position)
	{
		$sql = "DELETE FROM user_site_template_div_border
				WHERE site_id = :site_id
				AND template_id = :template_id
				AND div_id = :div_id
				AND position = :position
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':position', $position, PDO::PARAM_STR);
		$stmt->execute();
	}

	/**
	* Check for an existing border, if there is an existing border for the
	* given position we need to know the current width
	*
	* @param integer $site_id
	* @param integer $template_id
	* @param integer $id Div id
	* @param string $position Border position
	* @return integer|FALSE
	*/
	public function existingBorder($site_id, $template_id, $id, $position)
	{
		$sql = "SELECT width
				FROM user_site_template_div_border
				WHERE site_id = :site_id
				AND template_id = :template_id
				AND div_id = :div_id
				AND position = :position
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':position', $position, PDO::PARAM_STR);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result == FALSE) {
			return FALSE;
		} else {
			return intval($result['width']);
		}
	}

	/**
	* Add a border to the requested edge for the div
	*
	* @param integer $site_id
	* @param integer $template_id
	* @param integer $id Id of the div
	* @param string $position Position of the border
	* @param string $style Border style
	* @param integer $width Border width
	* @param string $color_hex Hex color
	* @return void
	*/
	public function addBorder($site_id, $template_id, $id, $position,
		$style, $width, $color_hex)
	{
		$sql = "INSERT INTO user_site_template_div_border
				(site_id, template_id, div_id, position, style, width,
				color_hex)
				VALUES
				(:site_id, :template_id, :div_id, :position, :style, :width,
				:color_hex)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':position', $position, PDO::PARAM_STR);
		$stmt->bindValue(':style', $style, PDO::PARAM_STR);
		$stmt->bindValue(':width', $width, PDO::PARAM_INT);
		$stmt->bindValue(':color_hex', $color_hex, PDO::PARAM_STR);
		$stmt->execute();
	}
}