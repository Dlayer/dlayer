<?php
/**
* Form builder form object, sets up the form according to the propeties and
* then creates the relevant form fields, layout and validation
*
* @author Dean Blackborough
* @copyright G3D Development Limited
* @version $Id: Builder.php 1942 2014-06-15 12:52:34Z Dean.Blackborough $
*/
class Dlayer_Form_Builder extends Zend_Form
{
	/**
	* Id of the form
	*
	* @var integer
	*/
	private $form_id;

	/**
	* Id of the selected field
	*
	* @var integer|NULL
	*/
	private $field_id;

	/**
	* Form elments
	*
	* @var array
	*/
	private $elements = array();

	/**
	* Form fields data array
	*
	* @var array
	*/
	private $form_fields;

	/**
	* Form builder settings
	* 
	* @var array
	*/
	private $settings;

	/**
	* View mode, if TRUE don't add ids to form field rows
	* 
	* @var boolean
	*/
	private $view;

	/**
	* Pass in any values that are needed to set up the form, optional
	*
	* @param integer $form_id Form id
	* @param array $form_fields Fields for form
	* @param boolean $view If in view mode don't add ids 
	* @param integer|NULL $field_id
	* @param array|NULL Options for form
	* @return void
	*/
	public function __construct($form_id, array $form_fields=array(),
		$view=FALSE, $field_id=NULL, $options=NULL)
	{
		$this->form_id = $form_id;
		$this->field_id = $field_id;
		$this->form_fields = $form_fields;
		$this->view = $view;
		$this->settings = $this->settings();

		$this->setMethod('post');

		$this->setUpFormElements();

		$this->addElements($this->elements);

		$this->addCustomElementDecorators();

		parent::__construct($options=NULL);
	}

	/**
	* Set up the form fields that have been defined for the form
	*
	* @return void Form elements are written to the private $this->elements
	*              property
	*/
	private function setUpFormElements()
	{
		foreach($this->form_fields as $form_field) {
			
			$form_field['attributes']['class'] = 'form-control';

			switch($form_field['tool']) {
				case 'text':
					$this->textInput($form_field);
					break;

				case 'name':
					$this->nameInput($form_field);
					break;

				case 'email':
					$this->emailInput($form_field);
					break;

				case 'textarea':
					$this->textareaInput($form_field);
					break;

				case 'password':
					$this->passwordInput($form_field);
					break;

				default:
					throw new Exception('Field type: ' . $form_field['tool'] .
						' does not exist in form builder switch statement');
					break;
			}
		}

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel($this->settings['button']);
		$submit->setAttribs(array('class'=>'btn btn-primary'));
		$this->elements['submit'] = $submit;
	}

	/**
	* Fetch the settings for the form
	* 
	* @return array
	*/
	private function settings() 
	{
		$model_form = new Dlayer_Model_Form_Settings();
		return $model_form->formBuilderSettings($this->form_id);
	}

	/**
	* Add the validation rules for the form elements and set the custom error
	* messages
	*
	* @return void
	*/
	private function validationRules()
	{

	}

	/**
	* Create the text input and assign to the elements array
	*
	* @param array $form_field Form field data array
	* @return void
	*/
	private function textInput(array $form_field)
	{
		$input = new Zend_Form_Element_Text('field_' . $form_field['id']);
		$input->setLabel($form_field['label']);
		$input->setDescription($form_field['description']);
		$input->setAttribs($form_field['attributes']);

		$this->elements['field_' . $form_field['id']] = $input;
	}

	/**
	* Create the name input and assign to the elements array
	*
	* @param array $form_field Form field data array
	* @return void
	*/
	private function nameInput(array $form_field)
	{
		$input = new Zend_Form_Element_Text('field_' . $form_field['id']);
		$input->setLabel($form_field['label']);
		$input->setDescription($form_field['description']);
		$input->setAttribs($form_field['attributes']);

		$this->elements['field_' . $form_field['id']] = $input;
	}

	/**
	* Create the email input and assign to the elements array
	*
	* @param array $form_field Form field data array
	* @return void
	*/
	private function emailInput(array $form_field)
	{
		$input = new Zend_Form_Element_Text('field_' . $form_field['id']);
		$input->setLabel($form_field['label']);
		$input->setDescription($form_field['description']);
		$input->setAttribs($form_field['attributes']);

		$this->elements['field_' . $form_field['id']] = $input;
	}

	/**
	* Create the password input and assign to the elements array
	*
	* @param array $form_field Form field data array
	* @return void
	*/
	private function passwordInput(array $form_field)
	{
		$input = new Zend_Form_Element_Password('field_' . $form_field['id']);
		$input->setLabel($form_field['label']);
		$input->setDescription($form_field['description']);
		$input->setAttribs($form_field['attributes']);

		$this->elements['field_' . $form_field['id']] = $input;
	}

	/**
	* Create the textarea input and assign to the elements array
	*
	* @param array $form_field Form field data array
	* @return void
	*/
	private function textareaInput(array $form_field)
	{
		$input = new Zend_Form_Element_Textarea('field_' . $form_field['id']);
		$input->setLabel($form_field['label']);
		$input->setDescription($form_field['description']);
		$input->setAttribs($form_field['attributes']);

		$this->elements['field_' . $form_field['id']] = $input;
	}

	/**
	* Add any custom decorators, these are inputs where we need a little more
	* control over the html, an example being the submit button
	*
	* @return void
	*/
	private function addCustomElementDecorators()
	{
		$this->setDecorators(array(
			'FormElements', 
			array('Form', array('class'=>'form'))));

		
		foreach($this->form_fields as $form_field) {
			$class = 'form-group field_row row_' . $form_field['id'];

			if($this->field_id != NULL &&
			$this->field_id == $form_field['id']) {
				$class .= ' selected';
			}

			if($this->view == FALSE) {
				$row_id = $form_field['type'] . ':' . $form_field['tool'] . 
				':' . $form_field['id'];
			} else {
				$row_id = '';
			}

			$this->elements['field_' . $form_field['id']]->setDecorators(
				array(array('ViewHelper'),
					array('Description', array('tag' => 'p', 'class'=>'help-block')),
					array('Errors', array('class'=> 'alert alert-danger')), 
					array('Label'), 
					array('HtmlTag', array(
						'tag' => 'div', 
						'class'=> $class,
						'id'=>$row_id)
					)
				)
			);
		}

		$this->elements['submit']->setDecorators(array(array('ViewHelper'),
			array('HtmlTag', array('tag' => 'div', 'class'=>'form-group'))));
	}

	/**
	* Add the elements to the form set up the fieldset/legend
	*
	* @param string $id Fieldset id
	* @param string $label Label for fieldset
	* @param array $elements Elements to add to form and pass to display group
	* @retrun void
	*/
	private function addElementsToForm($id, $label, array $elements)
	{
		$this->addElements($elements);

		$this->addDisplayGroup($elements, $id, array('legend'=>$label));
	}
}