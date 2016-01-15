<?php
/**
* Settings view model;
*
* This is used to fetch all the settings for the forms
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
* @category View model
*/
class Dlayer_Model_View_Form_Settings extends Zend_Db_Table_Abstract
{
	/**
	* Fetch the minimum defined width for the requested form
	*
	* @param integer $site_id
	* @param integer $form_id
	* @return integer
	*/
	public function minimumWidth($site_id, $form_id)
	{
		$sql = "SELECT width
				FROM user_site_form_setting
				WHERE site_id = :site_id
				AND form_id = :form_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE) {
			return intval($result['width']);
		} else {
			return Dlayer_Config::FORM_MINIMUM_WIDTH;
		}
	}
}
