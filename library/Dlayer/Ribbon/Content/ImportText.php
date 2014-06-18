<?php
/**
* Import text ribbon data class, returns the form for the tab view script.
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: ImportText.php 1949 2014-06-16 00:34:49Z Dean.Blackborough $
*/
class Dlayer_Ribbon_Content_ImportText extends Dlayer_Ribbon_Module_Content
{
    /**
    * Data method for the text tab, returns the form for the view
    *
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @param string $tool Name of the selected tool
    * @param string $tab Name of the selected tool tab
    * @param integer|NULL $content_id Selected content item
    * @param boolean $edit_mode Is the tool tab in edit mode
    * @return array|FALSE
    */
    public function viewData($site_id, $page_id, $div_id, $tool, $tab,
    $content_id=NULL, $edit_mode=FALSE)
    {
        $this->writeParams($site_id, $page_id, $div_id, $tool, $tab,
        $content_id, $edit_mode);

        return array('form'=>new Dlayer_Form_Content_ImportText(
        $this->page_id, $this->div_id, $this->container(), 
        $this->existingData(), $this->edit_mode));
    }

    /**
    * Fetch the values for the content item container. 
    * 
    * If the tool is in edit mode we return the current values otherwise 
    * sensible defaults are calculated based on the parent page div.
    *
    * @return array
    */
    protected function container()
    {
        $model_div = new Dlayer_Model_Template_Div();
        $width = $model_div->width($this->site_id, $this->div_id);

        if($width > 20) {
            return array('width'=>($width-20), 'padding'=>10);
        } else {
            return array('width'=>$width, 'padding'=>0);
        }
    }
    
    /**
    * Fetch the data for the selected content block, typically the method 
    * returns the existing data when in edit mode, for this tool it returns 
    * and empty array because there is no edit version for the tool
    * 
    * @return array
    */
    protected function existingData()
    {
    	return array();
    }
}