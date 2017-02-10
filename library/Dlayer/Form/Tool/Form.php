<?php

/**
 * Base class for the Form Builder tool forms
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
abstract class Dlayer_Form_Tool_Form extends Dlayer_Form
{
    protected $tool = array();
    protected $sub_tool_model = null;
    protected $field_type;
    protected $data = array();
    protected $element_data = array();

    protected $preset = null;

    /**
     * Set the properties for the form
     *
     * @param array $tool Tool and environment data array
     * @param array $data Current data for content item
     * @param array $element_data Data array containing data for elements (Select menu etc.)
     * @param array|NULL $options Zend form options
     */
    public function __construct(array $tool, array $data, array $element_data, $options = null)
    {
        $this->tool = $tool;
        $this->data = $data;
        $this->element_data = $element_data;

        parent::__construct($options);
    }

    /**
     * Set up the tool elements, these are the elements that are part of every tool and set the environment
     * properties and tool options
     *
     * @return void The elements are written to the $this->elements private property
     */
    protected function generateToolElements()
    {
        $tool = new Zend_Form_Element_Hidden('tool');
        $tool->setValue($this->tool['name']);

        $this->elements['tool'] = $tool;

        if ($this->sub_tool_model !== null) {
            $sub_tool_model = new Zend_Form_Element_Hidden('sub_tool_model');
            $sub_tool_model->setValue($this->sub_tool_model);

            $this->elements['sub_tool_model'] = $sub_tool_model;
        }

        if (isset($this->field_type) && $this->field_type !== null) {
            $field_type = new Zend_Form_Element_Hidden('field_type');
            $field_type->setValue($this->field_type);

            $this->elements['field_type'] = $field_type;
        }

        if (isset($this->preset) && $this->preset === 1) {
            $preset = new Zend_Form_Element_Hidden('preset');
            $preset->setValue($this->preset);

            $this->elements['preset'] = $preset;
        }

        $multi_use = new Zend_Form_Element_Hidden('multi_use');
        $multi_use->setValue($this->tool['multi_use']);

        $this->elements['multi_use'] = $multi_use;

        $form_id = new Zend_Form_Element_Hidden('form_id');
        $form_id->setValue($this->tool['form_id']);

        $this->elements['form_id'] = $form_id;

        $field_id = new Zend_Form_Element_Hidden('field_id');
        $field_id->setValue($this->tool['field_id']);

        $this->elements['field_id'] = $field_id;
    }

    protected function generateSubmitElement()
    {
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttribs(array('class' => 'btn btn-sm btn-success'));
        $submit->setLabel('Save');

        $this->elements['submit'] = $submit;
    }

    abstract protected function generateUserElements();

    /**
     * Create the form elements and assign them to $this->elements, array will be passed to
     * Dlayer_Form::addElementsToForm()
     *
     * @return void
     */
    protected function generateFormElements()
    {
        $this->generateToolElements();

        $this->generateUserElements();

        $this->generateSubmitElement();
    }

    /**
     * Add validation rules
     *
     * @return void
     */
    protected function validationRules()
    {
        // TODO: Implement validationRules() method.
    }

    /**
     * Add the default element decorators
     *
     * @return void
     */
    protected function addDefaultElementDecorators()
    {
        $this->setDecorators(array(
            'FormElements',
            array('Form', array('class' => 'form'))
        ));

        $this->setElementDecorators(array(
            array('ViewHelper'),
            array('Description', array('tag' => 'p', 'class' => 'help-block')),
            array('Errors', array('class' => 'alert alert-danger')),
            array('Label'),
            array(
                'HtmlTag',
                array(
                    'tag' => 'div',
                    'class' => array(
                        'callback' => function ($decorator) {
                            if ($decorator->getElement()->hasErrors()) {
                                return 'form-group has-error';
                            } else {
                                return 'form-group';
                            }
                        }
                    )
                )
            )
        ));

        $this->setDisplayGroupDecorators(array(
            'FormElements',
            'Fieldset',
        ));
    }

    protected function addCustomElementDecorators()
    {
        $this->elements['submit']->setDecorators(array(
            array('ViewHelper'),
            array(
                'HtmlTag',
                array(
                    'tag' => 'div',
                    'class' => 'form-group form-group-submit'
                )
            )
        ));
    }
}
