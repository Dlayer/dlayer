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
			$this->contentItem(), $this->edit_mode, $this->multi_use));
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
			'version_id'=>FALSE, 
			'expand'=>FALSE, 
			'caption'=>FALSE);
		
		/*if($this->content_id != NULL) {
			$model_form = new Dlayer_Model_Page_Content_Items_Form();
			
			$set_data = $model_form->formData($this->site_id, 
				$this->page_id, $this->div_id, $this->content_row_id, 
				$this->content_id);

			if($set_data != FALSE) {
				$data = $set_data;
			}
		}*/

		return $data;
	}
}