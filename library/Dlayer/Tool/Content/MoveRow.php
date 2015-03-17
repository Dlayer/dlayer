<?php
/**
* Move the selected content row from one area to another
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
		
		if(array_key_exists('content_area_id', $params) == TRUE) {
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
		$model_page = new Dlayer_Model_Page();
		
		if(intval($params['content_area_id']) != 0 && 
			$model_page->divValid($params['content_area_id'], 
				$page_id) == TRUE) {
				
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
		return array('content_area_id'=>intval($params['content_area_id']));
	}
	
	/**
	* Add a new content row to the page div id, gets added after any existing 
	* content rows
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
		$model_content = new Dlayer_Model_Page_Content();
		
		$model_content->setContentRowParent($site_id, $page_id, $div_id, 
			$this->params_auto['content_area_id'], $content_row_id);
			
		return array(
			array('type'=>'div_id', 'id'=>$this->params_auto['content_area_id']), 
			array('type'=>'content_row_id', 'id'=>$content_row_id)
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
}