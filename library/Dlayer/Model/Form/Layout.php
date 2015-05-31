<?php
/**
* Form layout model
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @category Model
*/
class Dlayer_Model_Form_Layout extends Zend_Db_Table_Abstract
{
	/**
	* Save the titles for the form
	* 
	* @param integer $site_id 
	* @param integer $form_id
	* @param string $title
	* @param string $sub_title
	* @return void
	*/
	public function saveTitles($site_id, $form_id, $title, 
		$sub_title='') 
	{
		$existing = $this->titles($site_id, $form_id);
		
		if($title . ':' . $sub_title !== $existing) {
			$sql = 'UPDATE user_site_form_layout 
					SET title = :title, sub_title = :sub_title 
					WHERE site_id = :site_id 
					AND form_id = :form_id 
					LIMIT 1';
			$stmt = $this->_db->prepare($sql);
			$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
			$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
			$stmt->bindValue(':title', $title, PDO::PARAM_STR);
			$stmt->bindValue(':sub_title', $sub_title, PDO::PARAM_STR);
			$stmt->execute();
		}
	}
	
	/**
	* Save the button labels for the form
	* 
	* @param integer $site_id 
	* @param integer $form_id
	* @param string $submit_label
	* @param string $reset_label
	* @return void
	*/
	public function saveButtonLabels($site_id, $form_id, $submit_label, 
		$reset_label='') 
	{
		$existing = $this->buttonLabels($site_id, $form_id);
		
		if($submit_label . ':' . $reset_label !== $existing) {
			$sql = 'UPDATE user_site_form_layout 
					SET submit_label = :submit_label, 
					reset_label = :reset_label 
					WHERE site_id = :site_id 
					AND form_id = :form_id 
					LIMIT 1';
			$stmt = $this->_db->prepare($sql);
			$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
			$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
			$stmt->bindValue(':submit_label', $submit_label, PDO::PARAM_STR);
			$stmt->bindValue(':reset_label', $reset_label, PDO::PARAM_STR);
			$stmt->execute();
		}
	}	
	
	/**
	* Fetch the existing title and sub title, we only update the values if 
	* they differ to the current values
	* 
	* @param integer $site_id 
	* @param integer $form_id
	* @return string Concatenated title and sub title 'title-:-sub_title'
	*/
	private function titles($site_id, $form_id) 
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
		
		$result = $stmt->fetch();
		
		return $result['title'] . ':' . $result['sub_title'];
	}
	
	/**
	* fetch the existing layout values, we only update the values if they 
	* differ to the current values
	* 
	* @param integer $site_id 
	* @param integer $form_id
	* @return string Concatenated layout values
	*/
	private function layout($site_id, $form_id) 
	{
		$sql = 'SELECT layout_id, horizontal_width_label, horizontal_width_field 
				FROM user_site_form_layout 
				WHERE site_id = :site_id 
				AND form_id = :form_id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		return $result['layout_id'] . ':' . $result['horizontal_width_label'] . 
			':' . $result['horizontal_width_field'];
	}
	
	/**
	* Fetch the existing button text
	* 
	* @param integer $site_id 
	* @param integer $form_id
	* @return string Concatenated submit and reset button text
	*/
	private function buttonLabels($site_id, $form_id) 
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
		
		$result = $stmt->fetch();
		
		return $result['submit_label'] . ':' . $result['reset_label'];
	}
	
	/**
	* Save the new layout values
	* 
	* @param integer $layout_id
	* @param integer $horizontal_width_label
	* @param integer $horizontal_width_field
	* @return void
	*/
	public function saveLayout($site_id, $form_id, $layout_id, 
		$horizontal_width_label, $horizontal_width_field) 
	{
		$existing = $this->layout($site_id, $form_id);
		
		if($existing !== $layout_id . ':' . $horizontal_width_label . ':' . 
			$horizontal_width_field) {
		
			$sql = 'UPDATE user_site_form_layout 
					SET layout_id = :layout_id, 
					horizontal_width_label = :horizontal_width_label, 
					horizontal_width_field = :horizontal_width_field 
					WHERE site_id = :site_id 
					AND form_id = :form_id 
					LIMIT 1';
			$stmt = $this->_db->prepare($sql);
			$stmt->bindValue(':layout_id', $layout_id, PDO::PARAM_INT);
			$stmt->bindValue(':horizontal_width_label', $horizontal_width_label, 
				PDO::PARAM_INT);
			$stmt->bindValue(':horizontal_width_field', $horizontal_width_field, 
				PDO::PARAM_INT);
			$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
			$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
			$stmt->execute();
		}
	}
	
	/**
	* Add the default values for a form
	* 
	* @param integer $site_id
	* @param integer $form_id
	* @param string $title
	* @param string $sub_title
	* @param string $submit_label
	* @param string $reset_label
	* @param integer $layout_id
	* @param integer $horizontal_width_label
	* @param integer $horizontal_width_field
	* @return void
	*/
	public function setDefaults($site_id, $form_id, $title, $sub_title, 
		$submit_label, $reset_label, $layout_id, $horizontal_width_label, 
		$horizontal_width_field) 
	{
		$sql = 'INSERT INTO user_site_form_layout  
				(site_id, form_id, title, sub_title, submit_label, reset_label, 
				layout_id, horizontal_width_label, horizontal_width_field) 
				VALUES 
				(:site_id, :form_id, :title, :sub_title, :submit_label, 
				:reset_label, :layout_id, :horizontal_width_label, 
				:horizontal_width_field)';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
		$stmt->bindValue(':title', $title, PDO::PARAM_STR);
		$stmt->bindValue(':sub_title', $sub_title, PDO::PARAM_STR);
		$stmt->bindValue(':submit_label', $submit_label, PDO::PARAM_STR);
		$stmt->bindValue(':reset_label', $reset_label, PDO::PARAM_STR);
		$stmt->bindValue(':layout_id', $layout_id, PDO::PARAM_INT);
		$stmt->bindValue(':horizontal_width_label', $horizontal_width_label, 
			PDO::PARAM_INT);
		$stmt->bindValue(':horizontal_width_field', $horizontal_width_field, 
			PDO::PARAM_INT);
		$stmt->execute();
	}
	
	/**
	* Fetch the current layout values for the tool
	* 
	* @param integer $site_id
	* @param integer $form_id
	* @return array|FALSE Either returns the curret values or FALSE if not able 
	* 	to select anything from the database
	*/
	public function currentValues($site_id, $form_id) 
	{
		$sql = 'SELECT title, sub_title, submit_label, reset_label, 
				layout_id, horizontal_width_label, horizontal_width_field 
				FROM user_site_form_layout 
				WHERE site_id = :site_id 
				AND form_id = :form_id';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':form_id', $form_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			return $result;
		} else {
			$this->setDefaults($site_id, $form_id, 
				Dlayer_Config::FORM_DEFAULT_TITLE, 
				Dlayer_Config::FORM_DEFAULT_SUB_TITLE, 
				Dlayer_Config::FORM_DEFAULT_SUBMIT_LABEL, 
				Dlayer_Config::FORM_DEFAULT_RESET_LABEL, 
				Dlayer_Config::FORM_DEFAULT_LAYOUT_ID, 
				Dlayer_Config::FORM_DEFAULT_HORIZONTAL_WIDTH_LABEL,
				Dlayer_Config::FORM_DEFAULT_HORIZONTAL_WIDTH_FIELD);
			
			return FALSE;
		}
	}
	
	/**
	* Fetch the layout options from the database
	* 
	* @return array Returns a simple array, index and layout type
	*/
	public function layoutOptions() 
	{
		$sql = 'SELECT id, layout 
				FROM designer_form_layout 
				ORDER BY id ASC';
		$stmt = $this->_db->prepare($sql);
		$stmt->execute();
		
		return Dlayer_Helper::convertToSimpleArray($stmt->fetchAll(), 'id', 
			'layout');
	}	
}