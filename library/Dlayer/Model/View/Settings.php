<?php
/**
* Settings view model
*
* This is used to fetch all the settings for the designers
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
* @category View model
*/
class Dlayer_Model_View_Settings extends Zend_Db_Table_Abstract
{
	/**
	* Fetch the heading styles for the requested site, these values
	* will be used to generate the inline css for the heading tags
	*
	* @param integer $site_id
	* @return array Array of styles values
	*/
	public function headingStyles($site_id)
	{
		$sql = "SELECT dch.tag, dcts.css AS style, dctw.css AS weight,
				dctd.css AS decoration, ush.size, ush.color_hex AS color
				FROM user_setting_heading ush
				JOIN designer_content_heading dch ON ush.heading_id = dch.id
				JOIN designer_css_text_style dcts ON ush.style_id = dcts.id
				JOIN designer_css_text_weight dctw ON ush.weight_id = dctw.id
				JOIN designer_css_text_decoration dctd ON ush.decoration_id = dctd.id
				WHERE ush.site_id = :site_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll();
	}

	/**
	* Fetch the base font family setting, this will be passed to the designer
	* to set the base inline style for all text based content
	*
	* @param integer $site_id
	* @param string $module
	* @return string Font family If for some reason the font family cannot be
	*                            be pulled Helvetica is returned as a default
	*/
	public function baseFontFamily($site_id, $module)
	{
		$sql = "SELECT 
                    `dcff`.`css` AS `font_family`
				FROM 
				    `user_setting_font_and_text` `usfat`
				JOIN 
				    `dlayer_module` `dm` ON 
				        `usfat`.`module_id` = `dm`.`id`
				JOIN 
				    `designer_css_font_family` `dcff` ON 
				        `usfat`.`font_family_id` = `dcff`.`id`
				WHERE 
				    `usfat`.`site_id` = :site_id
				AND 
				    `dm`.`name` = :module";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':module', $module, PDO::PARAM_STR);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE) {
			return $result['font_family'];
		} else {
			return 'Helvetica, Arial, "Nimbus Sans L", sans-serif';
		}
	}
}
