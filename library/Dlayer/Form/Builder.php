<?php

/**
 * Form builder form object, sets up the form according to the propeties and
 * then creates the relevant form fields, layout and validation
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 */
class Dlayer_Form_Builder extends Zend_Form
{
    /**
     * Id of the site
     *
     * @var integer
     */
    private $site_id;

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
     * Builder mode, if true add the ids/data attributes
     *
     * @var boolean
     */
    private $builder;

    private $buttons;
    private $layout_mode;

    private $model_layout;

    /**
     * Pass in any values that are needed to set up the form, optional
     *
     * @param integer $form_id Form id
     * @param array $form_fields Fields for form
     * @param boolean $builder If in builder mode add ids
     * @param integer|NULL $field_id
     * @param array|NULL Options for form
     * @return void
     */
    public function __construct(
        $form_id,
        array $form_fields = array(),
        $builder = false,
        $field_id = null,
        $options = null
    ) {
        $session_dlayer = new Dlayer_Session();
        $this->site_id = $session_dlayer->siteId();

        $this->form_id = $form_id;
        $this->field_id = $field_id;
        $this->form_fields = $form_fields;
        $this->builder = $builder;

        $this->model_layout = new Dlayer_Model_View_Form_Layout();

        $this->buttons = $this->buttons();

        $this->layout_mode = $this->layout();

        $this->setMethod('post');

        $this->setUpFormElements();

        $this->addElements($this->elements);

        $this->addCustomElementDecorators();

        parent::__construct($options = null);
    }

    /**
     * Set up the form fields that have been defined for the form
     *
     * @return void Form elements are written to the private $this->elements
     *              property
     * @throws \Exception
     */
    private function setUpFormElements()
    {
        foreach ($this->form_fields as $form_field) {

            $form_field['attributes']['class'] = 'form-control';

            // Remove size attribute when in inline mode
            if ($this->layout_mode['mode'] == 'form-inline') {
                unset($form_field['attributes']['size']);
            }

            switch ($form_field['type']) {
                case 'Text':
                    $this->textInput($form_field);
                    break;

                case 'Email':
                    $this->emailInput($form_field);
                    break;

                case 'Textarea':
                    $this->textAreaInput($form_field);
                    break;

                case 'Password':
                    $this->passwordInput($form_field);
                    break;

                default:
                    throw new Exception('Field type: ' . $form_field['type'] .
                        ' does not exist in form builder switch statement');
                    break;
            }
        }

        if ($this->buttons['submit'] == true) {
            $submit = new Zend_Form_Element_Submit('submit');
            $submit->setLabel($this->buttons['submit_label']);
            $submit->setAttribs(array('class' => 'btn btn-primary'));
            $this->elements['submit'] = $submit;
        }

        if ($this->buttons['reset'] == true) {
            $reset = new Zend_Form_Element_Reset('reset');
            $reset->setLabel($this->buttons['reset_label']);
            $reset->setAttribs(array('class' => 'btn btn-default'));
            $this->elements['reset'] = $reset;
        }
    }

    /**
     * Fetch the layout mode for the form, in horizontal mode we also have
     * the widths for the label and field columns
     *
     * @return array
     */
    private function layout()
    {
        $data = $this->model_layout->layout($this->site_id, $this->form_id);

        $layout = array(
            'mode' => $data['class'],
            'label' => null,
            'field' => null
        );

        if ($layout['mode'] == 'form-horizontal') {
            $layout['label'] = 'col-sm-' . $data['horizontal_width_label'];
            $layout['field'] = 'col-sm-' . $data['horizontal_width_field'];
        }

        return $layout;
    }

    /**
     * Fetch the button values for the form
     *
     * @return array
     */
    private function buttons()
    {
        $session_dlayer = new Dlayer_Session();

        $data = $this->model_layout->buttons($session_dlayer->siteId(),
            $this->form_id);

        $buttons = array();

        $buttons['submit'] = true;
        $buttons['submit_label'] = $data['submit_label'];
        if (strlen($data['reset_label']) > 0) {
            $buttons['reset'] = true;
            $buttons['reset_label'] = $data['reset_label'];
        } else {
            $buttons['reset'] = false;
            $buttons['reset_label'] = null;
        }

        return $buttons;
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
        $input->setLabel($form_field['attributes']['label']);
        $input->setDescription($form_field['attributes']['description']);
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
        $input->setLabel($form_field['attributes']['label']);
        $input->setDescription($form_field['attributes']['description']);
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
        $input = new Dlayer_Form_Element_Email('field_' . $form_field['id']);
        $input->setLabel($form_field['attributes']['label']);
        $input->setDescription($form_field['attributes']['description']);
        $input->setAttribs($form_field['attributes']);
        $input->setValue(' ');

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
        $input->setLabel($form_field['attributes']['label']);
        $input->setDescription($form_field['attributes']['description']);
        $input->setAttribs($form_field['attributes']);
        $input->setValue(' ');

        $this->elements['field_' . $form_field['id']] = $input;
    }

    /**
     * Create the textarea input and assign to the elements array
     *
     * @param array $form_field Form field data array
     * @return void
     */
    private function textAreaInput(array $form_field)
    {
        $input = new Zend_Form_Element_Textarea('field_' . $form_field['id']);
        $input->setLabel($form_field['attributes']['label']);
        $input->setDescription($form_field['attributes']['description']);
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
        $decorators = new Dlayer_Form_LayoutDecoratorHelper(
            $this->layout_mode['mode'], $this->layout_mode['label'],
            $this->layout_mode['field'], $this->builder, $this->field_id);

        $this->setDecorators($decorators->form());

        foreach ($this->form_fields as $form_field) {

            $field_decorators = $decorators->field($form_field['id'],
                array(
                    'type' => $form_field['type'],
                    'description' => $form_field['attributes']['description']
                ));

            $this->elements['field_' . $form_field['id']]->setDecorators(
                $field_decorators);
        }

        if (array_key_exists('submit', $this->elements)) {
            $this->elements['submit']->setDecorators(
                array(
                    array('ViewHelper'),
                )
            );
        }

        if (array_key_exists('reset', $this->elements)) {
            $this->elements['reset']->setDecorators(
                array(
                    array('ViewHelper'),
                )
            );
        }
    }
}
