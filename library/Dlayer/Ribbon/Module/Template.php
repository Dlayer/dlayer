<?php
/**
* The ribbon classes return all the data required to generate the view for the
* selected ribbon tab. Some of these classes are very simple, some are much
* more completed, by extending this abstract class we ensure some consistency
* as the complexity of the application grows.
*
* Ribbon models only have one public method, viewData(), this should return
* either an array containing the required data or FALSE is there is no data,
* the format of the data depends on both tghe requested tool and the requested
* tabl, all we require is an array or FALSE, the view script works out
* what it needs to do with the array
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
abstract class Dlayer_Ribbon_Module_Template
{
    protected $site_id;
    protected $template_id;
    protected $div_id;
    protected $tool;
    protected $tab;

    /**
    * Data method for the template designer ribbons, returns the data
    * required by the view for the requested tool and tab.
    *
    * @param integer $site_id
    * @param integer $template_id
    * @param integer $div_id Id of the selected div
    * @param string $tool Name of the selected tool
    * @param string $tab Name of the selected tool tab
    * @return array|FALSE
    */
    abstract public function viewData($site_id, $template_id, $div_id, $tool,
    $tab);

    /**
    * Take the supplied params and write them to the private properties
    *
    * @param integer $site_id
    * @param integer $template_id
    * @param integer $div_id Id of the selected div
    * @param string $tool Name of the selected tool
    * @param string $tab Name of the selected tool tab
    * @return array|FALSE
    */
    protected function writeParams($site_id, $template_id, $div_id, $tool,
    $tab)
    {
        $this->site_id = $site_id;
        $this->template_id = $template_id;
        $this->div_id = $div_id;
        $this->tool = $tool;
        $this->tab = $tab;
    }
}
