<?php
/**
* Template model
*
* A user can create as many templates as thy want for each site
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
* @category Model
*/
class Dlayer_Model_Template extends Zend_Db_Table_Abstract
{
	/**
	* Check to see if the supplied template id is valid, needs to belong to
	* the supplied site
	*
	* @param integer $template_id
	* @param integer $site_id
	* @return boolean TRUE if the site id is valid
	*/
	public function valid($template_id, $site_id)
	{
		$sql = "SELECT id
				FROM user_site_template
				WHERE id = :template_id
				AND site_id = :site_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->execute();

		if($stmt->fetch() != FALSE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	* Fetch all the templates that have been defined for the requested site.
	*
	* Initially a user will have 2 sample sites which will contain sample
	* templates, when a new site is created from scracth there will be no
	* templates, it is therefore entirely possible that there will be no
	* templates for the requested site
	*
	* @param integer $site_id
	* @return array Array of the templates for the site
	*/
	public function templates($site_id)
	{
		$sql = "SELECT id, `name`
				FROM user_site_template
				WHERE site_id = :site_id
				ORDER BY `name` ASC";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll();
	}

	/**
	* Fetch the names and ids for all the templates that have been define
	* for the requested site
	*
	* @param integer $site_id
	* @return array Array of the templates, index id, value name
	*/
	public function templateNames($site_id)
	{
		$sql = "SELECT id, `name`
				FROM user_site_template
				WHERE site_id = :site_id
				ORDER BY `name` ASC";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetchAll();

		$rows = array();

		foreach($result as $row) {
			$rows[$row['id']] = $row['name'];
		}

		return $rows;
	}

	/**
	* Check to see if the supplied template name is unique
	*
	* @param string $name
	* @param integer $site_id Site id to limit results by
	* @param integer|NULL $template_id If in edit mode we need to supply the
	* 								   id of the current template so that the
	* 								   row can be excluded from the query
	* @return boolean TRUE if the tested tenmplate name is unique
	*/
	public function nameUnique($name, $site_id, $template_id=NULL)
	{
		$where = NULL;

		if($template_id != NULL) {
			$where = 'AND id != :template_id ';
		}

		$sql = "SELECT id
				FROM user_site_template
				WHERE UPPER(`name`) = :name
				AND site_id = :site_id ";
		$sql .= $where;
		$sql .= "LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':name', strtoupper($name), PDO::PARAM_STR);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		if($template_id != NULL) {
			$stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
		}
		$stmt->execute();

		$result = $stmt->fetch();

		if($result == FALSE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	* Add a new template to the requested site
	*
	* @param integer $site_id
	* @param string $name Name for the new template
	* @return integer New template id
	*/
	public function addTemplate($site_id, $name)
	{
		$sql = "INSERT INTO user_site_template
				(site_id, `name`)
				VALUES
				(:site_id, :name)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->execute();

		$template_id = $this->_db->lastInsertId('user_site_template');

		// Create the base div
		$model_template_div = new Dlayer_Model_Template_Div();
		$div_id = $model_template_div->add($site_id, $template_id, 0, 1);
		$model_template_div->setSizes($site_id, $template_id, $div_id,
			Dlayer_Config::DESIGNER_WIDTH, 0, Dlayer_Config::DESIGNER_HEIGHT);

		return $template_id;
	}

	/**
	* Edit the details for the selected site template
	*
	* @param integer $site_id
	* @param integer $template_id
	* @param string $name
	* @return void
	*/
	public function editTemplate($site_id, $template_id, $name)
	{
		$sql = "UPDATE user_site_template
				SET `name` = :name
				WHERE site_id = :site_id
				AND id = :template_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
		$stmt->execute();
	}

	/**
	* Fetch the details for the requested template.
	*
	* This method doesn't validate that the supplied values are valid or that
	* the returned value is an array, before this method is called the site
	* id and template id will have been checked and validated by the session
	* classes
	*
	* @param integer $template_id
	* @param integer $site_id;
	* @return array|FALSE Data array for site
	*/
	public function template($template_id, $site_id)
	{
		$sql = "SELECT id, `name`
				FROM user_site_template
				WHERE site_id = :site_id
				AND id = :template_id
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch();
	}
}