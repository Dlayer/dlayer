<?php
/**
* The ribbon data class pulls all the data that is required for the 
* requested tool and tool tab. This could be the data to help build the 
* forms or data about the selected item or element. This class is similar for 
* each module, differences only being the params required to generate the data.
* 
* This class hands off all the data calls to sub classes, it just acts as the 
* interface
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Ribbon_Data_Content 
{
	private $site_id;
	private $page_id;
	private $div_id;
	private $tool;
	private $tab;
	private $multi_use;
	private $edit_mode;
	private $content_row_id;
	private $content_id;

	/**
	* Fetches all the data that is needed by the tool tab views to generate 
	* the html and forms
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
	* @return array|FALSE Either returns the data array for the requested 
	* 	tool tab or FALSE if there is no data required fopr the tool and tab
	*/
	public function viewData($site_id, $page_id, $div_id, $tool, $tab, 
		$multi_use, $edit_mode=FALSE, $content_row_id=NULL, $content_id=NULL) 
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

		switch($this->tool) {
			case 'heading':
				$data = $this->heading();
				break;

			case 'text':
				$data = $this->text();
				break;

			case 'import-form':
				$data = $this->importForm();
				break;

			case 'import-text':
				$data = $this->importText();
				break;

			case 'import-heading':
				$data = $this->importHeading();
				break;

			default:
				$data = FALSE;
				break;
		}

		return $data;
	}

	/**
	* Fetch the view tab data for the heading tool, in this case the form for 
	* the ribbon. If there is any existing data the form will show the current 
	* values
	* 
	* @return array|FALSE 
	*/
	private function heading() 
	{
		switch($this->tab) {
			case 'heading':
				$ribbon_heading = new Dlayer_Ribbon_Content_Heading();
				
				$data = $ribbon_heading->viewData($this->site_id, 
					$this->page_id, $this->div_id, $this->tool, $this->tab, 
					$this->multi_use, $this->edit_mode, $this->content_row_id, 
					$this->content_id);
				break;

			case 'styling':            
				$ribbon_styling = new Dlayer_Ribbon_Content_Styling_Heading();
				$data = $ribbon_styling->viewData($this->site_id, 
					$this->page_id, $this->div_id, $this->tool, $this->tab, 
					$this->multi_use, $this->content_id, $this->edit_mode);
				break;

			case 'position':            
				$ribbon_position = new Dlayer_Ribbon_Content_Position_Heading();
				$data = $ribbon_position->viewData($this->site_id, 
					$this->page_id, $this->div_id, $this->tool, $this->tab, 
					$this->multi_use, $this->content_id, $this->edit_mode);
				break;

			default:
				$data = FALSE;
				break;
		}

		return $data;
	}

	/**
	* Fetch the view tab data for the text tool, in this case the form for 
	* the ribbon. If there is any existing data the form will show the current 
	* values
	* 
	* @return array|FALSE 
	*/
	private function text() 
	{
		switch($this->tab) {
			case 'text':
				$ribbon_text = new Dlayer_Ribbon_Content_Text();
				$data = $ribbon_text->viewData($this->site_id, 
					$this->page_id, $this->div_id, $this->tool, $this->tab, 
					$this->multi_use, $this->edit_mode, $this->content_row_id, 
					$this->content_id);
				break;

			case 'styling':            
				$ribbon_styling = new Dlayer_Ribbon_Content_Styling_Text();
				$data = $ribbon_styling->viewData($this->site_id, 
					$this->page_id, $this->div_id, $this->tool, $this->tab, 
					$this->multi_use, $this->content_id, $this->edit_mode);
				break;

			case 'position':            
				$ribbon_position = new Dlayer_Ribbon_Content_Position_Text();
				$data = $ribbon_position->viewData($this->site_id, 
					$this->page_id, $this->div_id, $this->tool, $this->tab, 
					$this->multi_use, $this->content_id, $this->edit_mode);
				break;

			default:
				$data = FALSE;
				break;
		}

		return $data;
	}

	/**
	* Fetch the view tab data for the import text tool, typically the data 
	* array will contain the form for the view
	* 
	* @return array|FALSE 
	*/
	private function importText() 
	{
		switch($this->tab) {
			case 'import-text':
				$ribbon_import_text = new Dlayer_Ribbon_Content_ImportText();
				$data = $ribbon_import_text->viewData($this->site_id, 
					$this->page_id, $this->div_id, $this->tool, $this->tab, 
					$this->multi_use, $this->content_id, $this->edit_mode);
				break;

			default:
				$data = FALSE;
				break;
		}

		return $data;
	}

	/**
	* Fetch the view tab data for the import heading tool, typically the data 
	* array will contain the form for the view
	* 
	* @return array|FALSE 
	*/
	private function importHeading() 
	{
		switch($this->tab) {
			case 'import-heading':
				$ribbon_import_heading = 
				new Dlayer_Ribbon_Content_ImportHeading();
				$data = $ribbon_import_heading->viewData($this->site_id, 
					$this->page_id, $this->div_id, $this->tool, $this->tab, 
					$this->multi_use, $this->content_id, $this->edit_mode);
				break;

			default:
				$data = FALSE;
				break;
		}

		return $data;
	}

	/**
	* Fetch the view tab data for the import form tool, in this case a form 
	* with the list of forms for the site, a width for the form container 
	* and also a padding value
	* 
	* @return array|FALSE 
	*/
	private function importForm() 
	{
		switch($this->tab) {
			case 'import-form':
				$ribbon_form = new Dlayer_Ribbon_Content_ImportForm();
				$data = $ribbon_form->viewData($this->site_id, 
					$this->page_id, $this->div_id, $this->tool, $this->tab, 
					$this->multi_use, $this->content_id, $this->edit_mode);
				break;

			case 'styling':            
				$ribbon_styling = 
				new Dlayer_Ribbon_Content_Styling_ImportForm();
				$data = $ribbon_styling->viewData($this->site_id, 
					$this->page_id, $this->div_id, $this->tool, $this->tab, 
					$this->multi_use, $this->content_id, $this->edit_mode);
				break;

			case 'position':            
				$ribbon_position = 
				new Dlayer_Ribbon_Content_Position_ImportForm();
				$data = $ribbon_position->viewData($this->site_id, 
					$this->page_id, $this->div_id, $this->tool, $this->tab, 
					$this->multi_use, $this->content_id, $this->edit_mode);
				break;

			case 'edit':
				/**
				* @todo This needs to be moved into a ribbon class when it 
				* is working
				*/
				$model_content_form = new 
				Dlayer_Model_Page_Content_Items_Form();

				$form_id = $model_content_form->formId($this->site_id, 
					$this->content_id);

				if($form_id != FALSE) {
					$data = $form_id;
				} else {
					$data = FALSE;
				}
				break;

			default:
				$data = FALSE;
				break;
		}

		return $data;
	}
}
