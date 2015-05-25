<?php
/**
* Insert image content item data class, returns the form for the tool tab 
* view script populated with the existing content details if the tool is in 
* edit mode. Also returns any addition params that may be required by the 
* view script, for example the preview functions.
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Ribbon_Content_Image extends Dlayer_Ribbon_Module_Content
{
	/**
	* Data method for the insert image tab, returns the form for the view 
	* script
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

		return array('form'=>new Dlayer_Form_Content_Image(
			$this->page_id, $this->div_id, $this->content_row_id, 
			$this->contentItem(), $this->edit_mode, $this->multi_use), 
			'selected_image'=>$this->selectedImage());
	}
	
	/**
	* Fetch the data for the selected content item if in edit mode, always 
	* return an array
	* 
	* If a content id exists we return a data array containing all the 
	* currently set values, if the content id is null an array is returned 
	* with all the values set to FALSE. 
	* 
	* It is simpler to always know the structure of the array, this for exmaple
	* makes it very simple to set default values based on the environment
	*
	* @return array
	*/
	protected function contentItem()
	{	
		$data = array(
			'id'=>FALSE, 			
			'expand'=>FALSE, 
			'caption'=>FALSE, 
			'version_id'=>FALSE
		);
			
		if($this->content_id != NULL) {
			$model_image = new Dlayer_Model_Page_Content_Items_Image();
			
			$set_date = $model_image->formData($this->site_id, 
				$this->page_id, $this->div_id, $this->content_row_id, 
				$this->content_id);
				
			if($set_date != FALSE) {
				$data = $set_date;
			}
		}

		return $data;
	}
	
	/**
	* Fetch the currently selected image for the picker, used to set the 
	* selected state.
	* 
	* Checks to see if the session has valid values and if so uses those 
	* otherwise it fetches the values for the currently selected content 
	* item
	* 
	* @return array|FALSE
	*/
	protected function selectedImage() 
	{
		$data = FALSE;
		
		$model_image = new Dlayer_Model_Page_Content_Items_Image();
		
		$session_designer = new Dlayer_Session_Designer();
		
		if($session_designer->imagePickerCategoryId() !== NULL && 
			$session_designer->imagePickerSubCategoryId() !== NULL && 
			$session_designer->imagePickerImageId() !== NULL && 
			$session_designer->imagePickerVersionId() !== NULL) {
				
			$model_image = new Dlayer_Model_Page_Content_Items_Image();
			
			$image = $model_image->sessionImage($this->site_id, $this->page_id, 
				$this->content_id);
			
			if($image != FALSE) {
				$data = array(
					'image_id'=>$image['image_id'], 
					'version_id'=>$image['version_id'], 
					'name'=>$image['name'],
					'dimensions'=>$image['dimensions'],
					'size'=>$image['size'], 
					'extension'=>$image['extension']
				);
			}
				
		} else {
			if($this->content_id != NULL) {
				$model_image = new Dlayer_Model_Page_Content_Items_Image();
				
				$image = $model_image->selectedImage($this->site_id, 
					$this->page_id, $this->content_id);
				
				if($image != FALSE) {
					$data = array(
						'image_id'=>$image['image_id'], 
						'version_id'=>$image['version_id'], 
						'name'=>$image['name'],
						'dimensions'=>$image['dimensions'],
						'size'=>$image['size'], 
						'extension'=>$image['extension']
					);
				}
			}
		}
		
		return $data;
	}
}