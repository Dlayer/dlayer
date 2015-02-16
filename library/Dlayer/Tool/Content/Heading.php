<?php
/**
* Add or edit a heading content item
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Tool_Content_Heading extends Dlayer_Tool_Module_Content
{
	protected $content_type = 'heading';

	/**
	* Add a new heading content item or edit a selected one, a heading content 
	* item is simply a string of text , the heading styling to use and an 
	* optional sub heading
	* 
	* This method processes the request based on the value of 
	* $this->validated, the data will have been previously validated and 
	* prepared before this method was called
	*
	* @param integer $site_id
	* @param integer $page_id 
	* @param integer $div_id
	* @param integer $content_row_id
	* @param integer|NULL $content_id 
	* @return integer Either the id for the newly created content item or the 
	* 	id of the content item being edited
	*/
	public function process($site_id, $page_id, $div_id, $content_row_id, 
		$content_id=NULL)
	{
		if($this->validated == TRUE) {
			if($content_id == NULL) {
				$content_id = $this->addContentItem($site_id, $page_id, 
					$div_id, $content_row_id, $this->content_type);
			} else {
				$this->editContentItem($site_id, $page_id, $div_id, 
					$content_row_id, $content_id);
			}

			return $content_id;
		}
	}

	/**
	* Check to see if the posted data us correct, first we check that all 
	* the expected params are in the array and secondly that the values 
	* themselves are valid format
	* 
	* If the data is valid it is passed to the prepared method to convert the 
	* data to the correct types and then saved to $this->params array ready for 
	* the process method
	*
	* @param array $params
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @param integer|NULL $content_id 
	* @return boolean
	*/
	public function validate(array $params, $site_id, $page_id, $div_id, 
		$content_row_id, $content_id=NULL)
	{
		if($this->validateFields($params, $content_id) == TRUE && 
			$this->validateValues($site_id, $page_id, $div_id, 
				$content_row_id, $params, $content_id) == TRUE) {
					
			$this->params = $this->prepare($params);
			$this->validated = TRUE;
					
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	* Validate the posted values, run before the process method is called. 
	* If the result of the validation is TRUE, the internal validated property 
	* is set to TRUE and all the params are passed to the prepare method
	*
	* @param array $params
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer|NULL $content_row_id
	* @return boolean
	*/
	public function autoValidate(array $params, $site_id, $page_id, $div_id, 
		$content_row_id=NULL) 
	{
		// Not used by this class
	}

	/**
	* Process the request for an auto tool, these generally manage the 
	* structure of a page, content row id not always defined
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id 
	* @param integer|NULL $content_row_id
	* @param integer|NULL $content_id
	* @return array Multiple ids can be returned, reset will be called first 
	* 	and then array values set
	*/
	public function autoProcess($site_id, $page_id, $div_id, 
		$content_row_id=NULL) 
	{
		// Not used by this class
	}

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
	private function validateFields(array $params=array(), $content_id=NULL)
	{
		if(array_key_exists('name', $params) == TRUE && 
		array_key_exists('heading', $params) == TRUE &&
		array_key_exists('heading_type', $params) == TRUE) {
			
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
	* @param integer $content_row_id
	* @param array $params Params array to validte
	* @param integer|NULL $content_id
	* @return boolean Returns TRUE if all the values are of the expected size 
	* 	twpe and within range
	*/
	private function validateValues($site_id, $page_id, $div_id, 
		$content_row_id, array $params=array(), $content_id=NULL)
	{
		$valid = FALSE;
		$model_settings = new Dlayer_Model_Settings();
		
		if(strlen(trim($params['name'])) > 0 && 
			strlen(trim($params['heading'])) > 0 && 
			$model_settings->headingTypeIdValid(
				$params['heading_type']) == TRUE) {
			
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
			'heading'=>trim($params['heading']),
			'name'=>trim($params['name']),
			'heading_type'=>intval($params['heading_type']));
			
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
	* Add a new heading content item.
	* 
	* A new content item is created in the content items table and then the 
	* specific data to create the heading item is added to the heading sub 
	* tables
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @param string $content_type
	* @return integer The id of the newly created content item
	*/
	private function addContentItem($site_id, $page_id, $div_id, 
		$content_row_id, $content_type)
	{
		$model_content = new Dlayer_Model_Page_Content();
		$content_id = $model_content->addContentItem($site_id, $page_id, 
			$div_id, $content_row_id, $content_type);

		$model_heading = new Dlayer_Model_Page_Content_Items_Heading();
		$model_heading->addContentItemData($site_id, $page_id, $div_id, 
			$content_row_id, $content_id, $this->params);

		return $content_id;
	}

	/**
	* Edit the existing heading, just need to edit the heading data, no need
	* to edit the base content heading data
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id
	* @return void
	*/
	private function editContentItem($site_id, $page_id, $content_id)
	{
		$model_headiing = new Dlayer_Model_Page_Content_Items_Heading();
		$model_headiing->editContentItemData($site_id, $page_id, $content_id,
			$this->params);
	}
}