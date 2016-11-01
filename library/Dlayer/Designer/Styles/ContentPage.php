<?php

/**
 * The page styles object fetches the styling data for all the structural
 * page items and then all the content items, this data will be passed to the
 * view eher an army of style view helpers generate the style strings for each
 * content item.
 *
 * When dlayer is futher along development wise this object can be replaced with
 * another object which will generate the classes to be used so that as few
 * inline styles can be used as possible.
 *
 * @todo This needs to be reworked
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Designer_Styles_ContentPage
{
	private $site_id;
	private $page_id;

	private $row_styles;

	private $content_container_styles;
	private $content_styles;
	private $form_styles;

	private $model_settings;

	private $model_row_styles;

	private $model_content_container_styles;
	private $model_content_styles;
	private $model_form_styles;

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

		$this->content_row_styles = array();
		$this->content_container_styles = array();
		$this->content_styles = array();
		$this->form_styles = array();

		$this->model_settings = new Dlayer_Model_View_Settings();
		$this->model_row_styles = new Dlayer_Model_View_Style_Row();


		$this->model_content_container_styles = new Dlayer_Model_View_Content_ContainerStyles();
		$this->model_content_styles = new Dlayer_Model_View_Content_ItemStyles();
		$this->model_form_styles = new Dlayer_Model_View_Content_Styles_Forms();
	}

	/**
	 * Fetch the styles for all the assigned forms
	 *
	 * @return array Array contains the styles for all the forms assigned to the
	 *    content page
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
	 *    grouped by style type and then content item id
	 */
	public function contentItemStyles()
	{
		$this->contentItemBackgroundStyles();

		return $this->content_styles;
	}

	/**
	 * Fetch all the styles assigned to the content rows that make up the
	 * page, the styles are grouped by type and then merged
	 *
	 * @return Array contains all the defined content row styles grouped by
	 *    style type and content row id
	 */
	public function rowStyles()
	{
		$this->rowBackgroundStyles();

		return $this->row_styles;
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

		if($styles != FALSE)
		{
			$this->content_styles['background_colors'] = $styles;
		}
	}

	/**
	 * Fetch all the background colour styles defined for the content rows that
	 * make up the current page
	 *
	 * @return void Writes the data to the $content_row_styles private property
	 */
	private function rowBackgroundStyles()
	{
		$styles = $this->model_row_styles->backgroundColors($this->site_id, $this->page_id);

		if($styles != FALSE)
		{
			$this->row_styles['background_colors'] = $styles;
		}
	}

	/**
	 * Fetch the heading styles defined in settings
	 *
	 * @return array
	 */
	public function headingStyles()
	{
		return $this->model_settings->headingStyles($this->site_id);
	}

	/**
	 * Fetch the base font familty for the content manager
	 *
	 * @return string
	 */
	public function baseFontFamilyContentManager()
	{
		return $this->model_settings->baseFontFamily($this->site_id, 'content');
	}

	/**
	 * Fetch the base font family for the Form builder, used for the imported
	 * forms
	 *
	 * @return string
	 */
	public function baseFontFamilyFormBuilder()
	{
		return $this->model_settings->baseFontFamily($this->site_id, 'form');
	}
}
