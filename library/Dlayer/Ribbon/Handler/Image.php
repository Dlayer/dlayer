<?php
/**
* Ribbon data class pulls the data that is required for the requested tool 
* and tab, this could be data to help build the forms or data about the 
* selected item/element. This class is similar for each module, differences 
* being between the params required to call for the data. This class hands 
* of all the calls to individual ribbon classes, it just acts as the 
* interface
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Ribbon_Handler_Image
{
    private $site_id;
    private $tool;
    private $tab;
    private $image_id;
    private $version_id;
    private $category_id;
    private $subcategory_id;
    private $edit_mode;
    private $multi_use;
    
    /**
    * Fetches all the data that is needed by the views to generate the 
    * html and forms for the requested tool and tab
    * 
    * @param integer $site_id Current site id
    * @param string $tool Name of the selected tool
    * @param string $tab Name of the selected tool tab
    * @param integer $multi_use Multi use value for tool tab
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
    $version_id=NULL, $category_id=NULL, $subcategory_id=NULL, $edit_mode=FALSE) 
    {
        $this->site_id = $site_id;
        $this->tool = $tool;
        $this->tab = $tab;
        $this->multi_use = $multi_use;
        $this->image_id = $image_id;
        $this->version_id = $version_id;
        $this->category_id = $category_id;
        $this->subcategory_id = $subcategory_id;
        $this->edit_mode = $edit_mode;

        switch($this->tool) {
            case 'Add':
                $data = $this->add();
            break;
            
            case 'Category':
                $data = $this->category();
            break;
            
            case 'SubCategory':
                $data = $this->subcategory();
            break;
            
            case 'Copy':
                $data = $this->copy();
            break;
            
            case 'Edit':
                $data = $this->edit();
            break;
            
            default:
                $data = FALSE;
            break;
        }
        
        return $data;
    }
    
    /**
    * Fetch the view tab data for the category tool, in this case typically the 
    * form for the tool tab, if there is any existing data (edit mode) the 
    * form will show the current values
    * 
    * @return array|FALSE 
    */
    private function category() 
    {
        switch($this->tab) {
            case 'category':
                $ribbon_category = new Dlayer_DesignerTool_ImageLibrary_Category_Ribbon();
                $data = $ribbon_category->viewData($this->site_id, $this->tool, 
                $this->tab, $this->multi_use, $this->image_id, 
                $this->version_id, $this->category_id, $this->subcategory_id, 
                $this->edit_mode);
            break;
            
            default:
                $data = FALSE;
            break;
        }
        
        return $data;
    }
    
    /**
    * Fetch the view tab data for the sub category tool, in this case 
    * typically the form for the tool tab, if there is any existing data 
    * (edit mode) the form will show the current values
    * 
    * @return array|FALSE 
    */
    private function subcategory() 
    {
        switch($this->tab) {
            case 'sub-category':
                $ribbon_subcategory = new Dlayer_DesignerTool_ImageLibrary_SubCategory_Ribbon();
                $data = $ribbon_subcategory->viewData($this->site_id, 
                $this->tool, $this->tab, $this->multi_use, $this->image_id, 
                $this->version_id, $this->category_id, $this->subcategory_id, 
                $this->edit_mode);
            break;
            
            default:
                $data = FALSE;
            break;
        }
        
        return $data;
    }
    
    /**
    * Fetch the view tab data for the add new image tool, in this case 
    * the form for the tool tab
    * 
    * @return array|FALSE 
    */
    private function add() 
    {
        switch($this->tab) {
            case 'add':
                $ribbon_add = new Dlayer_Ribbon_Image_Add();
                $data = $ribbon_add->viewData($this->site_id, $this->tool, 
                $this->tab, $this->multi_use, $this->image_id, 
                $this->version_id, $this->category_id, $this->subcategory_id, 
                $this->edit_mode);
            break;
            
            default:
                $data = FALSE;
            break;
        }
        
        return $data;
    }
    
    /**
    * Fetch the view tab data for the copy image tool, in this case the form 
    * for the tool tab
    * 
    * @return array|FALSE 
    */
    private function copy() 
    {
        switch($this->tab) {
            case 'copy':
                $ribbon_copy = new Dlayer_Ribbon_Image_Copy();
                $data = $ribbon_copy->viewData($this->site_id, $this->tool, 
                $this->tab, $this->multi_use, $this->image_id, 
                $this->version_id, $this->category_id, $this->subcategory_id, 
                $this->edit_mode);
            break;
            
            default:
                $data = FALSE;
            break;
        }
        
        return $data;
    }
    
    /**
    * Fetch the view tab data for the edit image tool, in this case the form 
    * for the tool tab
    * 
    * @return array|FALSE 
    */
    private function edit() 
    {
        switch($this->tab) {
            case 'edit':
                $ribbon_edit = new Dlayer_Ribbon_Image_Edit();
                $data = $ribbon_edit->viewData($this->site_id, $this->tool, 
                $this->tab, $this->multi_use, $this->image_id, 
                $this->version_id, $this->category_id, $this->subcategory_id, 
                $this->edit_mode);
            break;
            
            default:
                $data = FALSE;
            break;
        }
        
        return $data;
    }
}
