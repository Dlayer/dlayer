<?php
/**
* Set the styling values for the content row
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Tool_Content_MoveRow extends Dlayer_Tool_Module_Content
{
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
		$valid = FALSE;
		
		if(array_key_exists('row_background_color', $params) == TRUE) {
			$valid = TRUE;
		}
		
		return $valid;
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
	* 	or within range
	*/
	protected function validateValues($site_id, $page_id, $div_id, 
		$content_row_id=NULL, array $params=array(), $content_id=NULL)
	{
		$valid = FALSE;
		
		if(Dlayer_Validate::colorHex(
			$params['row_background_color'], TRUE) == TRUE) {
				
			$valid = TRUE;
		}
		
		return $valid;
	}

	/**
	* Prepare the data for the process method. Converts all the data to the 
	* correct content types once the two validation functions have been 
	* run
	*
	* @param array $params
	* @return array Prepared data array
	*/
	protected function prepare(array $params) 
	{
		return array(
			'row_clear_background'=>FALSE,
			'row_background_color'=>FALSE
		);
		
		if(strlen(trim($params['row_background_color'])) == 0) {
			$prepared['row_clear_background'] = TRUE;
		} else {
			$prepared['row_background_color'] = 
				trim($params['row_background_color']);
		}
	}
	
	/**
	* Update the styling values for the selected content row
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id 
	* @param integer|NULL $content_row_id
	* @return array Return an array of the ids that you would like to be set 
	* 	after the request has processed
	*/
	protected function structure($site_id, $page_id, $div_id, 
		$content_row_id=NULL) 
	{
		$this->rowBackgroundColor($site_id, $page_id, $div_id, $content_row_id);
	}

	protected function addContentItem($site_id, $page_id, $div_id, 
		$content_row_id, $content_type) 
	{
			
	}

	protected function editContentItem($site_id, $page_id, $div_id, 
		$content_row_id, $content_id)
	{
		
	}
	
	/**
	* Update or set the row background colour for the selected content row
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @return void
	*/
	protected function containerBackgroundColor($site_id, $page_id, $div_id, 
		$content_row_id) 
	{
		$model_styling = new Dlayer_Model_Page_Content_Styling();
		
		$id = $model_styling->existingRowBackgroundColor($site_id, $page_id, 
			$content_row_id);
			
		if($id == FALSE) {
			if($this->params['row_clear_background'] == FALSE) {
				$model_styling->addRowBackgroundColor($site_id, $page_id, 
					$content_row_id, $this->params['row_background_color']);
					
				$this->addToColorHistory($site_id, 
					$this->params['row_background_color']);
			}
		} else {
			if($this->params['row_clear_background'] == FALSE) {
				$model_styling->updateRowBackgroundColor($site_id, $page_id, 
					$content_row_id, $id, 
					$this->params['row_background_color']);
					
				$this->addToColorHistory($site_id, 
					$this->params['row_background_color']);
			} else {
				$model_styling->clearRowBackgroundColor($site_id, $page_id, 
					$content_row_id, $id);
			}
		}
	}
}