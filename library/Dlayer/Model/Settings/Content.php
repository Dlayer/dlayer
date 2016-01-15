<?php
/**
* Content manager module settings.
*
* Manages all the data for the content manager settings
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Model_Settings_Content extends Zend_Db_Table_Abstract
{
	/**
	* Fetch the heading values for the requested site, returns the saved
	* heading settings for the requestd site
	*
	* @todo Need to insert default values if none exists for the site_id or
	*       modify create site to insert initial values
	* @param integer $site_id
	* @return array
	*/
	public function headings($site_id)
	{
		$sql = "SELECT dch.id, dch.`name`, ush.style_id, ush.weight_id,
				ush.decoration_id, ush.size, ush.color_hex
				FROM user_setting_heading ush
				JOIN designer_content_heading dch ON ush.heading_id = dch.id
				WHERE ush.site_id = :site_id
				ORDER BY dch.sort_order ASC";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetchAll();

		$rows = array();

		foreach($result as $row) {
			$rows[$row['id']] = $row;
		}

		return $rows;
	}

	/**
	* Fetch the currently set base font for the content module
	*
	* @todo Need to insert default values if none exists for the site_id or
	*       modify create site to insert initial values, Modify the @return
	*       when we check for FALSE and return the default array
	* @param integer $site_id
	* @return array|FALSE
	*/
	public function baseFontFamily($site_id)
	{
		$sql = "SELECT dcff.id, dcff.css, dcff.`name`
				FROM user_setting_font_family usff
				JOIN dlayer_module dm ON usff.module_id = dm.id
				AND dm.enabled = 1
				JOIN designer_css_font_family dcff
				ON usff.font_family_id = dcff.id
				WHERE usff.site_id = :site_id
				AND dm.`name` = :module";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':module', 'content', PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->fetch();
	}

	/**
	* Update the settings for the headings
	*
	* @param integer $site_id
	* @param array $values
	* @return void
	*/
	public function updateHeadings($site_id, array $values)
	{
		$sql = "UPDATE user_setting_heading
				SET style_id = :style, weight_id = :weight,
				decoration_id = :decoration, size = :size,
				color_hex = :color_hex
				WHERE site_id = :site_id
				AND heading_id = :heading_id
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':style', $values['style'], PDO::PARAM_INT);
		$stmt->bindValue(':weight', $values['weight'], PDO::PARAM_INT);
		$stmt->bindValue(':decoration', $values['decoration'], PDO::PARAM_INT);
		$stmt->bindValue(':size', $values['size'], PDO::PARAM_INT);
		$stmt->bindValue(':color_hex', $values['color_hex'], PDO::PARAM_INT);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':heading_id', $values['heading_id'], PDO::PARAM_INT);
		$stmt->execute();
	}

	/**
	* Update the font family for supplied site in the content manager
	*
	* @param integer $site_id
	* @param integer $font_family_id
	* @return void
	*/
	public function updateFontFamily($site_id, $font_family_id)
	{
		$sql = "UPDATE user_setting_font_family
				SET font_family_id = :font_family_id
				WHERE site_id = :site_id
				AND module_id = (SELECT id FROM dlayer_module
				WHERE `name` = :module)
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':module', 'content', PDO::PARAM_STR);
		$stmt->bindValue(':font_family_id', $font_family_id, PDO::PARAM_INT);
		$stmt->execute();
	}
}