<?php
/**
* Select tool data class, returns the data required to create the select and 
* return links
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Ribbon_Content_Select extends Dlayer_Ribbon_Module_Content
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
			
		$content_data = $this->contentItem();
		
		if($content_data != FALSE) {
			return array(
				'div_id'=>$this->div_id, 
				'content_row_id'=>$this->content_row_id, 
				'content_id'=>$this->content_id, 
				'content_type'=>$content_data['content_type'], 
				'tool'=>$content_data['tool']);
		} else {
			return FALSE;
		}
	}
	
	/** 
	* Fetch the content type and tool for the current content id
	* 
	* @return array
	*/
	protected function contentItem() 
	{
		$model_content = new Dlayer_Model_Page_Content();
		return $model_content->contentTypeAndToolByContentId($this->site_id, 
			$this->page_id, $this->content_id);
			
		
	}
}