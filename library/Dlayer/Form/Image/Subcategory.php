<?php
/**
* Form for the sub category tool
* 
* Allows the user to add a new sub category to the image library
* 
* This form is used for both the add and edit category forms
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Form_Image_Subcategory extends Dlayer_Form_Module_Image
{
	/**
	* Set the initial properties for the form
	* 
	* @param array $existing_data Exisitng data array for form, array values 
	*                             always preset, will have FALSE values if there 
	*                             is no existing data value
	* @param boolean $edit_mode Is the tool in edit mode
	* @param integer $multi_use Tool tab multi use param
	* @param array|NULL $options Zend form options data array
	* @return void
	*/
	public function __construct(array $existing_data, $edit_mode, 
		$multi_use, $options=NULL)
	{
		$this->tool = 'subcategory';

		parent::__construct($existing_data, $edit_mode, $multi_use, $options);
	}

	/**
	* Initialuse the form, sers the url and submit method and then calls the
	* methods that set up the form
	*
	* @return void
	*/
	public function init()
	{
		$this->setAction('/image/process/tool');

		$this->setMethod('post');

		$this->formElementsData();

		$this->setUpFormElements();

		$this->validationRules();
		
		$this->addElementsToForm('sub_category', 
			'Sub Category <small>Manage Image library sub category</small>', 
			$this->elements);

		$this->addDefaultElementDecorators();

		$this->addCustomElementDecorators();
	}

	/**
	* Fetch any data required to generate the form fields
	*
	* @return void Writes the data to the $this->element_data property ready 
	*              to be used by the form field objects
	*/
	private function formElementsData()
	{
		$model_categories = new Dlayer_Model_Image_Categories();

		$this->elements_data['categories'] = $model_categories->categories(
			$this->existing_data['site_id']);
	}

	/**
	* Set up all the elements required for the form, these are broken down 
	* into two sections, hidden elements for the tool and then visible 
	* elements for the user
	*
	* @return void The form elements are written to the private $this->elemnets
	* 			   array
	*/
	protected function setUpFormElements()
	{
		$this->toolElements();

		$this->userElements();
	}

	/**
	* Set up the tool elements, these are the elements that define the tool and 
	* store the session values for the designer
	*
	* @return void Writes the elements to the private $this->elements array
	*/
	private function toolElements()
	{
		$tool = new Zend_Form_Element_Hidden('tool');
		$tool->setValue($this->tool);

		$this->elements['tool'] = $tool;

		if($this->edit_mode == TRUE && 
		array_key_exists('id', $this->existing_data) == TRUE && 
		$this->existing_data['id'] != FALSE) {
			$sub_category_id = new Zend_Form_Element_Hidden('sub_category_id');
			$sub_category_id->setValue($this->existing_data['id']);
			$this->elements['sub_category_id'] = $sub_category_id;
		}

		if($this->edit_mode == TRUE && 
		array_key_exists('category_id', $this->existing_data) == TRUE && 
		$this->existing_data['category_id'] != FALSE) {
			$category_id = new Zend_Form_Element_Hidden('category_id');
			$category_id->setValue($this->existing_data['category_id']);
			$this->elements['category_id'] = $category_id;
		}

		$multi_use = new Zend_Form_Element_Hidden('multi_use');
		$multi_use->setValue($this->multi_use);
		$multi_use->setBelongsTo('params');

		$this->elements['multi_use'] = $multi_use;
	}

	/**
	* Set up the user elements, these are the elements that the user interacts 
	* with to use the tool
	* 
	* @return void Writes the elements to the private $this->elements array
	*/
	private function userElements()
	{
		$category = new Zend_Form_Element_Select('category');
		$category->setLabel('Category');
		$category->setDescription('Select the category that the new sub 
		category should be created in.');
		$category->setBelongsTo('params');
		$category->setAttribs(array('class'=>'form-control input-sm'));
		$category->setMultiOptions($this->elements_data['categories']);

		if($this->edit_mode == TRUE && 
		array_key_exists('category', $this->existing_data) == TRUE && 
		$this->existing_data['category'] != FALSE) {
			$category->setValue($this->existing_data['category']);
		}

		$this->elements['category'] = $category;

		$name = new Zend_Form_Element_Text('name');
		$name->setLabel('Sub category name');
		$name->setAttribs(array('maxlength'=>255, 
			'placeholder'=>'e.g., Gradients', 
			'class'=>'form-control input-sm'));
		$name->setDescription('Enter a name for the image sub category.');
		$name->setBelongsTo('params');

		if($this->edit_mode == TRUE && 
		array_key_exists('name', $this->existing_data) == TRUE && 
		$this->existing_data['name'] != FALSE) {
			$name->setValue($this->existing_data['name']);
		}

		$this->elements['name'] = $name;

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttribs(array('class'=>'btn btn-primary'));
		$submit->setLabel('Save');

		$this->elements['submit'] = $submit;
	}

	/**
	* Add the validation rules for the form elements and set the custom error
	* messages
	*
	* @return void
	*/
	protected function validationRules()
	{

	}
}