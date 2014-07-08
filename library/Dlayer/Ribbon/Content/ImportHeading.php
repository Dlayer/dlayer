<?php
/**
* Import heading ribbon data class, returns the form for the tab view script.
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: ImportHeading.php 1949 2014-06-16 00:34:49Z Dean.Blackborough $
*/
class Dlayer_Ribbon_Content_ImportHeading extends Dlayer_Ribbon_Module_Content
{
    /**
    * Data method for the heading tab, returns the form for the view
    *
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @param string $tool Name of the selected tool
    * @param string $tab Name of the selected tool tab
    * @param integer $multi_use Multi use value for tool tab
    * @param integer|NULL $content_id Selected content item
    * @param boolean $edit_mode Is the tool tab in edit mode
    * @return array|FALSE
    */
    public function viewData($site_id, $page_id, $div_id, $tool, $tab,
    $multi_use, $content_id=NULL, $edit_mode=FALSE)
    {
        $this->writeParams($site_id, $page_id, $div_id, $tool, $tab,
        $multi_use, $content_id, $edit_mode);

        return array('form'=>new Dlayer_Form_Content_ImportHeading(
        $this->page_id, $this->div_id, $this->container(), 
        $this->existingData(), $this->edit_mode, $this->multi_use));
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

        if($width > 5) {
            return array('width'=>($width-5), 'padding_left'=>5);
        } else {
            return array('width'=>$width, 'padding_left'=>0);
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