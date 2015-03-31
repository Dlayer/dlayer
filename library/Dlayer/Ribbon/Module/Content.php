<?php
/**
* The ribbon classes return all the data required to generate the view 
* for the selected tool and tab. Some of the classes are very simple, some are 
* much more complicated, by extending this bae abstract class we ensure some 
* consistency as the complexity of the application grows.
* 
* Ribbon models only have one public method, viewData() this should return 
* ewither an array containing the required data or FALSE is there is no data,
* the format of the data depends on both the requested tool and the requested
* tool tab, all we require is an array or FALSE, the view script works out
* what it needs to do with the array
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
abstract class Dlayer_Ribbon_Module_Content
{
	protected $site_id;
	protected $page_id;
	protected $div_id;
	protected $tool;
	protected $tab;
	protected $multi_use;
	protected $edit_mode;
	protected $content_row_id;
	protected $content_id;

	/**
	* Data method foe the content manager tools, returns the data required 
	* by the view
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param string $tool 
	* @param string $tab 
	* @param integer $multi_use 
	* @param boolean $edit_mode
	* @param integer|NULL $content_row_id
	* @param integer|NULL $content_id 
	* @return array|FALSE Either a data array for the tool tab view script or 
	* 	FALSE if no data is required
	*/
	abstract public function viewData($site_id, $page_id, $div_id, $tool, 
		$tab, $multi_use, $edit_mode=FALSE, $content_row_id=NULL, 
		$content_id=NULL);

	/**
	* Take the supplied params and write their values to the internal 
	* properties
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param string $tool 
	* @param string $tab 
	* @param integer $multi_use 
	* @param boolean $edit_mode
	* @param integer|NULL $content_row_id
	* @param integer|NULL $content_id 
	* @return void
	*/
	protected function writeParams($site_id, $page_id, $div_id, $tool, $tab, 
		$multi_use, $edit_mode, $content_row_id, $content_id)
	{
		$this->site_id = $site_id;
		$this->page_id = $page_id;
		$this->div_id = $div_id;
		$this->tool = $tool;
		$this->tab = $tab;
		$this->multi_use = $multi_use;
		$this->edit_mode = $edit_mode;
		$this->content_row_id = $content_row_id;
		$this->content_id = $content_id;
	}

	/**
	* Fetch the data for the content item, the array will either have the 
	* values for the content item if in edit mode or just the keys with 
	* FALSE as the valkue if the tool is in add mode
	*
	* @return array
	*/
	abstract protected function contentItem();
}
