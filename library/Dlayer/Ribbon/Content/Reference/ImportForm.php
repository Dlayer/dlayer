<?php
/**
* Import form content item data class, returns the data for the tool tab 
* view script
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Ribbon_Content_Reference_ImportForm extends 
Dlayer_Ribbon_Module_Content
{
	/**
	* Data method for the import form tab, returns the form for the view
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param string $tool Name of the selected tool
	* @param string $tab Name of the selected tool tab
	* @param integer $multi_use Multi use value for tool tab
	* @param integer|NULL $content_id Selected content item
	* @param boolean $edit_mode Is the tool tab in edit mode
	* @return array|FALSE
	*/
	public function viewData($site_id, $page_id, $div_id, $tool, $tab, 
		$multi_use, $edit_mode=FALSE, $content_row_id=NULL, $content_id=NULL)
	{
		$this->writeParams($site_id, $page_id, $div_id, $tool, $tab,
			$multi_use, $edit_mode, $content_row_id, $content_id);

		return array('form_id'=>$this->formId());
	}
	
	protected function contentRow() 
	{
		return array();
	}
	
	protected function contentItem()
	{	

	}
	
	/**
	* Return the form id attached to the selected content item
	* 
	* @return integer|FALSE Either the form id attached to the content item 
	* 	or FALSE if unable to fetch the id
	*/
	protected function formId() 
	{
		$model_content_form = new Dlayer_Model_Page_Content_Items_Form();
		
		$form_id = $model_content_form->formId($this->site_id, 
			$this->page_id, $this->content_id);
			
		if($form_id != FALSE) {
			return $form_id;
		} else {
			return FALSE;
		}
	}
}