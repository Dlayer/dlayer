<?php

/**
 * Form designer class, fetches all the data required to create the form
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Designer_Form
{

    /**
     * @var boolean
     */
    private $builder = false;

    /**
     * @var integer|null
     */
    private $field_id = null;

    /**
     * @var \Dlayer_Model_View_Form
     */
    private $model_form;

    /**
     * @var \Dlayer_Model_View_Form_Styling
     */
    private $model_styling;

    /**
     * @var array
     */
    private $styles;

    /**
     * Pass in anything required to setup the object
     *
     * @param integer $site_id
     * @param integer $id
     * @param boolean $builder
     * @param integer|NULL $field_id
     */
    public function __construct($site_id, $id, $builder = false, $field_id = null)
    {
        $this->site_id = $site_id;
        $this->id = $id;
        $this->builder = $builder;
        $this->field_id = $field_id;

        $this->model_form = new Dlayer_Model_View_Form();
        $this->model_form->setUp($site_id, $id);

        $this->model_styling = new Dlayer_Model_View_Form_Styling();
        $this->model_form->setUp($site_id, $id);
    }

    /**
     * Fetch the form titles and buttons
     *
     * @return array
     */
    public function layoutOptions()
    {
        $layoutOptions = $this->model_form->layoutOptions();
        if ($layoutOptions !== false) {
            return $layoutOptions;
        } else {
            return array(
                'title' => Dlayer_Config::FORM_DEFAULT_TITLE,
                'subtitle' => Dlayer_Config::FORM_DEFAULT_SUBTITLE,
                'submit_label' => Dlayer_Config::FORM_DEFAULT_SUBMIT_LABEL,
                'reset_label' => Dlayer_Config::FORM_DEFAULT_RESET_LABEL
            );
        }
    }

    /**
     * Fetch all the fields that have assigned to the form, will include all the attributes for each field
     *
     * @return array
     */
    private function fields()
    {
        return $this->model_form->fields();
    }

    /**
     * Fetch the form
     *
     * @return Dlayer_Form_Builder
     */
    public function form()
    {
        return new Dlayer_Form_Builder($this->id, $this->fields(), $this->builder, $this->field_id);
    }

    /**
     * Fetch the styling for field rows, indexed by field row
     *
     * @return array
     */
    public function rowStyles()
    {
        return array(
            'background-color' => $this->rowBackgroundColors()
        );
    }

    /**
     * Fetch the background colors assigned to the field rows
     *
     * @return array
     */
    private function rowBackgroundColors()
    {
        return $this->model_styling->rowBackgroundColors($this->site_id, $this->id);
    }
}
