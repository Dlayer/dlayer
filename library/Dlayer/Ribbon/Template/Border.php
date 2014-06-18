<?php
/**
* Border ribbon class, fetches all the data required by the ribbon forms,
* this includes the options for all the select menus and the currently
* defined values for the selected div
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Border.php 1018 2013-09-29 18:18:37Z Dean.Blackborough $
*/
class Dlayer_Ribbon_Template_Border extends Dlayer_Ribbon_Module_Template
{
    /**
    * Fetch the data for the border tool tabs
    * Return the data arrays for the select menus and also the borders
    * defined for the current div so that the values can be preset in the
    * advanced tab assuming that is the tab that is loaded.
    *
    * @param integer $site_id
    * @param integer $template_id
    * @param integer $div_id Id of the selected div
    * @param string $tool Name of the selected tool
    * @param string $tab Name of the selected tool tab
    * @return array
    */
    public function viewData($site_id, $template_id, $div_id, $tool, $tab)
    {
        $this->writeParams($site_id, $template_id, $div_id, $tool, $tab);

        $model_styles = new Dlayer_Model_Ribbon_Styles();

        switch($this->tab) {
            case 'advanced':
                return array('styles'=>$model_styles->borderStyles(),
                'borders'=>$model_styles->assignedBorders($site_id,
                $template_id, $div_id));
            break;

            default:
                return array('styles'=>$model_styles->borderStyles(FALSE));
            break;
        }
    }
}