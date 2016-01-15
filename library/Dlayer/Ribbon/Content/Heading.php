<?php
/**
* Heading content item data class, returns the form for the tool tab view 
* script, populated with the existing content item details if the tool is 
* in edit mode
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Ribbon_Content_Heading extends Dlayer_Ribbon_Module_Content
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

		return array('form'=>new Dlayer_Form_Content_Heading(
			$this->page_id, $this->div_id, $this->content_row_id, 
			$this->contentItem(), $this->edit_mode, $this->multi_use), 
			'preview'=>$this->previewData());
	}

	/**
	* Fetch the data for the selected content block
	*
	* If a content id exists return a data array for the heading otherwise
	* return an array with FALSE for each of the values, we do this so we 
	* can easily default the values at a later point
	*
	* @return array
	*/
	protected function contentItem()
	{
		$data = array('id'=>FALSE, 'name'=>FALSE, 'heading'=>FALSE, 
			'heading_id'=>FALSE);

		if($this->content_id != NULL) {
			$model_heading = new Dlayer_Model_Page_Content_Items_Heading();
			
			$set_data = $model_heading->formData($this->site_id, 
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
			
			$model_heading = new Dlayer_Model_Page_Content_Items_Heading();
			$data = $model_heading->previewData($this->site_id, $this->page_id, 
				$this->content_id);
				
			if($data != FALSE) {
				$heading = array(
					'container_selector'=>'div.content-container-' . 
						$this->content_id, 
					'content_selector'=>'h2.content-' . $this->content_id, 
					'content_selector_sub_heading'=>'h2.content-' . 
						$this->content_id . ' > small', 
					'initial_value'=>$data['heading']
				);
				
				$sub_heading = array(
					'container_selector'=>'div.content-container-' . 
						$this->content_id, 
					'content_selector'=>'h2.content-' . $this->content_id . 
						' > small', 
					'initial_value'=>$data['sub_heading']
				);
				
				$preview_data = array(
					'heading'=>json_encode($heading), 
					'sub_heading'=>json_encode($sub_heading)
				);
			}
		}
		
		return $preview_data;
	}
}