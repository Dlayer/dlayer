<?php
/**
* The content manager page designed class is responsible for fetching all the 
* data requested to generate a content page so it can be passed off to the 
* relevant actions in the designer controller
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Designer_Page
{
	private $site_id;
	private $template_id;
	private $page_id;

	private $selected_div_id = NULL;
	private $selected_content_row_id = NULL;
	private $selected_content_id = NULL;

	private $content_area_styles = array();
	private $content_row_styles = array();
	private $content_container_styles = array();
	private $content_styles = array();
	private $form_styles = array();

	private $model_template;
	private $model_page;

	private $model_content_area_styles;
	private $model_content_row_styles;
	private $model_content_container_styles;
	private $model_content_styles;
	private $model_form_styles;

	/**
	* Initialise the object, run setup methods and set initial properties
	*
	* @param integer $site_id
	* @param integer $template_id
	* @param integer $page_id
	* @param integer|NULL $div_id
	* @param integer|NULL $content_id
	*/
	public function __construct($site_id, $template_id, $page_id, $div_id=NULL,
		$content_row_id=NULL, $content_id=NULL)
	{
		$this->site_id = $site_id;
		$this->template_id = $template_id;
		$this->page_id = $page_id;

		$this->selected_content_id = $div_id;
		$this->selected_content_row_id = $content_row_id;
		$this->selected_content_id = $content_id;

		$this->content_styles = array();
		$this->form_styles = array();

		$this->model_template = new Dlayer_Model_View_Template();
		$this->model_page = new Dlayer_Model_View_Page();
		
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
	}

	/**
	* Fetch the template data array, all the divs that make up the template are
	* pulled and then arranged in a multi dimensional array. The template
	* styles and content rows are attached or added to the divs as the template
	* is created from the array

	* @return array
	*/
	public function template()
	{
		return $this->model_template->template($this->site_id, 
			$this->template_id);
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
	* Fetch all the page content that has been assigned to the selected
	* content poge, the content is indexed by content row id and then assigned
	* as the page is created by the view helpers
	*
	* @return array
	*/
	public function content()
	{
		return $this->model_page->content($this->site_id, $this->page_id);
	}

	/**
	* Fetch all the content rows that have been assigned to the divs that make
	* up this page, these are passed to the page view helper which then calls
	* the content view helper to generate the content items
	*/
	public function contentRows()
	{
		return $this->model_page->contentRows($this->site_id, $this->page_id);
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
	* Fetch all the styles assigned to the content rows that makde up the 
	* page, the styles are grouped by type and then merged
	* 
	* @return Array contents all the defined content row styles grouped by 
	* 	style type and content row id
	*/
	public function contentRowStyles() 
	{
		$this->contentRowBackgroundStyles();
		
		return $this->content_row_styles;
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
}