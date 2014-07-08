<?php
/**
* Text content item tool position tab data class, returns the form for the 
* position tab pre-populated with any existing data
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Text.php 1961 2014-06-17 00:01:52Z Dean.Blackborough $
*/
class Dlayer_Ribbon_Content_Position_Text extends 
Dlayer_Ribbon_Module_Content
{
    /**
    * Data method for the text tool position tab, returns the form 
    * pre-populated with any existing values
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
        
        return array('form'=>new Dlayer_Form_Content_Position_Text(
        $this->page_id, $this->div_id, array(), $this->existingData(), 
        $this->edit_mode, $this->multi_use), 
        'page_container_width'=>$this->pageContainerWidth(), 
        'content_container_width'=>$this->contentContainerWidth(), 
        'preview_data'=>$this->previewData());
    }

    /**
    * Fetch the current position data for the content container, always returns 
    * an array, values may however be FALSE for certain indexes, there will be 
    * an index for each position input on the form
    * 
    * @return array 
    */
    protected function existingData()
    {
    	$model_position = new Dlayer_Model_Page_Content_Position();
    	
    	$margins = $model_position->marginValues($this->site_id, $this->page_id, 
    	$this->div_id, $this->content_id, 'text');
    	
    	if($margins == FALSE) {
			return array('content_id'=>$this->content_id, 'top'=>FALSE, 
			'right'=>FALSE, 'bottom'=>FALSE, 'left'=>FALSE);
    	} else {
			return $margins;
    	}
    }
    
    /**
    * Fetch the width for the page container
    * 
    * @todo This needs to be moved to a base class, duplicated in the three 
    * ribbon data classes
    * 
    * @return integer
    */
    private function pageContainerWidth() 
    {
		$model_div = new Dlayer_Model_Template_Div();
		return $model_div->width($this->site_id, $this->div_id);
    }
    
    /**
    * Fetch the width of the item container
    * 
    * @return integer Defaults to 0 if content id not selected althrough 
    * 				  currently there is no way for the datavase to be called 
    * 				  if a content id hasn't been set	 
    */
    private function contentContainerWidth() 
    {
    	$width = 0;
    	
    	if($this->content_id != NULL) {
			$model_content_text = new Dlayer_Model_Page_Content_Items_Text();
			$dimensions = $model_content_text->boxDimensions($this->content_id, 
			$this->site_id, $this->page_id, $this->div_id);
			
			$width = intval($dimensions['width']) + 
			intval($dimensions['padding']) * 2;
    	}
    	
    	return $width;
    }
    
    protected function container() { }
    
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
            
            $model_text = new Dlayer_Model_Page_Content_Items_Text();
            $dimensions = $model_text->boxDimensions($this->content_id, 
            $this->site_id, $this->page_id, $this->div_id);
            
            $model_position = new Dlayer_Model_Page_Content_Position();
            $positions = $model_position->marginValues($this->site_id, 
            $this->page_id, $this->div_id, $this->content_id, 'text');
            
            $model_template_div = new Dlayer_Model_Template_Div();
            $page_container_width = $model_template_div->width(
            $this->site_id, $this->div_id);
            
            $data['width'] = $dimensions['width'];
            $data['padding']['right'] = $dimensions['padding'];
            $data['padding']['left'] = $dimensions['padding'];
            if($positions != FALSE) {
                $data['margin']['top'] = $positions['top'];
                $data['margin']['right'] = $positions['right'];
                $data['margin']['bottom'] = $positions['bottom'];
                $data['margin']['left'] = $positions['left'];
            } else {
                $data['margin']['top'] = 0;
                $data['margin']['right'] = 0;
                $data['margin']['left'] = 0;
                $data['margin']['bottom'] = 0;
            }
            $data['page_container_width'] = $page_container_width;
        }
        
        return $data;
    }
}