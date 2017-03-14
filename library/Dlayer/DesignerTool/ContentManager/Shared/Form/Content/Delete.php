<?php

/**
 * Delete content item from page
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Shared_Form_Content_Delete extends Dlayer_Form_Tool_Content
{
    /**
     * Set the properties for the form
     *
     * @param array $tool Tool and environment data array
     * @param array $data Current data for content item
     * @param integer $instances Instances of content data on web site
     * @param array $element_data Data array containing data for elements (Select menu etc.)
     * @param array|NULL $options Zend form options
     */
    public function __construct(array $tool, array $data, $instances, array $element_data, $options=NULL)
    {
        $this->sub_tool_model = 'Delete';

        parent::__construct($tool, $data, $instances, $element_data, $options);
    }

    /**
     * Initialise the form, sets the action and method and then calls the elements to build the form
     *
     * @return void
     */
    public function init()
    {
        $this->setAction('/content/process/tool');

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
        $confirm->setDescription('Please check the box to confirm you want to delete the content item, 
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
