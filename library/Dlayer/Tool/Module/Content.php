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
	* Process the request for the manual tools, these are generally to add a 
	* new content item or to edit a content item
	* 
	* @param integer $site_id
	* @param integer $page_id 
	* @param integer $div_id
	* @param integer $content_row_id
	* @param integer|NULL $content_id 
	* @return integer Id of the content item either created or being edited
	*/
	abstract public function process($site_id, $page_id, $div_id,
		$content_row_id, $content_id=NULL);

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
	abstract public function autoProcess($site_id, $page_id, $div_id, 
		$content_row_id=NULL);

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
	* Validate the posted values, run before the process method is called. 
	* If the result of the validation is TRUE, the internal validated property 
	* is set to TRUE and all the params are passed to the prepare method
	*
	* @param array $params
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @return boolean
	*/
	abstract public function validate(array $params, $site_id, $page_id, 
		$div_id, $content_row_id);

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
	abstract public function autoValidate(array $params, $site_id, $page_id, 
		$div_id, $content_row_id=NULL);

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
}