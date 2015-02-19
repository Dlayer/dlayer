<?php
/**
* Add or edit a text content item
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Tool_Content_Text extends Dlayer_Tool_Module_Content
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
		if(array_key_exists('name', $params) == TRUE && 
		array_key_exists('text', $params) == TRUE) {
			
			if($content_id == NULL) {
				return TRUE;
			} else {
				if(array_key_exists('instances', $params) == TRUE) {
					return TRUE;
				} else {
					return FALSE;
				}
			}
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
		
		if(strlen(trim($params['name'])) > 0 && 
			strlen(trim($params['text'])) > 0) {
			
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
			'name'=>trim($params['name']),
			'text'=>trim($params['text']));
			
		if($content_id != NULL) {
			if($params['instances'] == 1) {
				$prepared['instances'] = TRUE;
			} else {
				$prepared['instances'] = FALSE;
			}
		}

		return $prepared;
	}
	
	/**
	* Add a new text content item
	* 
	* A new content item is created in the content items table and then the 
	* specific data to create the text item is added to the text item sub 
	* tables
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @param string $content_type
	* @return integer The id of the newly created content item
	*/
	protected function addContentItem($site_id, $page_id, $div_id, 
		$content_row_id, $content_type)
	{
		$model_content = new Dlayer_Model_Page_Content();
		$content_id = $model_content->addContentItem($site_id, $page_id, 
			$div_id, $content_row_id, $content_type);

		$model_text = new Dlayer_Model_Page_Content_Items_Text();
		$model_text->addContentItemData($site_id, $page_id, $div_id, 
			$content_row_id, $content_id, $this->params);

		return $content_id;
	}

	/**
	* Edit the data for the selected content item, there is no need to edit the 
	* base item definition data, only the data specific to the text content 
	* type
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @param integer $content_id
	* @return void 
	*/
	protected function editContentItem($site_id, $page_id, $div_id, 
		$content_row_id, $content_id)
	{
		$model_text = new Dlayer_Model_Page_Content_Items_Text();
		$model_text->editContentItemData($site_id, $page_id, $content_id, 
		$this->params);
	}
}