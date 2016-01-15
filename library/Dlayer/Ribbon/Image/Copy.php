<?php
/**
* Copy image tool ribbon data class
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
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Ribbon_Image_Copy extends Dlayer_Ribbon_Module_Image
{
    /**
    * Instantiate and return the form to add or edit a text field
    *
    * @param integer $site_id Current site id
    * @param string $tool Name of the selected tool
    * @param string $tab Name of the selected tool tab
    * @param integer $multi_use Multi use setting for tool tab
    * @param integer|NULL $image_id Id of the selected image
    * @param integer|NULL $version_id Id of the selected image version
    * @param integer|NULL $category_id Id of the selected category
    * @param integer|NULL $subcategory_id Id of the selected subcategory
    * @param boolean $edit_mode Is the tool tab in edit mode
    * @return array|FALSE Either an array of data for the tool tab view script 
    *                    or FALSE if no data is found or required, up to the 
    *                    view script how to handle the return value
    */
    public function viewData($site_id, $tool, $tab, $multi_use, $image_id=NULL, 
    $version_id=NULL, $category_id=NULL, $subcategory_id=NULL, 
    $edit_mode=FALSE)
    {
        $this->writeParams($site_id, $tool, $tab, $multi_use, $image_id, 
        $version_id, $category_id, $subcategory_id, $edit_mode);

        return array('form'=>new Dlayer_Form_Image_Copy(
        $this->existingData(), $this->edit_mode, $this->multi_use));
    }
    
    /**
    * Fetch the existing data array, contains data for edit version of tool 
    * or data required by tool
    * 
    * @return array
    */
    protected function existingData() 
    {
        return array('image_id'=>$this->image_id, 
        'version_id'=>$this->version_id);
    }
}