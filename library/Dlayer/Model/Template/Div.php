<?php
/**
* Template div model
*
* A template and widgets are made up from divs, this model contains all the
* methods to modify and add/remove divs from templates and widgets
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @category Model
*/
class Dlayer_Model_Template_Div extends Zend_Db_Table_Abstract
{
	/**
	* Insert a new div into the database for a template
	*
	* @param integer $site_id
	* @param integer $template_id
	* @param integer $id Div id
	* @param integer $sort_order
	* @return integer|FALSE Either the id of the new row or FALSE is the
	*                       insert failed
	*/
	public function add($site_id, $template_id, $id, $sort_order)
	{
		$sql = "INSERT INTO user_site_template_div
				(site_id, template_id, parent_id, sort_order)
				VALUES
				(:site_id, :template_id, :parent_id, :sort_order)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
		$stmt->bindValue(':parent_id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
		$result = $stmt->execute();

		if($result == TRUE) {
			return $this->_db->lastInsertId('user_site_template_div');
		} else {
			return FALSE;
		}
	}

	/**
	* Clear the set height for the requested div, this is typically called
	* after inserting children or modifying a div in another way which means
	* it no longer needs to be fixed height, the div will still have a height
	* but only in terms of a minimum, this is what the design height is for, to
	* stop a div collapsing, content should always dictate the height of an
	* element
	*
	* @param integer $site_id
	* @param integer $id Template div
	* @return void
	*/
	public function clearHeight($site_id, $id)
	{
		$sql = "UPDATE user_site_template_div_size
				SET height = 0
				WHERE site_id = :site_id
				AND id = :div_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $id, PDO::PARAM_INT);
		$stmt->execute();
	}

	/**
	* Get the width for a single div, base width, no padding, margin or border,
	* this is the width that can be used by content and children
	*
	* @param integer $site_id
	* @param integer $id
	* @return integer
	*/
	public function width($site_id, $id)
	{
		if($id !== 0) {
			$sql = "SELECT ustds.width
					FROM user_site_template_div_size ustds
					WHERE ustds.site_id = :site_id
					AND ustds.div_id = :id";
			$stmt = $this->_db->prepare($sql);
			$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->execute();

			$result = $stmt->fetch();

			return intval($result['width']);
		} else {
			return Dlayer_Config::DESIGNER_WIDTH;
		}
	}

	/**
	* Returns the height for a div, fixed height is checked first, if zero the
	* design height is returned
	*
	* @param integer $site_id
	* @param integer $id
	* @return array Two indexes, height and fixed
	*/
	public function height($site_id, $id)
	{
		if($id !== 0) {
			$sql = "SELECT ustds.height, ustds.design_height
					FROM user_site_template_div_size ustds
					WHERE ustds.site_id = :site_id
					AND ustds.div_id = :id";
			$stmt = $this->_db->prepare($sql);
			$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->execute();

			$result = $stmt->fetch();

			if($result['height'] != 0) {
				return array('height'=>intval($result['height']),
					'fixed'=>TRUE);
			} else {
				return array('height'=>intval($result['design_height']),
					'fixed'=>FALSE);
			}
		} else {
			return array('height'=>Dlayer_Config::DESIGNER_HEIGHT,
				'fixed'=>FALSE);
		}
	}

	/**
	* Set the sizes for the newley added div
	*
	* @param integer $site_id
	* @param integer $template_id
	* @param integer $id Id of the newly inserted div
	* @param integer $width Width of new div
	* @param integer $height Height of new div
	* @param integer $design_height Design height for divs which don't have a
	*                               fixed height, when spliiting div the design
	*                               height is always set not the fixed height
	*                               unless the user sets otherwise
	* @return integer|FALSE Id of newly inserted row of FALSE if failed
	*/
	public function setSizes($site_id, $template_id, $id, $width, $height,
		$design_height)
	{
		$sql = "INSERT INTO user_site_template_div_size
				(site_id, template_id, div_id, width, height, design_height)
				VALUES
				(:site_id, :template_id, :div_id, :width, :height,
				:design_height)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':width', $width, PDO::PARAM_INT);
		$stmt->bindValue(':height', $height, PDO::PARAM_INT);
		$stmt->bindValue(':design_height', $design_height, PDO::PARAM_INT);
		$result = $stmt->execute();

		return $result;
	}

	/**
	* Set the new height for the given div. If fixed is value the actual height
	* is set as zero and only the design height is set otherwise both values
	* are set
	*
	* @param integer $site_id
	* @param integer $id Id of the div we are adjusting the height for
	* @param integer $height The new height
	* @param boolean $fixed Is the div a fixed height div
	* @return void
	*/
	public function setHeight($site_id, $id, $height, $fixed=FALSE)
	{
		if($fixed == FALSE) {
			$sql = "UPDATE user_site_template_div_size
					SET design_height = :height,
					height = 0
					WHERE site_id = :site_id
					AND div_id = :div_id
					LIMIT 1";
		} else {
			$sql = "UPDATE user_site_template_div_size
					SET design_height = :height,
					height = :height
					WHERE site_id = :site_id
					AND div_id = :div_id
					LIMIT 1";
		}
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':height', $height, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $id, PDO::PARAM_INT);
		$stmt->execute();
	}

	/**
	* Set the new width for the given div
	*
	* @param integer $site_id
	* @param integer $id Id of the div we are adjusting the width for
	* @param integer $width The new width
	* @return void
	*/
	public function setWidth($site_id, $id, $width)
	{
		$sql = "UPDATE user_site_template_div_size
				SET width = :width
				WHERE site_id = :site_id
				AND div_id = :div_id
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':width', $width, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $id, PDO::PARAM_INT);
		$stmt->execute();
	}

	/**
	* Check to see if the given div is is valid, needs to exists and be part
	* of the given template and site id
	*
	* @param integer $site_id
	* @param integer $template_id
	* @param integer $id
	* @return boolean
	*/
	public function valid($site_id, $template_id, $id)
	{
		$sql = "SELECT id
				FROM user_site_template_div
				WHERE site_id = :site_id
				AND template_id = :template_id
				AND id = :div_id";
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
}