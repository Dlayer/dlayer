<?php
/**
* Generic ribbon styles model, used tp pull all the styles data required to
* generate the ribbon views and forms, this could be base data for the select
* menus or specific styling data for the requested div or template
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Model_Ribbon_Styles extends Zend_Db_Table_Abstract
{
	/**
	* Fetch the border style options for the select menus
	*
	* @param boolean $no_border Show the no border options
	* @return array
	*/
	public function borderStyles($no_border=TRUE)
	{
		$sql = "SELECT `name`, style
		FROM designer_css_border_style ";
		if($no_border == FALSE) {
			$sql .= "WHERE style != 'none' ";
		}
		$sql .= "ORDER BY sort_order ASC";
		$stmt = $this->_db->prepare($sql);
		$stmt->execute();

		$result = $stmt->fetchAll();

		$rows = array();

		foreach($result as $row) {
			$rows[$row['style']] = $row['name'];
		}

		return $rows;
	}

	/**
	* Fetch the borders that are assigned to the selected element, result array
	* is indexed by border position
	*
	* @return array Array of assigned borders indexed by border position
	*/
	public function assignedBorders($site_id, $template_id, $div_id)
	{
		$sql = "SELECT ustdb.div_id, ustdb.position, ustdb.style, ustdb.width,
				ustdb.color_hex
				FROM user_site_template_div_border ustdb
				WHERE ustdb.site_id = :site_id
				AND ustdb.template_id = :template_id
				AND ustdb.div_id = :div_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetchAll();

		if(count($result) > 0) {
			$borders = array();
			foreach($result as $row) {
				$borders[$row['position']] = array('style'=>$row['style'],
					'width'=>intval($row['width']), 'color_hex'=>$row['color_hex']);
			}
			return $borders;
		} else {
			return array();
		}
	}

	/**
	* Fetch all the border values for the requested template
	*
	* @param integer $site_id
	* @param integer $template_id
	* @return array
	*/
	public function borderWidths($site_id, $template_id)
	{
		$border_widths = array();

		$sql = "SELECT ustdb.div_id, ustdb.width,
				CASE ustdb.position
				WHEN 'top' THEN 'height'
				WHEN 'right' THEN 'width'
				WHEN 'bottom' THEN 'height'
				WHEN 'left' THEN 'width'
				END AS size
				FROM user_site_template_div_border ustdb
				WHERE ustdb.site_id = :site_id
				AND ustdb.template_id = :template_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetchAll();

		foreach($result as $row) {
			if(array_key_exists($row['div_id'],
			$border_widths) == FALSE) {
				$border_widths[$row['div_id']] = array('width'=>0, 'height'=>0);
			}

			$border_widths[$row['div_id']][$row['size']] += $row['width'];
		}

		return $border_widths;
	}
}