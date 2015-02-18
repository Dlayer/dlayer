<?php
/**
* Text content item data class, returns the form for the tool tab view script 
* populated with the existing content item details if the tool is in edit mode
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Ribbon_Content_Text extends Dlayer_Ribbon_Module_Content
{
	/**
	* Data method for the tool tab, returns the form and any data required 
	* to generate the preview functions
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param string $tool 
	* @param string $tab 
	* @param integer $multi_use 
	* @param boolean $edit_mode
	* @param integer|NULL $content_row_id
	* @param integer|NULL $content_id 
	* @return array|FALSE Either a data array for the tool tab view script or 
	* 	FALSE if no data is required
	*/
	public function viewData($site_id, $page_id, $div_id, $tool, $tab, 
		$multi_use, $edit_mode=FALSE, $content_row_id=NULL, $content_id=NULL)
	{
		$this->writeParams($site_id, $page_id, $div_id, $tool, $tab,
			$multi_use, $edit_mode, $content_row_id, $content_id);

		return array('form'=>new Dlayer_Form_Content_Text($this->page_id,
			$this->div_id, $this->content_row_id, $this->contentRow(), 
			$this->contentItem(), $this->edit_mode, $this->multi_use));
	}
	
	protected function contentRow() 
	{
		return array();
	}

	/**
	* Fetch the data for the selected content block
	*
	* If a content id exists return a data array for the text item otherwise
	* return an array with FALSE for each of the values, we do this so we 
	* can easily default the values at a later point
	*
	* @return array
	*/
	protected function contentItem()
	{	
		$data = array('id'=>FALSE, 'name'=>FALSE, 'text'=>FALSE);

		if($this->content_id != NULL) {
			$model_text = new Dlayer_Model_Page_Content_Items_Text();
			
			$set_data = $model_text->formData($this->site_id, 
				$this->page_id, $this->div_id, $this->content_row_id, 
				$this->content_id);

			if($set_data != FALSE) {
				$data = $set_data;
			}
		}

		return $data;
	}
}