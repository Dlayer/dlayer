<?php
/**
* Set the style options for the text item and text item container
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Tool_Content_Styling_Text extends Dlayer_Tool_Module_Content
{
	protected $content_type = 'text';

	/**
	* Check that all the required values have been posted as part of the 
	* params array. Another method will be called after this to ensure that 
	* the values are of the correct type, no point doing the mnore complex 
	* validation if the required values aren't provided
	* 
	* @param array $params 
	* @param integer|NULL $content_id
	* @return boolean Returns TRUE if all the expected values have been posted 
	* 	as part of the request
	*/
	protected function validateFields(array $params=array(), $content_id=NULL)
	{
		if(array_key_exists('background_color', $params) == TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	* Check to ensure that all the submitted data is valid, it has to be of 
	* the expected format or within an expected range
	* 
	* @param array $params Params array to validte
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer|NULL $content_row_id
	* @param array $params Params array to validte
	* @param integer|NULL $content_id
	* @return boolean Returns TRUE if all the values are of the expected size 
	* 	twpe and within range
	*/
	protected function validateValues($site_id, $page_id, $div_id, 
		$content_row_id=NULL, array $params=array(), $content_id=NULL)
	{
		$valid = FALSE;
		
		if(strlen(trim($params['background_color'])) == 0 || 
			Dlayer_Validate::colorHex($params['background_color']) == TRUE) {
				
			$valid = TRUE;
		}
		
		return $valid;
	}

	/**
	* Prepare the submitted data by converting the values into the correct 
	* data types for the tool
	*
	* @param array $params
	* @param integer|NULL $content_id
	* @return array THe prepared data array
	*/
	protected function prepare(array $params, $content_id=NULL)
	{
		$prepared = array(
			'clear_background'=>FALSE, 
			'background_color'=>FALSE,
		);
		
		if(strlen(trim($params['background_color'])) == 0) {
			$prepared['clear_background'] = TRUE;
		} else {
			$prepared['background_color'] = trim($params['background_color']);
		}

		return $prepared;
	}
	
	protected function addContentItem($site_id, $page_id, $div_id, 
		$content_row_id, $content_type)
	{
		 
	}

	/**
	* Update the size and positon values for the selected text content item
	* 		
	* @param mixed $site_id
	* @param mixed $page_id
	* @param mixed $div_id
	* @param mixed $content_row_id
	* @param mixed $content_id
	* @return void
	*/
	protected function editContentItem($site_id, $page_id, $div_id, 
		$content_row_id, $content_id)
	{
		$this->backgroundColor($site_id, $page_id, $div_id, $content_row_id, 
			$content_id);
	}
		
	protected function structure($site_id, $page_id, $div_id)
	{
		
	}
	
	/**
	* Update or set the background styling value for the selected content item
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @param integer $content_id
	* @return void
	*/
	protected function backgroundColor($site_id, $page_id, $div_id, 
		$content_row_id, $content_id) 
	{
		$model_styling = new Dlayer_Model_Page_Content_Styling();
		
		$id = $model_styling->existingItemContainerBackgroundColor($site_id, 
			$page_id, $content_id);
			
		if($id == FALSE) {
			if($this->params['clear_background'] == FALSE) {
				$model_styling->addItemContainerBackgroundColor($site_id, 
					$page_id, $content_id, $this->params['background_color']);
			}
		} else {
			if($this->params['clear_background'] == FALSE) {
				$model_styling->updateItemContainerBackgroundColor($site_id, 
					$page_id, $content_id, $id, 
					$this->params['background_color']);
			} else {
				$model_styling->clearItemContainerBackgroundColor($site_id, 
					$page_id, $content_id, $id);
			}
		}
	}
}