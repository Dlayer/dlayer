<?php
/**
* Text tool styling tab data class, returns the form for the styling tab 
* pre-populated with any existing data
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Text.php 1961 2014-06-17 00:01:52Z Dean.Blackborough $
*/
class Dlayer_Ribbon_Content_Styling_Text extends Dlayer_Ribbon_Module_Content
{
    /**
    * Data method for the text tool styling tab, returns the form pre-populated 
    * with any existing values
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
        
        $existing_data = $this->existingData();
        $preview_data = NULL;
        
        if($this->edit_mode == TRUE) {        
	        $preview_data = array('content_id'=>$existing_data['content_id'], 
	        'background_color'=>'');
	        if($existing_data['background_color'] != FALSE) {
				$preview_data['background_color'] = 
				$existing_data['background_color'];
	        }
		}

        return array('form'=>new Dlayer_Form_Content_Styling_Text(
        $this->page_id, $this->div_id, array(), $existing_data, 
        $this->edit_mode, $this->multi_use), 'preview_data'=>$preview_data);
    }

    /**
    * Fetch the current styling data for the content container, always returns 
    * an array, values may however be FALSE for certain indexes, there will be 
    * an index for each styling input on the form
    * 
    * @return array 
    */
    protected function existingData()
    {
    	$model_styling = new Dlayer_Model_Page_Content_Styling();
    	
    	$background_color = $model_styling->backgroundColor($this->site_id, 
    	$this->page_id, $this->div_id, $this->content_id, 'text');
		
		return array('content_id'=>$this->content_id, 
		'background_color'=>$background_color);
    }
    
    protected function container() { }
}