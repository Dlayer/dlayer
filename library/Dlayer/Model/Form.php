<?php
/**
* Using the Form builder the user is able to create forms which can be placed
* withing templates, content pages or widgets using the respective designer
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
* @category Model
*/
class Dlayer_Model_Form extends Zend_Db_Table_Abstract
{
	/**
	* Check to see if the given form id is valid and belongs to the current 
	* site.
	*
	* @param integer $form_id
	* @param integer $site_id
	* @return boolean TRUE if the form is valid
	*/
	public function valid($form_id, $site_id)
	{
		$sql = "SELECT id
				FROM user_site_form
				WHERE site_id = :site_id
				AND id = :form_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	* Fetch all the forms that have been defined for the requested site.
	*
	* Initially a user will have 2 sample sites which will contain sample
	* forms, when a new site is created from scracth there will be no
	* forms, it is therefore entirely possible that there will be no forms for
	* the requested site
	*
	* @param integer $site_id
	* @return array Array of the forms for the site
	*/
	public function forms($site_id)
	{
		$sql = "SELECT id, `name`
				FROM user_site_form
				WHERE site_id = :site_id
				ORDER BY `name` ASC";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll();
	}

	/**
	 * Check to see if the supplied form name is unique for the site
	 *
	 * @param string $name Name for form
	 * @param integer $site_id Id of the site the form belongs to
	 * @param integer|NULL $id Id of form to exclude from query
	 * @return boolean
	 */
	public function nameUnique($name, $site_id, $id=NULL)
	{
		$where = NULL;

		if($id != NULL)
		{
			$where = 'AND id != :form_id ';
		}

		$sql = 'SELECT id
				FROM user_site_form
				WHERE UPPER(`name`) = :name
				AND site_id = :site_id ';
		$sql .= $where;
		$sql .= 'LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':name', strtoupper($name), PDO::PARAM_STR);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		if($id != NULL)
		{
			$stmt->bindValue(':form_id', $id, PDO::PARAM_INT);
		}
		$stmt->execute();

		$result = $stmt->fetch();

		if($result == FALSE)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Insert a new form record
	 *
	 * @param integer $site_id Site the form belongs to
	 * @param string $name Name of the form within Dlayer
	 * @param string $email Email address for copy of submissions
	 * @param string $title Title/legend for form
	 * @param string|NULL $sub_title Sub title/legend
	 * @return integer|FALSE Either the id of the new page or FALSE upon failure
	 */
	private function addForm($site_id, $name, $email, $title, $sub_title)
	{
		$sql = "INSERT INTO user_site_form 
				(site_id, `name`, email) 
				VALUES
				(:site_id, :name, :email)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':email', $email, PDO::PARAM_STR);
		$result = $stmt->execute();

		if($result === TRUE)
		{
			$form_id = intval($this->_db->lastInsertId('user_site_form'));

			/**
			 * @todo This is referencing the tool mode, not ideal
			 */

			// Insert the default layout settings for the form
			$model_layout = new Dlayer_DesignerTool_FormBuilder_FormLayout_Model();
			$model_layout->setDefaults($site_id, $form_id, $title, $sub_title,
				Dlayer_Config::FORM_DEFAULT_SUBMIT_LABEL, Dlayer_Config::FORM_DEFAULT_RESET_LABEL,
				Dlayer_Config::FORM_DEFAULT_LAYOUT_ID, Dlayer_Config::FORM_DEFAULT_HORIZONTAL_WIDTH_LABEL,
				Dlayer_Config::FORM_DEFAULT_HORIZONTAL_WIDTH_FIELD);

			return $form_id;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Fetch the details for the requested form, used on edit page
	 *
	 * @param $id
	 * @param $site_id
	 * @return array|FALSE
	 */
	public function form($id, $site_id)
	{
		$sql = "SELECT `name`, email  
				FROM user_site_form 
				WHERE site_id = :site_id
				AND id = :form_id 
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch();
	}

	/**
	 * Edit the details for the selected form
	 *
	 * @param integer $id
	 * @param string $name
	 * @param string $email
	 * @return boolean
	 */
	private function editForm($id, $name, $email)
	{
		$sql = "UPDATE user_site_form
				SET `name` = :name,
				email = :email 
				WHERE id = :form_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':email', $email, PDO::PARAM_STR);
		$stmt->bindValue(':form_id', $id, PDO::PARAM_INT);
		return $stmt->execute();
	}

	/**
	 * Save the form, either inserts a new record or updates the given record
	 *
	 * @param integer $site_id
	 * @param string $name Name of form within Dlayer
	 * @param string $email Email address for copies of submissions
	 * @param string $title|NULL Form title/legend
	 * @param string $sub_title|NULL Form sub title/legend
	 * @param integer|NULL $id Form id when editing
	 * @return integer|FALSE Either the form id or FALSE upon failure
	 */
	public function saveForm($site_id, $name, $email, $title=NULL, $sub_title=NULL, $id=NULL)
	{
		if($id === NULL)
		{
			$id = $this->addForm($site_id, $name, $email, $title, $sub_title);
		}
		else
		{
			$id = $this->editForm($id, $name, $email);
		}

		return $id;
	}
}
