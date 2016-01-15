<?php
/**
* Background color ribbon class, fetches the colors that have been defined for
* the requested tab/palette
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Ribbon_Template_BackgroundColor extends
Dlayer_Ribbon_Module_Template
{
    /**
    * Fetch the colors assigned to the requested color palette, if the
    * user is viewing the advanced tab of the background color tool the
    * currently set background color will be retured or FALSE
    *
    * @param integer $site_id
    * @param integer $template_id
    * @param integer $div_id Id of the selected div
    * @param string $tool Name of the selected tool
    * @param string $tab Name of the selected tool tab
    * @return array|FALSE
    */
    public function viewData($site_id, $template_id, $div_id, $tool, $tab)
    {
        $this->writeParams($site_id, $template_id, $div_id, $tool, $tab);

        switch($this->tab) {
            case 'advanced':
            	return $this->backgroundColor();
            break;

            default:
                return $this->palette();
            break;
        }
    }
    
    /**
    * Fetch the current background colour, passed to the form to preset the 
    * input
    * 
    * @return array|FALSE
    */
    private function backgroundColor() 
    {
    	$model_background_color = 
    	new Dlayer_Model_Template_Div_BackgroundColor();
    	return $model_background_color->existingBackgroundColor($this->site_id, 
    	$this->template_id, $this->div_id);
    }

    /**
    * Fetch the colors that have been defined for the requested color palette
    *
    * @return array|FALSE
    */
    private function palette()
    {
        $model_palette = new Dlayer_Model_Palette();
        return $model_palette->colorsByPaletteTab($this->site_id, $this->tab);
    }
}
