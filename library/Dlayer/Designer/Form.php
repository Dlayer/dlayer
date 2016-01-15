<?php
/**
* Form designer class, fetches all the high level data required to generate the
* form for the form builder
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Designer_Form
{
	private $site_id;
	private $form_id;
	private $view = FALSE;
	private $field_id = NULL;
	
	private $styles = array();

	private $model_form;
	private $model_styles;

	/**
	* Initialise the object, run setup methods and set initial properties
	*
	* @param integer $site_id
	* @param integer $form_id
	* @param boolean $view Set to TRUE if form is in view mode, ids are 
	* 	not added to fields if in view mode
	* @param integer|NULL $field_id
	* @return void
	*/
	public function __construct($site_id, $form_id, $view=FALSE, 
	$field_id=NULL)
	{
		$this->site_id = $site_id;
		$this->form_id = $form_id;
		$this->view = $view;
		$this->field_id = $field_id;

		$this->model_form = new Dlayer_Model_View_Form();
		$this->model_styles = new Dlayer_Model_View_Form_Styles();
	}

	/**
	* Fetch the field data for the form, returns an array of all the fields
	* that make up the form along with all the attribute details
	*
	* @return array
	*/
	private function fields()
	{
		return $this->model_form->fields($this->form_id, $this->site_id);
	}

	/**
	* Fetch the form
	*
	* @return Dlayer_Form_Builder
	*/
	public function form()
	{
		return new Dlayer_Form_Builder($this->form_id, $this->fields(),
		$this->view, $this->field_id);
	}
	
	/**
	* Fetch all the styles for the form, styles are returned in an array 
	* indexed by form field id. The value will be an array of the style 
	* attribute and string. These arrays can then be looped and output above 
	* the form
	* 
	* @return array
	*/
	public function fieldStyles() 
	{
		$this->styles = $this->model_form->fieldIds($this->site_id, 
		$this->form_id);
		
		$this->rowBackgroundColors();
							  
		return $this->styles;
	}
	
	/**
	* Fetch the row background color styles and assign the values to the 
	* styles array
	* 
	* @return void
	*/
	private function rowBackgroundColors() 
	{
		$background_colors = $this->model_styles->rowBackgroundColors(
		$this->site_id, $this->form_id);
		
		if($background_colors != FALSE) {
			foreach($background_colors as $field_id => $color_hex) {
				if(array_key_exists($field_id, $this->styles) == TRUE) {
					$this->styles[$field_id][] = 'background-color: ' . 
					$color_hex . ';';
				}
			}
		}
	}
}