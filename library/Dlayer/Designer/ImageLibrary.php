<?php
/**
* Base designer class for the image library, brings together all the data 
* required to generated the html for the Image library designer view
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Designer_ImageLibrary
{
    private $site_id;

    private $image_id = NULL;
    
    private $category_id;
    private $sub_category_id;
    private $sort;
    private $order;

    /**
    * Initialise the object, run setup methods and set initial properties
    *
    * @param integer $site_id
    * @param integer $category_id Id of the selected filter category
    * @param integer $sub_category_id Id of the selected filter sub category
    * @param string $sort Current sort method
    * @param string $order Current sort order
    * @param integer|NULL $image_id Id of the selected library image, if any
    * @return void
    */
    public function __construct($site_id, $category_id, $sub_category_id, 
    $sort, $order, $image_id=NULL)
    {
        $this->site_id = $site_id;
        $this->category_id = $category_id;
        $this->sub_category_id = $sub_category_id;
        $this->sort = $sort;
        $this->order = $order;
        $this->image_id = $image_id;
    }
    
    /**
    * Fetch the images for the selected category and sub category, sorted 
    * by the currently set sort, the results array is already sorted into 
    * rows so the view doesn't need to do too much work - There are 7 
    * thumbnails per row
    * 
    * @todo Need to add pagination
    * @todo The thumbnail size and as a consequence the number per row needs 
    * to be configurable, the user shousl be able to view the images at 2/3 
    * different view sizes
    * @return array If there are no images we still return and empty array
    */
    public function images() 
    {
        $model_image_library = new Dlayer_Model_Image_Library();
        
        $images = $model_image_library->images($this->site_id, 
        $this->category_id, $this->sub_category_id, $this->sort, $this->order);
        
        return $images;
    }
}