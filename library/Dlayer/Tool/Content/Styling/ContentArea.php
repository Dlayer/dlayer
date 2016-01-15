<?php
/**
* Set the styling values for the content area
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Tool_Content_Styling_ContentArea extends Dlayer_Tool_Module_Content
{
	/**
	* Check that all the required values have been posted as part of the 
	* params array. Another method will be called after this to ensure that 
	* the values are of the correct type, no point doing the more complex 
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
		
		if(array_key_exists('area_background_color', $params) == TRUE) {
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
	* @param array $params Params array to validate
	* @param integer|NULL $content_id
	* @return boolean Returns TRUE if all the values are of the expected size 
	* 	or within range
	*/
	protected function validateValues($site_id, $page_id, $div_id, 
		$content_row_id=NULL, array $params=array(), $content_id=NULL)
	{
		$valid = FALSE;
		
		if(Dlayer_Validate::colorHex(
			$params['area_background_color'], TRUE) == TRUE) {
				
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
		$prepared = array(
			'area_clear_background'=>FALSE,
			'area_background_color'=>FALSE
		);
		
		if(strlen(trim($params['area_background_color'])) == 0) {
			$prepared['area_clear_background'] = TRUE;
		} else {
			$prepared['area_background_color'] = 
				trim($params['area_background_color']);
		}
		
		return $prepared;
	}
	
	/**
	* Update the styling values for the selected content area
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
		$this->areaBackgroundColor($site_id, $page_id, $div_id);
		
		return array(
			array('type'=>'div_id', 'id'=>$div_id), 
			array('type'=>'tool', 'id'=>'content-area'),
			array('type'=>'tab', 'id'=>'styling')
		);
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
	* Update or set the area background colour for the selected content area
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id Content area id
	* @return void
	*/
	protected function areaBackgroundColor($site_id, $page_id, $div_id) 
	{
		$model_styling = new Dlayer_Model_Page_Content_Styling();
		
		$id = $model_styling->existingAreaBackgroundColor($site_id, $page_id, 
			$div_id);

		if($id == FALSE) {
			if($this->params_auto['area_clear_background'] == FALSE) {
				$model_styling->addAreaBackgroundColor($site_id, $page_id, 
					$div_id, $this->params_auto['area_background_color']);
					
				$this->addToColorHistory($site_id, 
					$this->params_auto['area_background_color']);
			}
		} else {
			if($this->params_auto['area_clear_background'] == FALSE) {
				$model_styling->updateAreaBackgroundColor($site_id, $page_id, 
					$div_id, $id, $this->params_auto['area_background_color']);
					
				$this->addToColorHistory($site_id, 
					$this->params_auto['area_background_color']);
			} else {
				$model_styling->clearAreaBackgroundColor($site_id, $page_id, 
					$div_id, $id);
			}
		}
	}
}