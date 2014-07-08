<?php
/**
* Styling sub tool ribbon data class for the name field tool
* 
* Returns the data for the requested tool tab ready to be passed to the view, 
* specifically the form
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Name.php 1882 2014-06-01 15:01:22Z Dean.Blackborough $
*/
class Dlayer_Ribbon_Form_Styling_Name extends Dlayer_Ribbon_Module_Form
{
    /**
    * Instantiate and return the form to manage the styling
    *
    * @param integer $site_id
    * @param integer $form_id
    * @param string $tool Name of the selected tool
    * @param string $tab Name of the selected tool tab
    * @param integer|NULL $field_id Id of the form field if in edit mode
    * @param boolean $edit_mode Is the tool tab in edit mode
    * @param return array
    */
    public function viewData($site_id, $form_id, $tool, $tab,
    $field_id=NULL, $edit_mode=FALSE)
    {
        $this->writeParams($site_id, $form_id, $tool, $tab, $field_id, 
        $edit_mode);
        
        $existing_data = $this->existingData();
        $preview_data = NULL;
        
        if($this->edit_mode == TRUE) {        
	        $preview_data = array('field_id'=>$existing_data['field_id'], 
	        'background_color'=>'');
	        if($existing_data['background_color'] != FALSE) {
				$preview_data['background_color'] = 
				$existing_data['background_color'];
	        }
		}

        return array('form'=>new Dlayer_Form_Form_Styling_Name($this->form_id,
        $existing_data, $this->edit_mode), 'preview_data'=>$preview_data);
    }
    
    /**
    * Fetch the current styling data for the form field and row, always 
    * returns an array, values are either FALSE if no existing data or the 
    * existing data. There is an index for each of the styles
    * 
    * @return array 
    */
    protected function existingData()
    {
    	$model_styling = new Dlayer_Model_Form_Styling();
    	
    	$background_color = $model_styling->rowBackgroundColor($this->site_id, 
    	$this->form_id, $this->field_id);
		
		return array('field_id'=>$this->field_id, 
		'background_color'=>$background_color);
    }
}