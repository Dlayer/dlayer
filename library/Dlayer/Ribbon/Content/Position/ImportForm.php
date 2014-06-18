<?php
/**
* Import form tool position tab data class, returns the form for the position 
* tab pre-populated with any existing data
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: ImportForm.php 1961 2014-06-17 00:01:52Z Dean.Blackborough $
*/
class Dlayer_Ribbon_Content_Position_ImportForm extends 
Dlayer_Ribbon_Module_Content
{
    /**
    * Data method for the import form tool position tab, returns the form 
    * pre-populated with any existing values
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
        
        $existing_data = $this->existingData();
        $preview_data = NULL;
        
        if($this->edit_mode == TRUE) {
        	foreach($existing_data as $k=>$v) {
        		if($k == 'content_id') { 
					$preview_data[$k] = $v;
        		} else {
					if($v != FALSE) {
						$preview_data['margins'][$k] = $v;
					} else {
						$preview_data['margins'][$k] = 0;
					}
				}
        	}
		}

        return array('form'=>new Dlayer_Form_Content_Position_ImportForm(
        $this->page_id, $this->div_id, array(), $existing_data, 
        $this->edit_mode), 'page_container_width'=>$this->pageContainerWidth(), 
        'content_container_width'=>$this->contentContainerWidth(), 
        'preview_data'=>$preview_data);
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
    	$this->div_id, $this->content_id, 'form');
    	
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
			$model_content_form = new Dlayer_Model_Page_Content_Items_Form();
			$dimensions = $model_content_form->boxDimensions($this->content_id, 
			$this->site_id, $this->page_id, $this->div_id);
			
			$width = intval($dimensions['width']) + 
			intval($dimensions['padding']) * 2;
    	}
    	
    	return $width;
    }
    
    protected function container() { }
}