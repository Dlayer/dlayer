<?php

/**
 * Add or edit a form
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Form_Admin_Form extends Dlayer_Form_Site
{
    /**
     * @var string
     */
    private $post_uri;

    /**
     * @var integer
     */
    private $site_id;

    /**
     * @var integer|NULL
     */
    private $form_id;

    /**
     * @var array
     */
    private $form;

    /**
     * Pass in anything needed to set up the form and set options
     *
     * @param string $post_uri Uri to post to
     * @param integer $site_id
     * @param integer|NULL $form_id Form is if we are editing
     * @param array $form Existing form data, used in edit mode to preset values
     * @param array|NULL $options
     */
    public function __construct($post_uri, $site_id, $form_id = null, array $form = array(), array $options = null)
    {
        $this->post_uri = $post_uri;
        $this->site_id = $site_id;
        $this->form_id = $form_id;
        $this->form = $form;

        parent::__construct($options = null);
    }

    /**
     * Initialise the form, set the URI, method and build the form
     *
     * @return void
     */
    public function init()
    {
        $this->setAction($this->post_uri);

        $this->setMethod('post');

        $this->generateFormElements();

        $this->validationRules();

        if ($this->form_id === null) {
            $legend = ' <small>Add a new form</small>';
        } else {
            $legend = ' <small>Edit form</small>';
        }
        $this->addElementsToForm('content_page', 'Form: ' . $legend, $this->elements);

        $this->addDefaultElementDecorators();

        $this->addCustomElementDecorators();
    }

    /**
     * Create the form elements and assign them to $this->elements, array will be passed to
     * Dlayer_Form::addElementsToForm()
     *
     * @return void
     */
    protected function generateFormElements()
    {
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Your form name');
        $name->setDescription('Enter a name for your new form, this will only be displayed within Dlayer so you can 
            easily identify the form in the designers.');
        $name->setAttribs(array(
            'size' => 50,
            'maxlength' => 255,
            'placeholder' => 'e.g., Contact form',
            'class' => 'form-control'
        ));
        $name->setRequired();
        if ($this->form_id !== null && array_key_exists('name', $this->form)) {
            $name->setValue($this->form['name']);
        }

        $this->elements['name'] = $name;

        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Title');
        $title->setDescription("Enter a title, this will be displayed above the form.");
        $title->setAttribs(array(
            'size' => 50,
            'maxlength' => 255,
            'placeholder' => "e.g., Contact us",
            'class' => 'form-control'
        ));
        $title->setRequired();
        if ($this->form_id !== null && array_key_exists('title', $this->form)) {
            $title->setValue($this->form['title']);
        }

        $this->elements['title'] = $title;

        $subtitle = new Zend_Form_Element_Text('subtitle');
        $subtitle->setLabel('Subtitle');
        $subtitle->setDescription('Enter a sub title, this appears in a smaller font to the right of the title.');
        $subtitle->setAttribs(
            array(
                'size' => 50,
                'maxlength' => 255,
                'placeholder' => "e.g., Feedback form",
                'class' => 'form-control'
            )
        );
        if ($this->form_id !== null && array_key_exists('subtitle', $this->form)) {
            $subtitle->setValue($this->form['subtitle']);
        }

        $this->elements['subtitle'] = $subtitle;

        $layout = new Zend_Form_Element_Select('layout');
        $layout->setLabel('Layout style');
        $layout->setDescription('Choose the layout style to use for your form.');
        $layout->setAttribs(
            array(
                'class' => 'form-control'
            )
        );
        $layout->setMultiOptions(
            array(
                1 => 'Stacked',
                2 => 'Inline',
                3 => 'Horizontal'
            )
        );
        if ($this->form_id !== null && array_key_exists('layout', $this->form)) {
            $layout->setValue($this->form['layout']);
        }

        $this->elements['layout'] = $layout;

        $submit_label = new Zend_Form_Element_Text('submit_label');
        $submit_label->setLabel('Submit button label');
        $submit_label->setDescription("Enter the label for the submit button.");
        $submit_label->setRequired();
        $submit_label->setAttribs(array(
            'size' => 50,
            'maxlength' => 255,
            'placeholder' => "e.g., Send",
            'class' => 'form-control'
        ));
        if ($this->form_id !== null && array_key_exists('submit_label', $this->form)) {
            $submit_label->setValue($this->form['submit_label']);
        }

        $this->elements['submit_label'] = $submit_label;

        $reset_label = new Zend_Form_Element_Text('reset_label');
        $reset_label->setLabel('Reset button label');
        $reset_label->setDescription("Enter the optional label for the reset button, if not set the reset button will not be added to your form.");
        $reset_label->setAttribs(array(
            'size' => 50,
            'maxlength' => 255,
            'placeholder' => "e.g., Reset",
            'class' => 'form-control'
        ));
        if ($this->form_id !== null && array_key_exists('reset_label', $this->form)) {
            $reset_label->setValue($this->form['reset_label']);
        }

        $this->elements['reset_label'] = $reset_label;

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Save');
        $submit->setAttribs(array('class' => 'btn btn-primary'));

        $this->elements['submit'] = $submit;
    }

    /**
     * Add validation
     *
     * @return void
     */
    protected function validationRules()
    {
        $this->elements['name']->addValidator(
            new Dlayer_Validate_FormNameUnique($this->site_id, $this->form_id)
        );
    }
}
