<?php
/**
* Import form content item data class, returns the form for the tool tab 
* view script populated with the existing content item details if the tool is 
* in edit mode
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Ribbon_Content_ImportForm extends Dlayer_Ribbon_Module_Content
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

		return array('form'=>new Dlayer_Form_Content_ImportForm(
			$this->page_id, $this->div_id, $this->content_row_id, 
			$this->contentItem(), $this->edit_mode, $this->multi_use));
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
		$data = array('id'=>FALSE, 'form_id'=>FALSE);
		
		if($this->content_id != NULL) {
			$model_form = new Dlayer_Model_Page_Content_Items_Form();
			
			$set_data = $model_form->formData($this->site_id, 
				$this->page_id, $this->div_id, $this->content_row_id, 
				$this->content_id);

			if($set_data != FALSE) {
				$data = $set_data;
			}
		}

		return $data;
	}
}