<?php
/**
* Move a content item from one row to another
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Tool_Content_MoveItem extends Dlayer_Tool_Module_Content
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
		$valid = FALSE;
		
		if(array_key_exists('new_content_row_id', $params) == TRUE && 
			array_key_exists('content_id', $params) == TRUE) {
			$valid = TRUE;
		}
		
		return $valid;
	}

	/**
	* Check to ensure that all the submitted data is valid, it has to be of 
	* the expected format or within an expected range
	* 
	* @todo Needs to include a check to make sure content id is valid
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
		$model_page_content = new Dlayer_Model_Page_Content();
		
		if(intval($params['new_content_row_id']) != 0 && 
			intval($params['content_id']) != 0 && 
			$model_page_content->validContentRowIdSansDiv($site_id, $page_id, 
				$params['new_content_row_id']) == TRUE) {
				
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
		return array(
			'content_row_id'=>intval($params['new_content_row_id']), 
			'content_id'=>intval($params['content_id'])
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
	* Move the content row to another content area
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
		$model_page_content = new Dlayer_Model_Page_Content();
		
		$new_div_id = $model_page_content->setContentItemParent($site_id, 
			$page_id, $div_id, $content_row_id, 
			$this->params_auto['content_row_id'], 
			$this->params_auto['content_id']);
			
		$content_type = $model_page_content->contentTypeByContentId($site_id, 
			$page_id, $this->params_auto['content_id']);
			
		/**
		* Only return the array to set environment properties if the div id 
		* can be selected for the new content row and the content type is 
		* returned for the content id
		*/
		if($new_div_id != FALSE && $content_type != FALSE) {
			return array(
				array(
					'type'=>'div_id', 
					'id'=>$new_div_id
				), 
				array(
					'type'=>'content_row_id', 
					'id'=>$this->params_auto['content_row_id']
				),
				array(
					'type'=>'content_id', 
					'id'=>$this->params_auto['content_id'], 
					'content_type'=>$content_type
				),
			);
		} else {
			return array();
		}
	}
}