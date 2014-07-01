<?php
/**
* Category tool ribbon data class
* 
* Returns the data for the requested tool tab ready to be passed to the view
* script. The methods needs to return an array, other than that there are no
* specific requirents for ribbon tool data classes.
*
* Each view file needs to check for the expected indexes, tools and tool tabs
* can and do operate differently
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Ribbon_Image_Category extends Dlayer_Ribbon_Module_Image
{
    /**
    * Instantiate and return the form to add or edit a text field
    *
    * @param integer $site_id Current site id
    * @param string $tool Name of the selected tool
    * @param string $tab Name of the selected tool tab
    * @param integer|NULL $image_id Id of the selected image
    * @param integer|NULL $category_id Id of the selected category
    * @param integer|NULL $subcategory_id Id of the selected subcategory
    * @param boolean $edit_mode Is the tool tab in edit mode
    * @return array|FALSE Either an array of data for the tool tab view script 
    *                    or FALSE if no data is found or required, up to the 
    *                    view script how to handle the return value
    */
    public function viewData($site_id, $tool, $tab, $image_id=NULL, 
    $category_id=NULL, $subcategory_id=NULL, $edit_mode=FALSE)
    {
        $this->writeParams($site_id, $tool, $tab, $image_id, $category_id, 
        $subcategory_id, $edit_mode);

        return array('form'=>new Dlayer_Form_Image_Category(
        $this->existingData(), $this->edit_mode));
    }
    
    /**
    * Fetch the existing data array
    * 
    * @return array
    */
    protected function existingData() 
    {
        return array('id'=>FALSE, 'name'=>FALSE);
    }
}