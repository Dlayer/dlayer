<?php
/**
* Styles object for a page, fetches all the styling data to be passed off to 
* the view
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Designer_Styles_Page
{
	private $site_id;
	private $page_id;

	private $content_area_styles;
	private $content_row_styles;
	private $content_container_styles;
	private $content_styles;
	private $form_styles;

	private $model_content_area_styles;
	private $model_content_row_styles;
	private $model_content_container_styles;
	private $model_content_styles;
	private $model_form_styles;
	private $model_settings;

	/**
	* Initialise the object, run setup methods and set initial properties
	*
	* @param integer $site_id
	* @param integer $page_id
	*/
	public function __construct($site_id, $page_id)
	{
		$this->site_id = $site_id;
		$this->page_id = $page_id;
		
		$this->content_area_styles = array();
		$this->content_row_styles = array();
		$this->content_container_styles = array();
		$this->content_styles = array();
		$this->form_styles = array();
		
		$this->model_content_area_styles = 
			new Dlayer_Model_View_Content_AreaStyles();
		$this->model_content_row_styles = 
			new Dlayer_Model_View_Content_RowStyles();
		$this->model_content_container_styles = 
			new Dlayer_Model_View_Content_ContainerStyles();
		$this->model_content_styles = 
			new Dlayer_Model_View_Content_ItemStyles();
		$this->model_form_styles = 
			new Dlayer_Model_View_Content_Styles_Forms();
		$this->model_settings = 
			new Dlayer_Model_View_Settings();
	}
	
	/**
	* Fetch the styles for all the assigned forms
	* 
	* @return array Array contains the styles for all the forms assigned to the 
	* 	content page
	*/
	public function formStyles() 
	{
		return $this->model_form_styles->fieldStyles($this->site_id, 
			$this->page_id);
	}
	
	/**
	* Fetch all the styles assigned to the content item attached to this page, 
	* the styles are grouped by type and then merged
	* 
	* @return array Array contains all the defined content iten styles 
	* 	grouped by style type and then content item id
	*/
	public function contentItemStyles() 
	{
		$this->contentItemBackgroundStyles();
		
		return $this->content_styles;
	}
	
	/**
	* Fetch all the styles assigned to the content item containers attached 
	* to this page, the styles are grouped by type and then merged
	* 
	* @return array Array contains all the defined content iten container 
	* 	styles grouped by style type and then content item id
	*/
	public function contentContainerStyles() 
	{
		$this->contentContainerBackgroundStyles();
		
		return $this->content_container_styles;
	}
	
	/**
	* Fetch all the styles assigned to the content rows that make up the 
	* page, the styles are grouped by type and then merged
	* 
	* @return Array contains all the defined content row styles grouped by 
	* 	style type and content row id
	*/
	public function contentRowStyles() 
	{
		$this->contentRowBackgroundStyles();
		
		return $this->content_row_styles;
	}
	
	/**
	* Fetch all the styles assign to the content areas that make up the 
	* current content page, the styles are grouped by type and then merged into 
	* once base array
	* 
	* @return Array contains all the defined content area styles groupled by 
	* 	style group and then content area id
	*/
	public function contentAreaStyles() 
	{
		$this->contentAreaBackgroundStyles();
		
		return $this->content_area_styles;
	}
	
	/**
	* Fetch all the background colour styles defined for the content item 
	* containers that make up the current page
	* 
	* @return void Writes the data to the $content_container_styles private 
	* 	property
	*/
	private function contentContainerBackgroundStyles() 
	{
		$styles = $this->model_content_container_styles->backgroundColors(
			$this->site_id, $this->page_id);
			
		if($styles != FALSE) {
			$this->content_container_styles['background_colors'] = $styles;
		}
	}
	
	/**
	* Fetch all the background colour styles defined for the content items 
	* that make up the current page
	* 
	* @return void Writes the data to the $content_styles private property
	*/
	private function contentItemBackgroundStyles() 
	{
		$styles = $this->model_content_styles->backgroundColors(
			$this->site_id, $this->page_id);
			
		if($styles != FALSE) {
			$this->content_styles['background_colors'] = $styles;
		}
	}
	
	/**
	* Fetch all the background colour styles defined for the content rows that 
	* make up the current page
	* 
	* @return void Writes the data to the $content_row_styles private property
	*/
	private function contentRowBackgroundStyles() 
	{
		$styles = $this->model_content_row_styles->backgroundColors(
			$this->site_id, $this->page_id);
			
		if($styles != FALSE) {
			$this->content_row_styles['background_colors'] = $styles;
		}
	}
	
	/**
	* Fetch all the background colour styles defined for the content areas 
	* that make up the page
	* 
	* @return void Writes the data to the $content_area_styles private property
	*/
	private function contentAreaBackgroundStyles() 
	{
		$styles = $this->model_content_area_styles->backgroundColors(
			$this->site_id, $this->page_id);
			
		if($styles != FALSE) {
			$this->content_area_styles['background_colors'] = $styles;
		}
	}
}