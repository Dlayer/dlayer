<?php
/**
* Ribbon data class pulls the data that is required for the requested tool 
* and tab, this could be data to help build the forms or data about the 
* selected item/element. This class is similar for each model, differences 
* being between the params required to call for the data. This class hands 
* of all the calls to individual ribbon classes, it just acts as the 
* interface
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Ribbon_Data_Template 
{
    private $site_id;
    private $template_id;
    private $div_id;
    private $tool;
    private $tab;
    private $multi_use;
    
    /**
    * Fetch the data for the tool and tab using the supplied params, the 
    * resulting array is passed to the view script, each ribbon tool tab view 
    * script uses the data in its own way
    * 
    * @param integer $site_id Current site id
    * @param integer $template_id Current template id
    * @param integer $div_id Id of the selected div
    * @param string $tool Name of the selected tool
    * @param string $tab Name of the selected tool tab
    * @param integer $multi_use Multi use value for tool tab
    * @return array|FALSE Either an array of data for the tool tab view script 
    *                    or FALSE if no data is found or required, up to the 
    *                    view script how to handle the return value
    */
    public function viewData($site_id, $template_id, $div_id, $tool, $tab,
    $multi_use) 
    {
        $this->site_id = $site_id;
        $this->template_id = $template_id;
        $this->div_id = $div_id;
        $this->tool = $tool;
        $this->tab = $tab;
        $this->multi_use = $multi_use;
        
        switch($this->tool) {
            case 'background-color':
                $data = $this->backgroundColor();
            break;
            
            case 'resize':
                $data = $this->resize();
            break;
            
            case 'border':
                $data = $this->border();
            break;
            
            default:
                $data = FALSE;
            break;
        }
        
        return $data;
    }
    
    /**
    * Fetch the background colors for the palette that matches the requested 
    * tool tab
    * 
    * @return array|FALSE 
    */
    private function backgroundColor() 
    {
        $ribbon_background_color = new Dlayer_Ribbon_Template_BackgroundColor();
        return $ribbon_background_color->viewData($this->site_id, 
        $this->template_id, $this->div_id, $this->tool, $this->tab);
    }
    
    /**
    * Fetch the data for the resize tabs
    * 
    * @return array|FALSE 
    */
    private function resize() 
    {
        switch($this->tab) {
            case 'contract':
            case 'expand':
                $ribbon_resize = new Dlayer_Ribbon_Template_Resize();
                $data = $ribbon_resize->viewData($this->site_id, 
                $this->template_id, $this->div_id, $this->tool, $this->tab);
            break;
            
            case 'advanced':
                $data = array();
            break;
            
            default:
                $data = FALSE;
            break;
        }
        
        return $data;
    }
    
    /**
    * Fetch all the data for the border tabs
    * 
    * @todo The full border tab doesn't set the value in the select menus for 
    * thick/thin etc, need to also maybe highlight if one of the settings is 
    * currently set
    * 
    * @return array|FALSE 
    */
    private function border() 
    {
        switch($this->tab) {
            case 'help':
                return FALSE;
            break;
            
            default:
                $ribbon_border = new Dlayer_Ribbon_Template_Border();
                return $ribbon_border->viewData($this->site_id, 
                $this->template_id, $this->div_id, $this->tool, $this->tab);
            break;
        }
    }
}
