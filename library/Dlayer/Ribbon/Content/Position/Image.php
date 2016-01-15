<?php
/**
* Image content item size and position tool tab, returns the form for the view 
* tab script populated with the current values
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Ribbon_Content_Position_Image extends 
Dlayer_Ribbon_Module_Content
{
	private $data;
	
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

		return array('form'=>new Dlayer_Form_Content_Position_Image(
			$this->page_id, $this->div_id, $this->content_row_id, 
			$this->contentItem(), $this->edit_mode, $this->multi_use), 
			'preview'=>$this->previewData());
	}
	
	/**
	* Fetch the data for the selected content item
	* 
	* Returns the currently set sizing and position values if they exists or 
	* an empty array if there are no existing values
	* 
	* @return array
	*/
	protected function contentItem()
	{
		$this->data = array(
			'id'=>$this->content_id, 
			'size'=>FALSE, 
			'offset'=>FALSE);

		if($this->content_id != NULL) {
			
			$this->sizeAndOffset();
		}

		return $this->data;
	}
	
	/**
	* Fetch the size and offset data for the current content item
	* 
	* @retyurn void Writes any returned data to the $this->data array
	*/
	protected function sizeAndOffset() 
	{
		$model_size = new Dlayer_Model_Page_Content_Size();
			
		$data = $model_size->sizeAndOffset($this->site_id, $this->page_id, 
			$this->content_id);

		if($data != FALSE) {
			$this->data['size'] = $data['size'];
			$this->data['offset'] = $data['offset'];
		}
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
			$preview_data = array('content_id' => $this->content_id);
		}
		
		return $preview_data;
	}
}