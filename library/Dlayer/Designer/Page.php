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

	private $model_template;
	private $model_page;

	/**
	* Initialise the object, run setup methods and set initial properties
	*
	* @param integer $site_id
	* @param integer $template_id
	* @param integer $page_id
	*/
	public function __construct($site_id, $template_id, $page_id)
	{
		$this->site_id = $site_id;
		$this->template_id = $template_id;
		$this->page_id = $page_id;

		$this->model_template = new Dlayer_Model_View_Template();
		$this->model_page = new Dlayer_Model_View_Page();
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
}