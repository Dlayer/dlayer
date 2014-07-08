<?php
/**
* Import form ribbon class, returns the form for the tab view script, If the 
* user is in edit model the form will be pre -opulated with the currently 
* saved values
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: ImportForm.php 1928 2014-06-12 13:53:38Z Dean.Blackborough $
*/
class Dlayer_Ribbon_Content_ImportForm extends Dlayer_Ribbon_Module_Content
{
    /**
    * Data method for the import form tab, returns the form for the view
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

        return array('form'=>new Dlayer_Form_Content_ImportForm(
        $this->page_id, $this->div_id, $this->container(), 
        $this->existingData(), $this->edit_mode, $this->multi_use), 
        'preview_data'=>$this->previewData());
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
            $model_form = new Dlayer_Model_Page_Content_Items_Form();
            $dimensions = $model_form->boxDimensions($this->content_id,
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
    * If a content id exists return a data array for the form otherwise
    * return an array with FALSE for each of the values, we do this so we 
    * can easily default the values at a later point
    *
    * @return array
    */
    protected function existingData()
    {
    	$data = array('id'=>FALSE, 'width'=>FALSE, 'padding'=>FALSE);
    	
        if($this->content_id != NULL) {
        	
            $model_form = new Dlayer_Model_Page_Content_Items_Form();
            $set_data = $model_form->formParams($this->content_id, 
            $this->site_id,$this->page_id, $this->div_id);
            
            $form_id = $model_form->formId($this->site_id, $this->content_id);
        	
            if($set_data != FALSE && $form_id != FALSE) {
				$data = $set_data;
                $data['minimum_width'] = $model_form->minimumWidth(
                $this->site_id, $form_id);
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
            
            $model_form = new Dlayer_Model_Page_Content_Items_Form();
            $dimensions = $model_form->boxDimensions($this->content_id, 
            $this->site_id, $this->page_id, $this->div_id);
            
            $model_position = new Dlayer_Model_Page_Content_Position();
            $positions = $model_position->marginValues($this->site_id, 
            $this->page_id, $this->div_id, $this->content_id, 'form');
            
            $model_template_div = new Dlayer_Model_Template_Div();
            $page_container_width = $model_template_div->width(
            $this->site_id, $this->div_id);
            
            $data['width'] = $dimensions['width'];
            $data['padding']['right'] = $dimensions['padding'];
            $data['padding']['left'] = $dimensions['padding'];
            $data['padding']['width'] = $dimensions['padding'];
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