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

    private $image_id;
    private $version_id;
    
    private $category_id;
    private $sub_category_id;
    private $sort;
    private $order;
    
    private $model_library;
    private $model_categories;
    private $model_image;

    /**
    * Initialise the object, run setup methods and set initial properties
    *
    * @param integer $site_id
    * @param integer $category_id Id of the selected filter category
    * @param integer $sub_category_id Id of the selected filter sub category
    * @param string $sort Current sort method
    * @param string $order Current sort order
    * @param integer|NULL $image_id Id of the selected library image, if any
    * @param integer|NULL $version_id Id of the selected library image version
    * @return void
    */
    public function __construct($site_id, $category_id, $sub_category_id, 
    $sort, $order, $image_id=NULL, $version_id=NULL)
    {
        $this->site_id = $site_id;
        $this->category_id = $category_id;
        $this->sub_category_id = $sub_category_id;
        $this->sort = $sort;
        $this->order = $order;
        $this->image_id = $image_id;
        $this->version_id = $version_id;
        
        $this->model_library = new Dlayer_Model_Image_Library();
        $this->model_categories = new Dlayer_Model_Image_Categories();
        $this->model_image = new Dlayer_Model_Image_Image();
    }
    
    /**
    * Fetch the images for the selected category and sub category, sorted 
    * by the currently set sort, the results array is already sorted into 
    * rows so the view doesn't need to do too much work - In the default view 
    * there are 6 thumbnails per row
    * 
    * @todo Need to add pagination
    * @todo The thumbnail size and as a consequence the number per row needs 
    * to be configurable, the user should be able to view the images at 2/3 
    * different view sizes
    * @return array If there are no images we still return and empty array
    */
    public function images() 
    {
        $images = $this->model_library->images($this->site_id, 
        $this->category_id, $this->sub_category_id, $this->sort, $this->order);
        
        return $this->sortIntoRows($images);
    }
    
    /**
    * Fetch all the data for the image detail page
    * 
    * @return array|FALSE Returns all the details for the selected image and 
    *                     version
    */
    public function detail() 
    {
        $detail = $this->model_image->detail($this->site_id, $this->image_id, 
        $this->version_id);
        
        if($detail != FALSE) {
            $detail['size'] = $this->model_library->readableFilesize(
            $detail['size']);
        }
        
        return $detail;
    }
    
    /**
    * Sort the images into rows
    * 
    * @param array $imagges Array of images for selected category and 
    *                       sub category
    * @param integer $per_row Number of items in each row
    * @return array containing rows for image library
    */
    private function sortIntoRows($images, $per_row=6) 
    {
        $rows = array();
        $row = 0;
        $count = 0;
        
        foreach($images as $image) {
            $count++;            
            if($count % ($per_row + 1) == 0) {
                $row++;
            }            
            
            $rows[$row][] = $image;
        }
        
        return $rows;
    }
    
    /**
    * Fetch the data to generate the title, we need to the id for the category, 
    * as well as the name for the category and sub category
    * 
    * @return string
    */
    public function titleData() 
    {
        $catgeory = $this->model_categories->category($this->site_id, 
        $this->category_id);
        
        $sub_category = $this->model_categories->subCategory(
        $this->site_id, $this->category_id, $this->sub_category_id);
        
        return array('category'=>$catgeory, 'sub_category'=>$sub_category);
    }
    
    /**
    * Fetch the categories and sub categories for the selected category so 
    * the filter form can be created
    * 
    * @return Dlayer_Form_Image_Filter
    */
    public function filterForm() 
    {
        $form = new Dlayer_Form_Image_Filter(
        $this->model_categories->categories($this->site_id), 
        $this->model_categories->subCategories($this->site_id, 
        $this->category_id), $this->category_id, $this->sub_category_id);
        
        return $form;
    }
}