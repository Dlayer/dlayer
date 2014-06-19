<?php
/**
* Heading ribbon data class, returns the form for the tab view script. If
* in edit mode the form will be populated with the data for the heading
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Heading.php 1928 2014-06-12 13:53:38Z Dean.Blackborough $
*/
class Dlayer_Ribbon_Content_Heading extends Dlayer_Ribbon_Module_Content
{
    /**
    * Data method for the heading tab, returns the form for the view
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

        return array('form'=>new Dlayer_Form_Content_Heading($this->page_id,
        $this->div_id, $this->container(), $this->existingData(), 
        $this->edit_mode), 'preview_data'=>$this->previewData()); 
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
            if($width > 5) {
                return array('width'=>($width-5), 'padding_left'=>5);
            } else {
                return array('width'=>$width, 'padding_left'=>0);
            }
        } else {
            $model_heading = new Dlayer_Model_Page_Content_Items_Heading();
            $dimensions = $model_heading->boxDimensions($this->content_id,
            $this->site_id, $this->page_id, $this->div_id);
            if($dimensions != FALSE) {
                return array('width'=>$dimensions['width'],
                'padding_left'=>$dimensions['padding_left']);
            } else {
                return array('width'=>$width, 'padding_left'=>0);
            }
        }
    }
    
    /**
    * Fetch the data for the selected content block
    *
    * If a content id exists return a data array for the heading otherwise
    * return an array with FALSE for each of the values, we do this so we 
    * can easily default the values at a later point
    *
    * @return array
    */
    protected function existingData()
    {
    	$data = array('id'=>FALSE, 'heading'=>FALSE, 'pading_top'=>FALSE, 
    	'padding_bottom'=>FALSE, 'padding_left'=>FALSE, 'heading_id'=>FALSE, 
    	'width'=>FALSE);
    	
        if($this->content_id != NULL) {
            $model_heading = new Dlayer_Model_Page_Content_Items_Heading();
            $set_data = $model_heading->formData($this->content_id, $this->site_id,
            $this->page_id, $this->div_id);
            
            if($set_data != FALSE) {
				$data = $set_data;
            }
		}
		
		return $data;
    }
    
    /**
    * Fetch the preview data requireed by the live editing preview functions
    * 
    * @return array
    */
    protected function previewData() 
    {
        $data = null;
        
        if($this->edit_mode == TRUE) {
            $data = array('content_id'=>$this->content_id);
            
            $model_heading = new Dlayer_Model_Page_Content_Items_Heading();
            $heading_data = $model_heading->formData($this->content_id, 
            $this->site_id, $this->page_id, $this->div_id);
            
            $model_position = new Dlayer_Model_Page_Content_Position();
            $positions = $model_position->marginValues($this->site_id, 
            $this->page_id, $this->div_id, $this->content_id, 'heading');
            
            $model_template_div = new Dlayer_Model_Template_Div();
            $page_container_width = $model_template_div->width(
            $this->site_id, $this->div_id);
            
            $data['width'] = $heading_data['width'];
            $data['padding']['right'] = 0;
            $data['padding']['left'] = $heading_data['padding_left'];
            $data['padding']['top'] = $heading_data['padding_top'];
            $data['padding']['bottom'] = $heading_data['padding_bottom'];
            if($positions != FALSE) {
                $data['margin']['right'] = $positions['right'];
                $data['margin']['left'] = $positions['left'];
            } else {
                $data['margin']['right'] = 0;
                $data['margin']['left'] = 0;
            }
            $data['page_container_width'] = $page_container_width;
        }
        
        return $data;
    }
}