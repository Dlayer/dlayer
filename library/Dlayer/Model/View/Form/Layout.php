<?php
/**
* Layout view model
* 
* Used to fetch all the layout values for the form builder form
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @category View model
*/
class Dlayer_Model_View_Form_Layout extends Zend_Db_Table_Abstract
{
	/**
	* Fetch the title and sub title for the form
	* 
	* @param integer $site_id
	* @param integer $form_id
	* @return array
	*/
	public function titles($site_id, $form_id) 
	{
		$sql = 'SELECT title, sub_title 
				FROM user_site_form_layout 
				WHERE site_id = :site_id 
				AND form_id = :form_id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetch();
	}
}
