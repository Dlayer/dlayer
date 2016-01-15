<?php
/**
* Content row styling tool tab, returns the form for the view tab view script
*  populated with the current values
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Ribbon_Content_Styling_ContentRow extends 
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

		return array('form'=>new Dlayer_Form_Content_Styling_ContentRow(
			$this->page_id, $this->div_id, $this->content_row_id, 
			$this->contentItem(), $this->edit_mode, $this->multi_use));
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
			'row_background_color'=>FALSE
		);
		
		
		$this->rowBackgroundColor();

		return $this->data;
	}
	
	/**
	* Fetch the background colour for the content row
	* 
	* @retrun void Writes the data directly to $this->data
	*/
	protected function rowBackgroundColor() 
	{
		$model_styling = new Dlayer_Model_Page_Content_Styling();
		
		$color = $model_styling->rowBackgroundColor($this->site_id, 
			$this->page_id, $this->content_row_id);
			
		if($color != FALSE) {
			$this->data['row_background_color'] = $color;
		}
	}
}