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

		return array('form'=>new Dlayer_Form_Content_Text(
			$this->page_id, $this->div_id, $this->content_row_id, 
			$this->contentItem(), $this->edit_mode, $this->multi_use), 
			'preview'=>$this->previewData());
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
	
	/**
	* Fetch the data required by the live preview functions when the tool is 
	* in edit mode
	* 
	* @return array|FALSE
	*/
	protected function previewData() 
	{
		$preview_data = FALSE;
		
		if($this->edit_mode == TRUE) {
			
			$model_text = new Dlayer_Model_Page_Content_Items_Text();
			$data = $model_text->previewData($this->site_id, $this->page_id, 
				$this->content_id);
				
			if($data != FALSE) {
				$preview_data = array();
				
				$preview_data['container_selector'] = 
					'div.content-container-' . $this->content_id;
				$preview_data['content_selector'] = 'p.content-' . 
					$this->content_id;
				$preview_data['initial_value'] = $data['text'];
			}
			
			$preview_data = json_encode($preview_data);
		}
		
		return $preview_data;
	}
}