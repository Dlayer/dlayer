<?php
/**
* Styling model for the form field rows and elements
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Model_Form_Styling extends Zend_Db_Table_Abstract
{
	/**
	* Check to see if there is an existing background assigned for the form
	* field row
	*
	* @param integer $site_id
	* @param integer $form_id
	* @param integer $field_id
	* @return FALSE|integer Returns either the id of the existing background
	* 						color value or FALSE if there is no existing value
	*/
	public function existingRowBackgroundColor($site_id, $form_id, $field_id)
	{
		$sql = "SELECT usffrbc.id
				FROM user_site_form_field_row_background_color usffrbc
				WHERE usffrbc.site_id = :site_id
				AND usffrbc.form_id = :form_id
				AND usffrbc.field_id = :field_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
		$stmt->bindValue(':field_id', $field_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE) {
			return intval($result['id']);
		} else {
			return FALSE;
		}
	}

	/**
	* Add a background colour for the selected form fields row
	*
	* @param integer $site_id
	* @param integer $form_id
	* @param integer $field_id
	* @param string $color_hex
	* @return void
	*/
	public function addRowBackgroundColor($site_id, $form_id, $field_id,
		$color_hex)
	{
		$sql = "INSERT INTO user_site_form_field_row_background_color
				(site_id, form_id, field_id, color_hex)
				VALUES
				(:site_id, :form_id, :field_id, :color_hex)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
		$stmt->bindValue(':field_id', $field_id, PDO::PARAM_INT);
		$stmt->bindValue(':color_hex', $color_hex, PDO::PARAM_STR);
		$stmt->execute();
	}

	/**
	* Update the background color for the form field row, we just need to do
	* a simple update because we already have the id from the existing check
	*
	* @param integer $id
	* @param string $color_hex
	* @return void
	*/
	public function updateRowBackgroundColor($id, $color_hex)
	{
		$sql = "UPDATE user_site_form_field_row_background_color
				SET color_hex = :color_hex
				WHERE id = :id
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':color_hex', $color_hex, PDO::PARAM_STR);
		$stmt->execute();
	}

	/**
	* Clear the background color that has been set for the selected form
	* field row, simple delete because we already have the id from the
	* existing check
	*
	* @param integer $id
	* @return void
	*/
	public function clearRowBackgroundColor($id)
	{
		$sql = "DELETE FROM user_site_form_field_row_background_color
				WHERE id = :id
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
	}

	/**
	* Fetch the current background color for the form field row, if there is
	* no existing data return FALSE
	*
	* @param integer $site_id
	* @param integer $form_id
	* @param integer $field_id
	* @return string|FALSE
	*/
	public function rowBackgroundColor($site_id, $form_id, $field_id)
	{
		$sql = "SELECT usffrbc.color_hex
				FROM user_site_form_field_row_background_color usffrbc
				WHERE usffrbc.site_id = :site_id
				AND usffrbc.form_id = :form_id
				AND usffrbc.field_id = :field_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
		$stmt->bindValue(':field_id', $field_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result == FALSE) {
			return FALSE;
		} else {
			return $result['color_hex'];
		}
	}
}