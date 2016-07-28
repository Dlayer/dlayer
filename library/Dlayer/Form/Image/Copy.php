<?php
/**
* Form for the add new image tool
* 
* Allows the user to add a new image to the library, there is an independant 
* edit version of the tool
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Form_Image_Copy extends Dlayer_Form_Module_Image
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
		$this->tool = 'add';

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

		$this->generateFormElements();

		$this->validationRules();

		$this->addElementsToForm('clone', 
			'Clone <small>Create a copy of the selected image</small>', 
			$this->elements);

		$this->addDefaultElementDecorators();

		$this->addCustomElementDecorators();
	}

	/**
	* Fetch the data requuired to populate the selected menu, specifically 
	* the category select as the sub category select will be populate via 
	* AJAX on category select change
	*
	* @return void Writes the data to the $this->element_data property
	*/
	private function formElementsData()
	{
		$session_dlayer = new Dlayer_Session();
		$model_categories = new Dlayer_Model_Image_Categories();

		$this->elements_data['categories'] = $model_categories->categories(
			$session_dlayer->siteId(), TRUE);
	}

	/**
	* Set up all the elements required for the form, these are broken down 
	* into two sections, hidden elements for the tool and then visible 
	* elements for the user
	*
	* @return void The form elements are written to the private $this->elemnets
	* 			   array
	*/
	protected function generateFormElements()
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

		$multi_use = new Zend_Form_Element_Hidden('multi_use');
		$multi_use->setValue($this->multi_use);
		$multi_use->setBelongsTo('params');

		$this->elements['multi_use'] = $multi_use;

		$image_id = new Zend_Form_Element_Hidden('image_id');
		$image_id->setValue($this->existing_data['image_id']);

		$this->elements['image_id'] = $image_id;

		$version_id = new Zend_Form_Element_Hidden('version_id');
		$version_id->setValue($this->existing_data['version_id']);

		$this->elements['version_id'] = $version_id;
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
		$category->setDescription('Select the category for the new copy');
		$category->setMultiOptions($this->elements_data['categories']);
		$category->setAttribs(array('class'=>'form-control input-sm'));
		$category->setBelongsTo('params');

		$this->elements['category'] = $category;

		$sub_category = new Zend_Form_Element_Select('sub_category');
		$sub_category->setLabel('Sub category');
		$sub_category->setDescription('Select the sub category to use for the 
		new copy');
		$sub_category->setMultiOptions(array(0=>'Select category first'));
		$sub_category->setAttribs(array('class'=>'form-control input-sm'));
		$sub_category->setBelongsTo('params');

		$this->elements['sub_category'] = $sub_category;

		$name = new Zend_Form_Element_Text('name');
		$name->setLabel('Name');
		$name->setAttribs(array('maxlength'=>255, 
			'placeholder'=>'e.g., Site background', 
			'class'=>'form-control input-sm'));
		$name->setDescription('Enter a name for the new copy, this will be 
			shown when you need to choose the image from a list.');
		$name->setBelongsTo('params');

		$this->elements['name'] = $name;

		$description = new Zend_Form_Element_Textarea('description');
		$description->setLabel('Description');
		$description->setAttribs(array('rows'=>6, 'cols'=>50, 
			'placeholder'=>'e.g., Site background for the news page', 
			'class'=>'form-control input-sm'));
		$description->setDescription('Enter a description for the new copy.');
		$description->setBelongsTo('params');

		$this->elements['description'] = $description;

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('class', 'submit');
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
