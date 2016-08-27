<?php
/**
* Import a form or edit the selected imported form
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Tool_Content_ImportFormOld extends Dlayer_Tool_Module_Content
{
	protected $content_type = 'form';
	protected $minimum_size = 3;
	protected $suggested_maximum_size = 12;
	
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
		if(array_key_exists('form_id', $params) == TRUE) {
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
		
		$model_forms = new Dlayer_Model_Form();
		
		if($model_forms->valid(intval($params['form_id']), $site_id) == TRUE) {			
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
		$prepared = array('form_id'=>intval($params['form_id']));
			
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
		// Calculate size for new item before any addition
		$suggested_size = $this->columnSize($site_id, $page_id, 
			$content_row_id);
		
		$model_content = new Dlayer_Model_Page_Content();
		$content_id = $model_content->addContentItem($site_id, $page_id, 
			$div_id, $content_row_id, $content_type);
			
		$model_size = new Dlayer_Model_Page_Content_Size();
		$model_size->setSizeAndOffset($site_id, $page_id, $content_id, 
			$suggested_size);

		$model_form = new Dlayer_Model_Page_Content_Items_Form();
		$model_form->addContentItemData($site_id, $page_id, $div_id, 
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
