<?php
/**
* Layout view model
* 
* Used to fetch all the layout values for the form builder form
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
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
	
	/**
	* Fetch the button values for the form
	* 
	* @param integer $site_id
	* @param integer $form_id
	* @return array
	*/
	public function buttons($site_id, $form_id) 
	{
		$sql = 'SELECT submit_label, reset_label 
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
	
	/**
	* Layout options
	* 
	* @param integer $site_id 
	* @param integer $form_id
	* @return array
	*/
	public function layout($site_id, $form_id) 
	{
		$sql = 'SELECT dfl.class, usfl.horizontal_width_label, 
				usfl.horizontal_width_field 
				FROM user_site_form_layout usfl 
				JOIN designer_form_layout dfl 
					ON usfl.layout_id = dfl.id 
				WHERE usfl.site_id = :site_id 
				AND usfl.form_id = :form_id';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetch();
	}
}
