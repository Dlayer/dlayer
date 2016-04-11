<?php
/**
* When a tool is selected the ribbon updates to show the options available, 
* there will alwasy be one tab for a tool but there can be many more tabs
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Ribbon
{
	/**
	* Fetch all the tabs for the requested tool, if the tool is in edit mode 
	* additonal tabs can be pulled from the database.
	*
	* @param string $module;
	* @param string $tab
	* @param boolean $edit_mode Is the tool in edit mode, if so additional 
	* 							tabs may be pulled from the database
	* @return array|FALSE FALSE is there are no active tabs for the tool
	*/
	public function tabs($module, $tool, $edit_mode=FALSE)
	{
		$model_ribbon = new Dlayer_Model_Ribbon();
		$tabs = $model_ribbon->tabs($module, $tool, $edit_mode);

		if(count($tabs) > 0) {
			return $tabs;
		} else {
			return FALSE;
		}
	}
	
	/**
	* Get the ribbon tab view script when a tool isn't selected
	*
	* @return string
	*/
	public function viewScriptPath($script)
	{
		return 'design/ribbon/' . $script . '.phtml';
	}
	
	/**
	* Get the view script path for the dynamic view script, this is the
	* container html for the data loaded by the AJAX for each tab
	*
	* @return string
	*/
	public function dynamicViewScriptPath()
	{
		return 'design/ribbon/ribbon-html.phtml';
	}
	
	/**
	* Get the default view script when a tool isn't selected
	*
	* @return string
	*/
	public function defaultViewScriptPath()
	{
		return 'design/ribbon/default.phtml';
	}
	
	/**
	* Get the selected view script, used when a item, container, image, 
	* needs to be selected before showing the majority of the designer toolsm 
	* currently Template designer and Image library
	*
	* @return string
	*/
	public function selectedViewScriptPath()
	{
		return 'design/ribbon/selected.phtml';
	}
}
