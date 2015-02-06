<?php
/**
* Form builder view model
*
* The view model is responsible for fetching all the form and field data to
* generate the defined form in the form builder.
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @category View model
*/
class Dlayer_Model_View_Form extends Zend_Db_Table_Abstract
{
	/**
	* Fetch all the form fields that have been added to the requested form,
	* currently disabled form inputs are pulled because this is only used in
	* the form builder at the moment, the content, widget and template
	* designers will either use a modifed version of this or a different
	* method
	*
	* @param integer $id Form Id
	* @param integer $site_id
	* @return array Array of the forms field
	*/
	public function fields($id, $site_id)
	{
		$attributes = $this->fieldsAttributes($id, $site_id);

		$sql = "SELECT uff.id, uff.label, uff.description, fft.type,
				dmt.tool
				FROM user_site_form_field uff
				JOIN designer_form_field_type fft
				ON uff.field_type_id = fft.id
				JOIN dlayer_module_tool dmt ON uff.tool_id = dmt.id
				AND dmt.module_id = 3
				AND dmt.enabled = 1
				WHERE uff.site_id = :site_id
				AND uff.form_id = :form_id
				ORDER BY uff.sort_order ASC";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $id, PDO::PARAM_INT);
		$stmt->execute();

		$results = $stmt->fetchAll();

		$fields = array();

		foreach($results as $row) {
			if(array_key_exists($row['id'], $attributes) == TRUE) {
				$row['attributes'] = $attributes[$row['id']];
			} else {
				$row['attributes'] = array();
			}
			$fields[] = $row;
		}

		return $fields;
	}

	/**
	* Fetch the ids of the form fields that have been added to this form,
	* returns an array with the field ids as the keys and an empty array as
	* the value
	*
	* @param integer $site_id
	* @param integer $form_id
	* @return array
	*/
	public function fieldIds($site_id, $form_id)
	{
		$sql = "SELECT id
				FROM user_site_form_field
				WHERE site_id = :site_id
				AND form_id = :form_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
		$stmt->execute();

		$results = $stmt->fetchAll();

		$field_ids = array();

		foreach($results as $row) {
			$field_ids[$row['id']] = array();
		}

		return $field_ids;
	}

	/**
	* Fetch all the field attributes for the requested form, the attributes are
	* grouped by field id ready to be attached to field data arrays.
	*
	* @param integer $id
	* @param integer $site_id
	* @return array Array of all the form field attributes
	*/
	private function fieldsAttributes($id, $site_id)
	{
		$sql = "SELECT uffa.field_id, uffa.attribute AS `value`,
				ffa.attribute, ffat.type
				FROM user_site_form_field_attribute uffa
				JOIN designer_form_field_attribute ffa
				ON uffa.attribute_id = ffa.id
				JOIN designer_form_field_attribute_type ffat
				ON ffa.attribute_type_id = ffat.id
				WHERE uffa.site_id = :site_id
				AND uffa.form_id = :form_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $id, PDO::PARAM_INT);
		$stmt->execute();

		$results = $stmt->fetchAll();

		$attributes = array();

		foreach($results as $row) {
			switch($row['type']) {
				case 'integer':
					$value = intval($row['value']);
					break;

				default:
					$value = $row['value'];
					break;
			}

			$attributes[$row['field_id']][$row['attribute']] = $value;
		}

		return $attributes;
	}
}