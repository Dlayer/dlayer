<?php
/**
* Form settings ribbon data class
* 
* Returns the data for the requested tool tab ready to the passed to the view 
* script. The method needs to return an array, other than that there are no 
* specific requirements for the vuewData method.
* 
* Each view file needs to check for expected indexes, tools and tool tabs can 
* and do operate differently
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Ribbon_Form_FormSettings extends Dlayer_Ribbon_Module_Form
{
    /**
    * Instantiate and return the form to add or edit a text field
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

        return array('form'=>new Dlayer_Form_Form_FormSettings(
        $this->form_id, array()), 'field_id'=>$field_id, 
        'preview_data'=>array());
    }
}