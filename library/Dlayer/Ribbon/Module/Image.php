<?php
/**
* The ribbon classes return all the data required to generate the view for the
* selected ribbon tab. Some of these classes are very simple, some are much
* more completed, by extending this abstract class we ensure some consistency
* as the complexity of the application grows.
*
* Ribbon models only have one public method, viewData(), this should return
* either an array containing the required data or FALSE is there is no data,
* the format of the data depends on both tghe requested tool and the requested
* tabl, all we require is an array or FALSE, the view script works out
* what it needs to do with the array
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
abstract class Dlayer_Ribbon_Module_Image
{
    protected $site_id;
    protected $tool;
    protected $tab;
    protected $multi_use;
    protected $image_id;
    protected $version_id;
    protected $category_id;
    protected $subcategory_id;
    protected $edit_mode;

    /**
    * Data method for the content manager designer ribbons, returns the data
    * required by the view for the requested tool and tab.
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
    abstract public function viewData($site_id, $tool, $tab, $multi_use, 
    $image_id=NULL, $image_id=NULL, $category_id=NULL, $subcategory_id=NULL, 
    $edit_mode=FALSE);

    /**
    * Take the supplied params and write them to the class properties
    *
    * @param integer $site_id Current site id
    * @param string $tool Name of the selected tool
    * @param string $tab Name of the selected tool tab
    * @param integer $multi_use Multu use setting for tool tab
    * @param integer|NULL $image_id Id of the selected image
    * @param integer|NULL $version_id Id of the selected image version
    * @param integer|NULL $category_id Id of the selected category
    * @param integer|NULL $subcategory_id Id of the selected subcategory
    * @param boolean $edit_mode Is the tool tab in edit mode
    * @return array|FALSE
    */
    protected function writeParams($site_id, $tool, $tab, $multi_use, 
    $image_id, $version_id, $category_id, $subcategory_id, $edit_mode)
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
    }
    
    /**
    * Fetch the default data for the tool forms, either pulls the currently 
    * set data or allows us to define the initial values
    *
    * @return array
    */
    abstract protected function existingData();
}
