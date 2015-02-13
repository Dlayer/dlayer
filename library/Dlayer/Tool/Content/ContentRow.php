<?php
/**
* Add a new content row to a content area, new content row is added after all 
* existing content rows
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Tool_Content_ContentRow extends Dlayer_Tool_Module_Content
{
	/**
	* Not used by this tool
	* 
	* @param integer $site_id
	* @param integer $page_id 
	* @param integer $div_id
	* @param integer $content_row_id
	* @param integer|NULL $content_id 
	* @return integer Id of the content item either created or being edited
	*/
	public function process($site_id, $page_id, $div_id, $content_row_id, 
		$content_id=NULL)
	{
		// Not used by this tool
	}

	/**
	* Not used by this tool
	*
	* @param array $params
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @return boolean
	*/
	public function validate(array $params, $site_id, $page_id, $div_id, 
		$content_row_id)
	{
		// Not used by this tool
	}

	/**
	* Check to see that the posted values are valid, in this case the site_id, 
	* div_id and page idm no other values need to be posted for the tool
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
		if($this->validateValues($params) == TRUE && 
			$this->validateData($params, $site_id, $page_id, $div_id) == TRUE) {
			
			$this->params_auto = $this->prepare($params);
			$this->validated_auto = TRUE;
			
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	* Add the new content row, gets placed after any existing content rows in 
	* the selected content area
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id 
	* @param integer|NULL $content_row_id
	* @param integer|NULL $content_id
	* @return array|void Multiple ids can be returned, reset will be called 
	* 	first and then array values set
	*/
	public function autoProcess($site_id, $page_id, $div_id, 
		$content_row_id=NULL) 
	{
		if($this->validated_auto == TRUE) {
			$content_row_id = $this->addContentRow($site_id, $page_id, $div_id);
			
			return array(
				array('type'=>'div_id', 'id'=>$div_id), 
				array('type'=>'content_row_id', 'id'=>$content_row_id)
			);
		}
	}

	/**
	* Check to ensure that the required values have been posted in the params 
	* array. Check the data exists fiorst and then another methods checks the 
	* data itself
	*
	* @param array $params $_POSTed params data array
	* @return boolean TRUE if the required values are in array
	*/
	private function validateValues(array $params = array())
	{
		// No additional data to validate
		return TRUE;
	}

	/**
	* Check that the submitted data is of the correct format
	*
	* @param array $params Params array to validte
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @return boolean TRUE if the values are valid
	*/
	private function validateData(array $params = array(), $site_id, $page_id,
		$div_id)
	{
		// No additional data to validate
		return TRUE;
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
		return array();
	}
	
	/**
	* Add a new content row to the page div id, gets added after any existing 
	* content rows
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id 
	* @return integer Id of the newly created content row
	*/
	private function addContentRow($site_id, $page_id, $div_id) 
	{
		$model_content = new Dlayer_Model_Page_Content();
		
		return $model_content->addContentRow($site_id, $page_id, $div_id);
	}
}