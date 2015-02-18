<?php
/**
* Base abstract class for the content module tools. All tool classes need
* to define the abstract methods of this class and the Dlayer_Tool class
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
abstract class Dlayer_Tool_Module_Content extends Dlayer_Tool
{
	protected $content_type;

	/**
	* Process the request for a manual tool, for example add or edit a content
	* item
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
	* Process the request for an auto tool, for example add a new content row
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
			$content_row_id = $this->structure($site_id, $page_id, $div_id);
			
			return array(
				array('type'=>'div_id', 'id'=>$div_id), 
				array('type'=>'content_row_id', 'id'=>$content_row_id)
			);
		}
	}

	/**
	* Prepare the data for the process method. Converts all the data to the 
	* correct content types once the two validation functions have been 
	* run
	*
	* @param array $params
	* @return array Prepared data array
	*/
	abstract protected function prepare(array $params);

	/**
	* Check to see if the posted data is correct, first we check that all 
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
					
			$this->params = $this->prepare($params, $content_id);
			$this->validated = TRUE;
					
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	* Check to see that the posted values are valid, calls a method to 
	* validate the posted param fields and then the values
	*
	* @param array $params
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer|NULL $content_row_id
	* @return boolean TRUE if validation passed for both tests
	*/
	public function autoValidate(array $params, $site_id, $page_id, $div_id, 
		$content_row_id=NULL) 
	{
		if($this->validateFields($params) == TRUE && 
			$this->validateValues($site_id, $page_id, $div_id, 
				$content_row_id, $params, NULL) == TRUE) {
			
			$this->params_auto = $this->prepare($params);
			$this->validated_auto = TRUE;
			
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	* Add a new value into the color history table
	* 
	* @param integer $site_id
	* @param string $color_hex
	*/
	protected function addToColorHistory($site_id, $color_hex) 
	{
		$model_palettes = new Dlayer_Model_Palette();
		$model_palettes->addToHistory($site_id, $color_hex);
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
	abstract protected function validateFields(array $params=array(), 
		$content_id=NULL);
		
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
	abstract protected function validateValues($site_id, $page_id, $div_id, 
		$content_row_id=NULL, array $params=array(), $content_id=NULL);
}