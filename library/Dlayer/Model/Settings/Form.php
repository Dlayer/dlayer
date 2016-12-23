<?php
/**
* Form builder module settings
*
* Manages all the data for the form builder settings
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Model_Settings_Form extends Zend_Db_Table_Abstract
{
	/**
	* Fetch the currently set base font for the fomr builder module
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
				FROM user_setting_font_and_text usff
				JOIN dlayer_module dm ON usff.module_id = dm.id
				AND dm.enabled = 1
				JOIN designer_css_font_family dcff
				ON usff.font_family_id = dcff.id
				WHERE usff.site_id = :site_id
				AND dm.`name` = :module";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':module', 'form', PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->fetch();
	}

	/**
	* Update the font family for supplied site in the form builder
	*
	* @param integer $site_id
	* @param integer $font_family_id
	* @return void
	*/
	public function updateFontFamily($site_id, $font_family_id)
	{
		$sql = "UPDATE 
                    `user_setting_font_and_text`
				SET 
				    `font_family_id` = :font_family_id
				WHERE 
				    `site_id` = :site_id AND 
				    `module_id` = (
				        SELECT 
				            `id` 
                        FROM 
                            `dlayer_module`
                        WHERE 
                            `name` = :module
                        )
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':module', 'form', PDO::PARAM_STR);
		$stmt->bindValue(':font_family_id', $font_family_id, PDO::PARAM_INT);
		$stmt->execute();
	}
}
