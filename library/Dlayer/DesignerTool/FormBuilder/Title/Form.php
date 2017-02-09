<?php

/**
 * Form to set the title and sub title
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_Title_Form extends Dlayer_Form_Tool_Form
{
    /**
     * Set the properties for the form
     *
     * @param array $tool Tool and environment data array
     * @param array $data Current data for content item
     * @param array $element_data
     * @param array|NULL $options Zend form options
     */
    public function __construct(array $tool, array $data, array $element_data, $options=NULL)
    {
        parent::__construct($tool, $data, $element_data, $options);
    }

    /**
     * Initialise the form, sets the action and method and then calls the elements to build the form
     *
     * @return void
     */
    public function init()
    {
        $this->setAction('/form/process/tool-auto');

        $this->setMethod('post');

        $this->generateFormElements();

        $this->addElementsToForm('title', 'Titles', $this->elements);

        $this->addDefaultElementDecorators();

        $this->addCustomElementDecorators();
    }

    protected function generateUserElements()
    {
        $title = new Zend_Form_Element_Text('form_title');
        $title->setLabel('Title');
        $title->setDescription('Enter a title, this will be displayed above the form.');
        $title->setAttribs(
            array(
                'maxlength'=>255,
                'placeholder' => 'e.g., Content us',
                'class'=>'form-control input-sm'
            )
        );
        $title->setBelongsTo('params');
        $title->setRequired();

        if (array_key_exists('form_title', $this->data) && $this->data['form_title'] !== false) {
            $title->setValue($this->data['form_title']);
        }

        $this->elements['form_title'] = $title;

        $sub_title = new Zend_Form_Element_Text('form_subtitle');
        $sub_title->setLabel('Subtitle');
        $sub_title->setDescription('Enter a sub title, this appears in a smaller font to the right 
            of the title.');
        $sub_title->setAttribs(
            array(
                'maxlength'=>255,
                'placeholder' => 'e.g., Content us',
                'class'=>'form-control input-sm'
            )
        );
        $sub_title->setBelongsTo('params');

        if (array_key_exists('form_subtitle', $this->data) && $this->data['form_subtitle'] !== false) {
            $sub_title->setValue($this->data['form_subtitle']);
        }

        $this->elements['form_subtitle'] = $sub_title;
    }
}
