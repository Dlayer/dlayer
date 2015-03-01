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

	private $template_styles;
	private $content_row_styles;
	private $content_container_styles;
	private $content_styles;
	private $form_styles;

	private $model_template;
	private $model_template_styles;
	private $model_page;

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

		$this->template_styles = array();
		$this->content_styles = array();
		$this->form_styles = array();

		$this->model_template = new Dlayer_Model_View_Template();
		$this->model_template_styles = new Dlayer_Model_View_Template_Styles();
		$this->model_page = new Dlayer_Model_View_Page();
		
		$this->model_content_container_styles = 
			new Dlayer_Model_View_Content_ContainerStyles();

		//$this->model_content_styles = new Dlayer_Model_View_Content_Styles();
		//$this->model_form_styles = new Dlayer_Model_View_Content_Styles_Forms();
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
	* Fetch any styles that have been attached to the template dics, all the
	* assigned styles groups for the template are pulled and then passed to
	* the page view helper as one single array
	*
	* @return array Indexed array of styles
	*/
	/*public function templateStyles()
	{
		$this->templateBackgroundColorStyles();

		$this->borderStyles();

		return $this->template_styles;
	}*/

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
	* Fetch all the background coolour styles that have been assigned to the
	* selected template and then pass them to the template styles property,
	* if there are no background styles nothing is assigned to the template
	* styles property
	*
	* The id of the currently selected div needs to be passed into the model
	* method because we need to ensure that an assigned background colour
	* doesn't override the selected status of a div
	*
	* @return void Writes the data to the styles array if values exist
	*/
	/*private function templateBackgroundColorStyles()
	{
		$styles = $this->model_template_styles->backgroundColors(
			$this->site_id,$this->template_id, $this->div_id);

		if($styles != FALSE) {
			$this->template_styles['background_colors'] = $styles;
		}
	}*/

	/**
	* Fetch all the background color styles for the content items and assign
	* the data to the styles array, if there are no styles we dont assign
	* any data to the array
	*
	* The id of any currently selected content item needs to be passed in
	* because it will be excluded from the query, don't want to override the
	* selected content item background color
	*
	* @return void Writes the data to the styles array if values exist
	*/
	/*private function contentBackgroundColorStyles()
	{
		$styles = $this->model_content_styles->backgroundColors($this->site_id,
			$this->page_id, $this->content_id);

		if($styles != FALSE) {
			$this->content_styles['background_colors'] = $styles;
		}
	}*/

	/**
	* Fetch all the margin values for the content items and assign the data to
	* the styles array, if there are no margins we don't assign any data to the
	* styles array
	*
	* @todo At the moment the margin values are pulled indivually, obviously
	* this is incorrect if all the margin values are the same
	*
	* @return void Writes the data to the styles array if values exist
	*/
	/*private function contentMargins()
	{
		$margins = $this->model_content_styles->margins($this->site_id,
			$this->page_id);

		if($margins != FALSE) {
			$this->content_styles['margins'] = $margins;
		}
	}*/

	/**
	* Fetch all the border styles for the template and assign the
	* data to the styles array, if there are no styles we dont assign anything
	* to the array
	*
	* @return void Writes the data to the styles array if values exist
	*/
	/*private function borderStyles()
	{
		$styles = $this->model_template_styles->borders($this->site_id,
			$this->template_id);

		if($styles != FALSE) {
			$this->template_styles['borders'] = $styles;
		}
	}*/

	/**
	* Fetch all the additional styles assigned to the content items on the
	* page, each style group pulled individually and then grouped and passed
	* to the designer page class
	*
	* @return array Indexed array of styles
	*/
	/*public function contentStyles()
	{
		$this->contentBackgroundColorStyles();

		$this->contentMargins();

		return $this->content_styles;
	}*/

	/**
	* Fetch all the styles defined for the imported forms, array will be
	* indexed by form id with a sub array indexed by field id containing all
	* the individual styles
	*
	* @return array
	*/
	/*public function formFieldStyles()
	{
		return $this->model_form_styles->fieldStyles($this->site_id,
			$this->page_id);
	}*/
	
	/**
	* Fetch all the styles assigned to the content item containers attached 
	* to this page, the styles are grouped by type and then merged
	* 
	* @return array Array contains all the defined content iten container 
	* 	styles grouped by style type and then content item id
	*/
	public function contentContainerStyles() 
	{
		return array();
	}
	
	/**
	* Fetch all the background colour styles defined for the content item 
	* containers that make up the current page
	* 
	* @return array Array of defined styles indexed by content id
	*/
	private function contentContainerBackgroundStyles() 
	{
		return array();
	}
}