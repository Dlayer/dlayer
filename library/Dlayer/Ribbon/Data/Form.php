<?php
/**
* Ribbon data class pulls the data that is required for the requested tool
* and tab, this could be data to help build the forms or data about the
* selected item/element. This class is similar for each model, differences
* being between the params required to call for the data. This class hands
* of all the calls to individual ribbon classes, it just acts as the
* interface
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Form.php 1882 2014-06-01 15:01:22Z Dean.Blackborough $
*/
class Dlayer_Ribbon_Data_Form
{
	private $site_id;
	private $form_id;
	private $tool;
	private $tab;
	private $field_id;
	private $edit_mode;
	private $multi_use;

	/**
	* Fetch the data for the tool and tool tab using the supplied params,
	* the result array is passed to the view script, each ribbon tool tab
	* view script uses the data in its own way
	*
	* @param integer $site_id Current site id
	* @param integer $form_id Current form id
	* @param string $tool Name of the selected tool
	* @param string $tab Name of the selected tool tab
	* @param integer $multi_use Multi use value for tool tab
	* @param integer|NULL $field_id Selected form field
	* @param boolean $edit_mode Is the tool tab in edit mode
	* @return array|FALSE Either an array of data for the tool tab view script
	*                     or FALSE if no data is found or required, up to the
	*                     view script how to handle the return value
	*/
	public function viewData($site_id, $form_id, $tool, $tab, $multi_use, 
	$field_id=NULL, $edit_mode=FALSE)
	{
		$this->site_id = $site_id;
		$this->form_id = $form_id;
		$this->tool = $tool;
		$this->tab = $tab;
		$this->multi_use = $multi_use;
		$this->field_id = $field_id;
		$this->edit_mode = $edit_mode;

		switch($this->tool) {
			case 'text':
				$data = $this->text();
			break;
			
			case 'preset-name':
				$data = $this->presetName();
			break;
			
			case 'email':
				$data = $this->email();
			break;
			
			case 'preset-email':
				$data = $this->presetEmail();
			break;

			case 'textarea':
				$data = $this->textarea();
			break;

			case 'password':
				$data = $this->password();
			break;
			
			case 'form-layout': 
				$data = $this->formLayout();
			break;

			default:
				$data = FALSE;
			break;
		}

		return $data;
	}

	/**
	* Fetch the view tab data for the text tool
	*
	* @return array|FALSE
	*/
	private function text()
	{
		switch($this->tab) {
			case 'text':
				$ribbon_text = new Dlayer_Ribbon_Form_Text();
				$data = $ribbon_text->viewData($this->site_id,
				$this->form_id, $this->tool, $this->tab, $this->multi_use, 
				$this->field_id, $this->edit_mode);
			break;
			
			case 'styling':
				$ribbon_styling = new Dlayer_Ribbon_Form_Styling_Text();
				$data = $ribbon_styling->viewData($this->site_id,
				$this->form_id, $this->tool, $this->tab, $this->multi_use, 
				$this->field_id, $this->edit_mode);
			break;

			default:
				$data = FALSE;
			break;
		}

		return $data;
	}
	
	/**
	* Fetch the view tab data for the selected tab of the form layout tool
	*
	* @return array|FALSE
	*/
	private function formLayout()
	{
		switch($this->tab) {
			case 'form-layout':
				$ribbon_layout = new Dlayer_Ribbon_Form_FormLayout();
				$data = $ribbon_layout->viewData($this->site_id,
				$this->form_id, $this->tool, $this->tab, $this->multi_use,
				$this->field_id, $this->edit_mode);
			break;
			
			default:
				$data = FALSE;
			break;
		}

		return $data;
	}
	
	/**
	* Fetch the view tab data for the name tool
	*
	* @return array|FALSE
	*/
	private function presetName()
	{
		switch($this->tab) {
			case 'preset-name':
				$ribbon_name = new Dlayer_Ribbon_Form_PresetName();
				$data = $ribbon_name->viewData($this->site_id,
				$this->form_id, $this->tool, $this->tab, $this->multi_use, 
				$this->field_id, $this->edit_mode);
			break;

			default:
				$data = FALSE;
			break;
		}

		return $data;
	}
	
	/**
	* Fetch the view tab data for the name tool
	*
	* @return array|FALSE
	*/
	private function email()
	{
		switch($this->tab) {
			case 'email':
				$ribbon_email = new Dlayer_Ribbon_Form_Email();
				$data = $ribbon_email->viewData($this->site_id,
				$this->form_id, $this->tool, $this->tab, $this->multi_use, 
				$this->field_id, $this->edit_mode);
			break;
			
			case 'styling':
				$ribbon_styling = new Dlayer_Ribbon_Form_Styling_Email();
				$data = $ribbon_styling->viewData($this->site_id,
				$this->form_id, $this->tool, $this->tab, $this->multi_use, 
				$this->field_id, $this->edit_mode);
			break;

			default:
				$data = FALSE;
			break;
		}

		return $data;
	}
	
	/**
	* Fetch the view tab data for the email tool
	*
	* @return array|FALSE
	*/
	private function presetEmail()
	{
		switch($this->tab) {
			case 'preset-email':
				$ribbon_email = new Dlayer_Ribbon_Form_PresetEmail();
				$data = $ribbon_email->viewData($this->site_id,
				$this->form_id, $this->tool, $this->tab, $this->multi_use, 
				$this->field_id, $this->edit_mode);
			break;

			default:
				$data = FALSE;
			break;
		}

		return $data;
	}

	/**
	* Fetch the view tab data for the password tool
	*
	* @return array|FALSE
	*/
	private function password()
	{
		switch($this->tab) {
			case 'password':
				$ribbon_password = new Dlayer_Ribbon_Form_Password();
				$data = $ribbon_password->viewData($this->site_id,
				$this->form_id, $this->tool, $this->tab, $this->multi_use, 
				$this->field_id, $this->edit_mode);
			break;
			
			case 'styling':
				$ribbon_styling = new Dlayer_Ribbon_Form_Styling_Password();
				$data = $ribbon_styling->viewData($this->site_id,
				$this->form_id, $this->tool, $this->tab, $this->multi_use, 
				$this->field_id, $this->edit_mode);
			break;

			default:
				$data = FALSE;
			break;
		}

		return $data;
	}

	/**
	* Fetch the view tab data for the textarea tool
	*
	* @return array|FALSE
	*/
	private function textarea()
	{
		switch($this->tab) {
			case 'textarea':
				$ribbon_textarea = new Dlayer_Ribbon_Form_Textarea();
				$data = $ribbon_textarea->viewData($this->site_id,
				$this->form_id, $this->tool, $this->tab, $this->multi_use, 
				$this->field_id, $this->edit_mode);
			break;
			
			case 'styling':
				$ribbon_styling = new Dlayer_Ribbon_Form_Styling_Textarea();
				$data = $ribbon_styling->viewData($this->site_id,
				$this->form_id, $this->tool, $this->tab, $this->multi_use, 
				$this->field_id, $this->edit_mode);
			break;

			default:
				$data = FALSE;
			break;
		}

		return $data;
	}
}