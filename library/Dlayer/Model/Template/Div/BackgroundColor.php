<?php
/**
* Background color model
*
* Any div in template can have a background color, this model handles all the
* changes
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
* @category Model
*/
class Dlayer_Model_Template_Div_BackgroundColor extends Zend_Db_Table_Abstract
{
	/**
	* Check to see if a background color exists for the given div
	*
	* @param integer $site_id
	* @param integer $template_id
	* @param integer $id Template div id
	* @return boolean
	*/
	public function checkForBackgroundColor($site_id, $template_id, $id)
	{
		$sql = "SELECT ustdbc.id
				FROM user_site_template_div_background_color ustdbc
				WHERE ustdbc.site_id = :site_id
				AND ustdbc.div_id = :div_id
				AND ustdbc.template_id = :template_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	* Fetch the existing background color for a template div, if there is no
	* background color return FALSE
	*
	* @param integer $site_id
	* @param integer $template_id
	* @param integer $id Template div id
	* @return string|FALSE
	*/
	public function existingBackgroundColor($site_id, $template_id, $id)
	{
		$sql = "SELECT ustdbc.color_hex
				FROM user_site_template_div_background_color ustdbc
				WHERE ustdbc.site_id = :site_id
				AND ustdbc.div_id = :div_id
				AND ustdbc.template_id = :template_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE) {
			return $result;
		} else {
			return FALSE;
		}
	}

	/**
	* Insert the background color for the div into the database
	*
	* @param integer $site_id
	* @param integer $id Template div id
	* @param string $color_hex Background color for div
	* @return void
	*/
	public function insertBackgroundColor($site_id, $template_id, $id,
		$color_hex)
	{
		$sql = "INSERT INTO user_site_template_div_background_color
				(site_id, template_id, div_id, color_hex)
				VALUES
				(:site_id, :template_id, :div_id, :color_hex)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':color_hex', $color_hex, PDO::PARAM_INT);
		$stmt->execute();
	}

	/**
	* Update the background color for the selected template div
	*
	* @param integer $site_id
	* @param integer $template_id
	* @param integer $id Template div id
	* @param string $color_hex Background color for div
	* @return void
	*/
	public function updateBackgroundColor($site_id, $template_id, $id,
		$color_hex)
	{
		$sql = "UPDATE user_site_template_div_background_color
				SET color_hex = :color_hex
				WHERE site_id = :site_id
				AND div_id = :div_id
				AND template_id = :template_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':color_hex', $color_hex, PDO::PARAM_INT);
		$stmt->execute();
	}

	/**
	* Delete a background color entry
	*
	* @param integer $site_id
	* @param integer $template_id
	* @param integer $id Template div id
	* @return void
	*/
	public function deleteBackgroundColor($site_id, $template_id, $id)
	{
		$sql = "DELETE FROM user_site_template_div_background_color
				WHERE site_id = :site_id
				AND template_id = :template_id
				AND div_id = :div_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $id, PDO::PARAM_INT);
		$stmt->execute();
	}
}