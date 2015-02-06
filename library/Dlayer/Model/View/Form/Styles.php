<?php
/**
* Styles view model
*
* The styles view model is responsible for fetching all the styles that have
* been defined for the form fields are form field rows.
*
* The styles model is responsible for fetching all the styles data for the
* entire form, although fetched by section the styles are grouped later in
* the form designer class
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @category View model
*/
class Dlayer_Model_View_Form_Styles extends Zend_Db_Table_Abstract
{
	/**
	* Fetch all the background colors defined for the form field rows, returns
	* all the styles and returns an array indexed by form field id
	*
	* If a form field is selected in the Form builder we don't include its
	* row background color in the returned array, we don't want to override the
	* selected status row background color
	*
	* @param integer $site_id
	* @param integer $form_id
	* @param integer|NULL $field_id Id of the currently selected form field
	* @return array|FALSE An array of the background colors indexed by form
	* 					  field id, if no background colors have been assigned
	* 					  FALSE is returned
	*/
	public function rowBackgroundColors($site_id, $form_id, $field_id=NULL)
	{
		$sql = "SELECT usffrbc.field_id, usffrbc.color_hex
				FROM user_site_form_field_row_background_color usffrbc
				WHERE usffrbc.site_id = :site_id
				AND usffrbc.form_id = :form_id";
		if($field_id != NULL) {
			$sql .= " AND usffrbc.field_id != :field_id";
		}
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
		if($field_id != NULL) {
			$stmt->bindValue(':field_id', $field_id, PDO::PARAM_INT);
		}
		$stmt->execute();

		$result = $stmt->fetchAll();

		if(count($result) > 0) {
			$rows = array();

			foreach($result as $row) {
				$rows[$row['field_id']] = $row['color_hex'];
			}

			return $rows;
		} else {
			return FALSE;
		}
	}
}