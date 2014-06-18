<?php
/**
* Text ribbon data class, returns the form for the tab view script. If
* in edit mode the form will be populated with the data for the text
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Text.php 1949 2014-06-16 00:34:49Z Dean.Blackborough $
*/
class Dlayer_Ribbon_Content_Text extends Dlayer_Ribbon_Module_Content
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

        return array('form'=>new Dlayer_Form_Content_Text($this->page_id,
        $this->div_id, $this->container(), $this->existingData(), 
        $this->edit_mode));
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

        if($this->content_id == NULL) {
            if($width > 20) {
                return array('width'=>($width-20), 'padding'=>10);
            } else {
                return array('width'=>$width, 'padding'=>0);
            }
        } else {
            $model_text = new Dlayer_Model_Page_Content_Items_Text();
            $dimensions = $model_text->boxDimensions($this->content_id,
            $this->site_id, $this->page_id, $this->div_id);
            if($dimensions != FALSE) {
                return array('width'=>$dimensions['width'],
                'padding'=>$dimensions['padding']);
            } else {
                return array('width'=>$width, 'padding'=>0);
            }
        }
    }
    
    /**
    * Fetch the data for the selected content block
    *
    * If a content id exists return a data array for the text item otherwise
    * return an array with FALSE for each of the values, we do this so we 
    * can easily default the values at a later point
    *
    * @return array
    */
    protected function existingData()
    {
    	$data = array('id'=>FALSE, 'content'=>FALSE);
    	
        if($this->content_id != NULL) {        	
        	$model_text = new Dlayer_Model_Page_Content_Items_Text();
            $set_data = $model_text->formData($this->content_id, 
            $this->site_id,$this->page_id, $this->div_id);
        	
            if($set_data != FALSE) {
				$data = $set_data;
            }
		}
		
		return $data;
    }
}