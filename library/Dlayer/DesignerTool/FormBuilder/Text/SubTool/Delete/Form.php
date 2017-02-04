<?php

/**
 * Delete element form class
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_Text_SubTool_Delete_Form extends Dlayer_Form_Tool_Form
{
    /**
     * Set the properties for the form
     *
     * @param array $tool Tool and environment data array
     * @param array $data Current data for content item
     * @param array $element_data
     * @param array|null $options Zend form options
     */
    public function __construct(array $tool, array $data, array $element_data, $options = null)
    {
        $this->field_type = 'Text';
        $this->sub_tool_model = 'Delete';

        parent::__construct($tool, $data, $element_data, $options);
    }

    /**
     * Initialise the form, sets the action and method and then calls the elements to build the form
     *
     * @return void
     */
    public function init()
    {
        $this->setAction('/form/process/tool');

        $this->setMethod('post');

        $this->generateFormElements();

        $this->addElementsToForm('delete', 'Delete', $this->elements);

        $this->addDefaultElementDecorators();

        $this->addCustomElementDecorators();
    }

    /**
     * Generate the tool elements that the user interacts with
     *
     * @return void
     */
    protected function generateUserElements()
    {
        $confirm = new Zend_Form_Element_Checkbox('confirm');
        $confirm->setLabel('Confirm');
        $confirm->setDescription('Please check the box to confirm you want to delete the element, 
            (it can be recovered if necessary)');
        $confirm->setBelongsTo('params');
        $confirm->setRequired();

        $this->elements['confirm'] = $confirm;
    }

    protected function generateSubmitElement()
    {
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttribs(array('class' => 'btn btn-sm btn-danger'));
        $submit->setLabel('Delete');

        $this->elements['submit'] = $submit;

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
}
