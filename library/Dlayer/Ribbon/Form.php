<?php

/**
 * Base class for the Form Builder ribbons
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
abstract class Dlayer_Ribbon_Form
{
    protected $tool;

    /**
     * @var bool Has the call to the field data been made and data set
     */
    protected $field_data_fetched = false;

    /**
     * @var array The data for the field data
     */
    protected $field_data = array();

    /**
     * @var boolean Has the preview data been fetched
     */
    protected $preview_data_fetched = false;

    /**
     * @var array Preview data
     */
    protected $preview_data = array();

    /**
     * @var boolean Has the element input data already been requested
     */
    protected $element_data_fetched = false;

    /**
     * @var array Element data array
     */
    protected $element_data = array();

    /**
     * Fetch the view data for the current tool tab, typically the returned array will have at least two indexes,
     * one for the form and another with the data required by the preview functions
     *
     * @param array $tool Tool and environment data
     * @return array
     */
    abstract public function viewData(array $tool);

    /**
     * Fetch the data array for the field, if in edit mode mode populate the values otherwise every value is
     * set to false, the tool form can simply check to see if the value is false or not and then set the
     * existing value
     *
     * @return array
     */
    abstract protected function fieldData();
}
