<?php
/**
* Base template designer class, manages all the high level data for generating
* the template in the designer.
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Designer_Template
{
    private $site_id;
    private $template_id;
    private $div_id = NULL;

    private $styles;

    private $model_template;

    /**
    * Initialise the object, run setup methods and set initial properties
    *
    * @param integer $site_id
    * @param integer $template_id
    * @param integer|NULL $div_id
    */
    public function __construct($site_id, $template_id, $div_id=NULL)
    {
        $this->site_id = $site_id;
        $this->template_id = $template_id;
        $this->div_id = $div_id;

        $this->styles = array();

        $this->model_template = new Dlayer_Model_View_Template();
    }

    /**
    * Fetch the template data array, all the divs that make up the template are
    * pulled and arranged in a multi dimensional div. The styles and content
    * are attached to the divs as the template array is looped through

    * @return array
    */
    public function template()
    {
        return $this->model_template->template($this->site_id,
        $this->template_id);
    }

    /**
    * Fetch the styles assigned to the template divs, we pull all the styles
    * as a seperate array and the styles are attached as the template array
    * is looped through by the view
    *
    * @return array Indexed array of styles
    */
    public function styles()
    {
        return $this->styles;
    }
}