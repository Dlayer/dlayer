<?php
/**
* Text content item styling tool tab, returns the form for the view tab view 
* script populated with the current values
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Ribbon_Content_Styling_Text extends 
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

		return array('form'=>new Dlayer_Form_Content_Styling_Text(
			$this->page_id, $this->div_id, $this->content_row_id, 
			$this->contentRow(), $this->contentItem(), $this->edit_mode, 
			$this->multi_use));
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
			'container_background_color'=>FALSE, 
			'item_background_color'=>FALSE
		);
		
		if($this->content_id != NULL) {
			
			$this->containerBackgroundColor();
			$this->itemBackgroundColor();
			
		}

		return $this->data;
	}
	
	/**
	* Fetch the background color for a content container
	* 
	* @retrun void Writes the data directly to $this->data
	*/
	protected function containerBackgroundColor() 
	{
		$model_styling = new Dlayer_Model_Page_Content_Styling();
		
		$color = $model_styling->itemContainerBackgroundColor($this->site_id, 
			$this->page_id, $this->content_id);
			
		if($color != FALSE) {
			$this->data['container_background_color'] = $color;
		}
	}
	
	/**
	* Fetch the background color for a content item
	* 
	* @retrun void Writes the data directly to $this->data
	*/
	protected function itemBackgroundColor() 
	{
		$model_styling = new Dlayer_Model_Page_Content_Styling();
		
		$color = $model_styling->itemBackgroundColor($this->site_id, 
			$this->page_id, $this->content_id);
			
		if($color != FALSE) {
			$this->data['item_background_color'] = $color;
		}
	}
}