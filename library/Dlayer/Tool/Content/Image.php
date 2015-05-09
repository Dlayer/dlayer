<?php
/**
* Insert an image or edit the selected image
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Tool_Content_Image extends Dlayer_Tool_Module_Content
{
	protected $content_type = 'form';
	protected $minimum_size = 1;
	
	/**
	* Check that all the required values have been posted as part of the 
	* params array. Another method will be called after this to ensure that 
	* the values are of the correct type, no point doing the mnore complex 
	* validation if the required values aren't provided
	* 
	* Checks to ensure that the version id (image) field is set and the 
	* expand option
	* 
	* @param array $params 
	* @param integer|NULL $content_id
	* @return boolean Returns TRUE if all the expected values have been posted 
	* 	as part of the request
	*/
	protected function validateFields(array $params=array(), $content_id=NULL)
	{
		if(array_key_exists('version_id', $params) == TRUE && 
			array_key_exists('expand', $params) == TRUE) {
			
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	* Check to ensure that all the submitted data is valid, it has to be of 
	* the expected format or within an expected range
	* 
	* The supplied version id needs to be a valid id from the users image 
	* library and the expand option needs to be either 1 or 0
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
		
		$model_image_library = new Dlayer_Model_Image_Library();
		
		if($model_image_library->valid($site_id, 
			intval($params['version_id'])) == TRUE && 
			in_array($params['expand'], array(1, 0)) == TRUE) {
				
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
			'version_id'=>intval($params['version_id']), 
			'expand'=>intval($params['expand'])
		);
			
		return $prepared;
	}

	/**
	* Add a new image content item
	* 
	* A new content is created in the content items data table and the 
	* specific data to create the image content item is added to the 
	* image item sub table
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
		// Calculate size for new item before any addition
		$suggested_size = $this->columnSize($site_id, $page_id, 
			$content_row_id);
		
		$model_content = new Dlayer_Model_Page_Content();
		$content_id = $model_content->addContentItem($site_id, $page_id, 
			$div_id, $content_row_id, $content_type);
			
		$model_size = new Dlayer_Model_Page_Content_Size();
		$model_size->setSizeAndOffset($site_id, $page_id, $content_id, 
			$suggested_size);

		$model_image = new Dlayer_Model_Page_Content_Items_Image();
		$model_image->addContentItemData($site_id, $page_id, $div_id, 
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
		$model_form = new Dlayer_Model_Page_Content_Items_Form();
		$model_form->editContentItemData($site_id, $page_id, $div_id, 
			$content_row_id, $content_id, $this->params);
	}
	
	protected function structure($site_id, $page_id, $div_id, 
		$content_row_id=NULL) 
	{
		
	}
}