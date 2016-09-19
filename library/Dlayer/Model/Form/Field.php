<?php
/**
* Form field model classes, handles the generic database queries used by
* multiple form fields
*
* @todo Rename method in model, don't need things like form and field in name,
* implied by name of model
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Model_Form_Field extends Zend_Db_Table_Abstract
{
	/**
	* Add the attributes for the form field, shared method, used by all the
	* form field tools
	*
	* @param integer $site_id
	* @param integer $form_id
	* @param integer $field_id Id of the new form field
	* @param array $attributes Attributes to insert for the form field
	* @param array $params Post params from form
	* @param string $field_type Type of field to add attributes for
	* @return void
	*/
	public function addFieldAttributes($site_id, $form_id, $field_id,
		array $attributes, array $params, $field_type)
	{
		$sql = "INSERT INTO user_site_form_field_attribute
				(site_id, form_id, field_id, attribute_id, attribute)
				VALUES
				(:site_id, :form_id, :field_id,
				(SELECT ffa.id
				FROM designer_form_field_attribute ffa
				JOIN designer_form_field_type fft
				ON ffa.field_type_id = fft.id
				WHERE ffa.attribute = :attribute
				AND fft.type = :field_type), :attribute_value)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
		$stmt->bindValue(':field_id', $field_id, PDO::PARAM_INT);
		$stmt->bindValue(':field_type', $field_type, PDO::PARAM_STR);

		foreach($attributes as $attribute) {
			$stmt->bindValue(':attribute', $attribute, PDO::PARAM_STR);
			$stmt->bindValue(':attribute_value', $params[$attribute],
				PDO::PARAM_STR);

			$stmt->execute();
		}
	}

	/**
	* Edit the attributes for the form field, shared method, used by all the
	* form field tools
	*
	* @param integer $site_id
	* @param integer $form_id
	* @param integer $field_id Id of the new form field
	* @param array $attributes Attributes to insert for the form field
	* @param array $params Post params from form
	* @param string $field_type Type of field to add attributes for
	* @return void
	*/
	public function editFieldAttributes($site_id, $form_id, $field_id,
		array $attributes, array $params, $field_type)
	{
		$sql = "UPDATE user_site_form_field_attribute
				SET attribute = :attribute_value
				WHERE site_id = :site_id
				AND form_id = :form_id
				AND field_id = :field_id
				AND attribute_id = (
				SELECT ffa.id
				FROM designer_form_field_attribute ffa
				JOIN designer_form_field_type fft
				ON ffa.field_type_id = fft.id
				WHERE ffa.attribute = :attribute
				AND fft.type = :field_type)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
		$stmt->bindValue(':field_id', $field_id, PDO::PARAM_INT);
		$stmt->bindValue(':field_type', $field_type, PDO::PARAM_STR);

		foreach($attributes as $attribute) {
			$stmt->bindValue(':attribute', $attribute, PDO::PARAM_STR);
			$stmt->bindValue(':attribute_value', $params[$attribute],
				PDO::PARAM_STR);
			$stmt->execute();
		}
	}

	/**
	* Check to see if the given form field id is valid, needs to belong to the
	* given form id, site id and be of the correct type
	*
	* @param integer $id Form field id
	* @param integer $site_id
	* @param integer $form_id
	* @param integer $type Type of form field
	* @return boolean
	*/
	public function valid($id, $site_id, $form_id, $type)
	{
		$sql = "SELECT uff.id
				FROM user_site_form_field uff
				JOIN designer_form_field_type fft ON uff.field_type_id = fft.id
				WHERE uff.form_id = :form_id
				AND uff.site_id = :site_id
				AND uff.id = :field_id
				AND fft.type = :type";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
		$stmt->bindValue(':field_id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':type', $type, PDO::PARAM_STR);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	* Fetch the details for the requested field, depending on whether a result
	* is found this method calls a private method to get the options for the
	* input
	*
	* @param integer $id Field id
	* @param integer $site_id
	* @param integer $form_id
	* @param string $tool Form field tool, separate to form field type
	* @return array|FALSE
	*/
	public function field($id, $site_id, $form_id, $tool)
	{
		$sql = "SELECT uff.id, uff.label, uff.description
				FROM user_site_form_field uff
				JOIN dlayer_module_tool dmt ON uff.tool_id = dmt.id
				AND dmt.model = :tool
				AND dmt.module_id = 3
				AND dmt.enabled = 1
				WHERE uff.site_id = :site_id
				AND uff.form_id = :form_id
				AND uff.id = :field_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
		$stmt->bindValue(':field_id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':tool', $tool, PDO::PARAM_STR);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE) {
			return $result;
		} else {
			return FALSE;
		}
	}

	/**
	* Fetch the attributes for a form field, returns an array with the
	* attributes as the keys, values are all FALSE, can be overridden
	* in the ribbon data classes
	*
	* @param string $field_type
	* @return array
	*/
	public function attributes($field_type)
	{
		$sql = "SELECT ffa.attribute
				FROM designer_form_field_attribute ffa
				JOIN designer_form_field_type fft
				ON ffa.field_type_id = fft.id
				WHERE fft.type = :field_type";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':field_type', $field_type, PDO::PARAM_STR);
		$stmt->execute();

		$result = $stmt->fetchAll();

		$attributes = array();

		foreach($result as $attribute) {
			$attributes[$attribute['attribute']] = FALSE;
		}

		return $attributes;
	}

	/**
	* Fetch all the assigned attributes for the requested form field,
	* attribute array is returned wih the values converted to the correct types
	*
	* @param integer $id Form field id
	* @param integer $site_id
	* @param integer $form_id
	* @return array Attributes for requested form field
	*/
	public function assignedAttributes($id, $site_id, $form_id)
	{
		$sql = "SELECT uffa.field_id, uffa.attribute AS `value`,
				ffa.attribute, ffat.type
				FROM user_site_form_field_attribute uffa
				JOIN designer_form_field_attribute ffa
				ON uffa.attribute_id = ffa.id
				JOIN designer_form_field_attribute_type ffat
				ON ffa.attribute_type_id = ffat.id
				WHERE uffa.site_id = :site_id
				AND uffa.form_id = :form_id
				AND uffa.field_id = :field_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
		$stmt->bindValue(':field_id', $id, PDO::PARAM_INT);
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

			$attributes[$row['attribute']] = $value;
		}

		return $attributes;
	}

	/**
	* Move the requested form field, either up or down. Once the sort order of
	* the current item has been worked out and the id of the other item that
	* will be affected is known requests are sent to move the form fields
	*
	* @param string $direction
	* @param string $field_type
	* @param integer $field_id
	* @param integer $form_id
	* @param integer $site_id
	* @return void
	*/
	public function moveFormField($direction, $field_type, $field_id, $form_id,
		$site_id)
	{
		$process = FALSE;

		/**
		* @todo Need to update this, check the types against the database
		*/
		if(in_array($field_type,
		array('text', 'textarea', 'password')) == TRUE) {

			$sort_order = $this->sortOrder($site_id, $form_id, $field_type,
				$field_id);

			if($sort_order != FALSE) {
				$process = TRUE;
			}
		}

		if($process == TRUE) {

			switch($direction) {
				case 'up':
					if($sort_order > 1) {
						$sibling_field_id = $this->formFieldIdBySortOrder(
							$site_id, $form_id, $sort_order-1);

						$this->setSortOrder($site_id, $form_id, $field_id,
							$sort_order-1);

						$this->setSortOrder($site_id, $form_id,
							$sibling_field_id, $sort_order);
					}
					break;

				case 'down':
					if($sort_order < $this->numberFormFields($site_id,
					$form_id)) {
						$sibling_field_id = $this->formFieldIdBySortOrder(
							$site_id, $form_id, $sort_order+1);

						$this->setSortOrder($site_id, $form_id, $field_id,
							$sort_order+1);

						$this->setSortOrder($site_id, $form_id,
							$sibling_field_id, $sort_order);
					}
					break;

				default:
					throw new Exception('Direction \'' . $direction . '\' not
					found in Dlayer_Model_Form_Field::moveFormField()');
					break;
			}

		} else {
			throw new Exception('Field type \'' . $field_type . '\' not
				supported in Dlayer_Model_Form_Field::moveFormField() or
			sort order not returned by Dlayer_Model_Form_Field::sortOrder');
		}
	}

	/**
	* Update the sort order for the requested form field
	*
	* @param integer $site_id
	* @param integer $form_id
	* @param integer $field_id
	* @param integer $sort_order
	* @return void
	*/
	private function setSortOrder($site_id, $form_id, $field_id, $sort_order)
	{
		$sql = "UPDATE user_site_form_field
				SET sort_order = :sort_order
				WHERE id = :field_id
				AND site_id = :site_id
				AND form_id = :form_id
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
		$stmt->bindValue(':field_id', $field_id, PDO::PARAM_INT);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
		$stmt->execute();
	}

	/**
	* Fetch the sort order for the requested form field
	*
	* @param integer $site_id
	* @param integer $form_id
	* @param string $field_type
	* @param integer $field_id
	* @return integer|FALSE Current sort order
	*/
	private function sortOrder($site_id, $form_id, $field_type, $field_id)
	{
		$sql = "SELECT usff.sort_order
				FROM user_site_form_field usff
				JOIN designer_form_field_type fft
				ON usff.field_type_id = fft.id
				AND fft.type = :field_type
				WHERE usff.site_id = :site_id
				AND usff.form_id = :form_id
				AND usff.id = :field_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
		$stmt->bindValue(':field_type', $field_type, PDO::PARAM_STR);
		$stmt->bindValue(':field_id', $field_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE) {
			return intval($result['sort_order']);
		} else {
			return FALSE;
		}
	}

	/**
	* Fetch the form field which has the requested sort order
	*
	* @param integer $site_id
	* @param integer $form_id
	* @param integer $sort_order
	* @return integer|FALSE Form field id
	*/
	private function formFieldIdBySortOrder($site_id, $form_id, $sort_order)
	{
		$sql = "SELECT usff.id
				FROM user_site_form_field usff
				WHERE usff.site_id = :site_id
				AND usff.form_id = :form_id
				AND usff.sort_order = :sort_order";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
		$stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE) {
			return intval($result['id']);
		} else {
			return FALSE;
		}
	}

	/**
	* Fetch the total number of form fields that have been added to the form
	*
	* @param integer $site_id
	* @param integer $form_id
	* @return integer Number of form fields
	*/
	private function numberFormFields($site_id, $form_id)
	{
		$sql = "SELECT usff.id
				FROM user_site_form_field usff
				WHERE usff.site_id = :site_id
				AND usff.form_id = :form_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
		$stmt->execute();

		return count($stmt->fetchAll());
	}

	/**
	* Calculate the new sort order values, fetches the current MAX and then
	* adds one
	*
	* @todo This method wont be required later when a user can choose exactly
	* where they want to insert the content block
	*
	* @param integer $site_id
	* @param integer $form_id
	* @return integer New sort order value
	*/
	private function newSortOrder($site_id, $form_id)
	{
		$sql = "SELECT IFNULL(MAX(sort_order), 0) + 1 AS sort_order
				FROM user_site_form_field
				WHERE site_id = :site_id
				AND form_id = :form_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		return $result['sort_order'];
	}

	/**
	* Add the form field to the form
	*
	* @param integer $site_id
	* @param integer $form_id
	* @param string $field_type
	* @param string $tool
	* @param array $params Options for field
	* @return integer Id of the newly created field
	*/
	public function addFormField($site_id, $form_id, $field_type, $tool,
		array $params)
	{
		$sort_order = $this->newSortOrder($site_id, $form_id);

		$sql = "INSERT INTO user_site_form_field
				(site_id, form_id, field_type_id, tool_id, label,
				description,
				sort_order)
				VALUES
				(:site_id, :form_id, (SELECT id FROM designer_form_field_type
				WHERE type = :field_type), (SELECT id FROM dlayer_module_tool 
				WHERE tool = :tool AND module_id = 3 AND enabled = 1), :label,
				:description, :sort_order)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
		$stmt->bindValue(':field_type', $field_type, PDO::PARAM_STR);
		$stmt->bindValue(':tool', $tool, PDO::PARAM_STR);
		$stmt->bindValue(':label', $params['label'], PDO::PARAM_STR);
		$stmt->bindValue(':description', $params['description'],
			PDO::PARAM_STR);
		$stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
		$stmt->execute();

		return $this->_db->lastInsertId('user_site_form_field');
	}

	/**
	* Edit the details for the requested form field
	*
	* @param integer $site_id
	* @param integer $form_id
	* @param integer $field_id
	* @param array $params
	* @return void
	*/
	public function editFormField($site_id, $form_id, $field_id, array $params)
	{
		$sql = "UPDATE user_site_form_field
				SET label = :label, description = :description
				WHERE site_id = :site_id
				AND form_id = :form_id
				AND id = :field_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':label', $params['label'], PDO::PARAM_STR);
		$stmt->bindValue(':description', $params['description'],
			PDO::PARAM_STR);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
		$stmt->bindValue(':field_id', $field_id, PDO::PARAM_INT);
		$stmt->execute();
	}

	/**
	* Fetch the live edit preview methods and data for the selected form field
	* params, label and description are standard for all inputs so we only need
	* to pull the custom attributes
	*
	* @param integer $site_id
	* @param integer $form_id
	* @param integer $field_id
	* @return array Contains the js preview method names and params
	*/
	public function previewMethods($site_id, $form_id, $field_id)
	{
		$sql = "SELECT dfpm.method, usff.id AS field_id, dffa.attribute,
				usffa.attribute AS attribute_value
				FROM user_site_form_field usff
				JOIN user_site_form_field_attribute usffa
				ON usff.id = usffa.field_id
				AND usffa.site_id = :site_id
				AND usffa.form_id = :form_id
				JOIN designer_form_field_attribute dffa
				ON usffa.attribute_id = dffa.id
				AND dffa.field_type_id = usff.field_type_id
				JOIN designer_form_field_param_preview dffpp
				ON usffa.attribute_id = dffpp.field_attribute_id
				AND dffpp.field_type_id = usff.field_type_id
				JOIN designer_form_preview_method dfpm
				ON dffpp.preview_method_id = dfpm.id
				WHERE usff.site_id = :site_id
				AND usff.form_id = :form_id
				AND usff.id = :field_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, pDO::PARAM_INT);
		$stmt->bindValue(':form_id', $form_id, pDO::PARAM_INT);
		$stmt->bindValue(':field_id', $field_id, pDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll();
	}
}
