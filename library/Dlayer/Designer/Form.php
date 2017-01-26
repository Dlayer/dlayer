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
     * Fetch all the styles for the form, styles are returned in an array
     * indexed by form field id. The value will be an array of the style
     * attribute and string. These arrays can then be looped and output above
     * the form
     *
     * @return array
     */
    public function fieldStyles()
    {
        $this->styles = $this->model_form->fieldIds();

        $this->rowBackgroundColors();

        return $this->styles;
    }

    /**
     * Fetch the row background color styles and assign the values to the
     * styles array
     *
     * @return void
     */
    private function rowBackgroundColors()
    {
        $background_colors = $this->model_styling->rowBackgroundColors(
            $this->site_id, $this->id);

        if ($background_colors != false) {
            foreach ($background_colors as $field_id => $color_hex) {
                if (array_key_exists($field_id, $this->styles) == true) {
                    $this->styles[$field_id][] = 'background-color: ' .
                        $color_hex . ';';
                }
            }
        }
    }
}
