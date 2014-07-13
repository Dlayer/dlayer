<?php
/**
* Add or edit an image cotegory
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Tool_Image_Category extends Dlayer_Tool_Module_Image
{
    private $model_categories;
    
    /**
    * Add or edit the selected image category, uses the data in the params 
    * array, this data will have already been both validated and prepared 
    * by the tool class
    *
    * @return array Contains relevant id and type of id
    */
    public function process()
    {
        if($this->validated == TRUE) {
            if($this->category_id == NULL) {
                die('add category');                
            } else {
                die('edit category');
            }
        }
    }

    /**
    * Check to see if the information supplied is valid. If all the values
    * are valid the values are written to the $this->params property
    *
    * @param array $params Params post array
    * @param integer $site_id
    * @param integer|NULL $category_id
    * @param integer|NULL $sub_category_id
    * @param integer|NULL $image_id 
    * @return boolean
    */
    public function validate(array $params = array(), $site_id, 
    $category_id=NULL, $sub_category_id=NULL, $image_id=NULL)
    {
        $this->site_id = $site_id;
        $this->category_id = $category_id;
        $this->sub_category_id = $sub_category_id;
        $this->image_id = $image_id;
        
        if($this->validateValues($params) == TRUE &&
        $this->validateData($params) == TRUE) {
            $this->params = $this->prepare($params);
            $this->validated = TRUE;
            return TRUE;
        } else {
            return FALSE;
        }

        return FALSE;
    }

    public function autoValidate(array $params = array(), $site_id, 
    $category_id=NULL, $sub_category_id=NULL, $image_id=NULL)
    {
        // Not currently used by tool, may be used by the presets later
        return FALSE;
    }

    public function autoProcess()
    {
        // Not currently used by tool, may be used by the presets later
    }

    /**
    * Check that the required values have been sent through as part of the
    * params array, another method will validate the values themselves
    *
    * @param array $params Params array to check
    * @return boolean TRUE if the required values exists in the array
    */
    private function validateValues(array $params = array())
    {
        if(array_key_exists('name', $params) == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
    * Check that the submitted data values are all in the correct format 
    * and that the values themselves are valid
    *
    * @param array $params Params array to check
    * @return boolean TRUE if the values are valid
    */
    private function validateData(array $params = array())
    {
        $this->model_categories = new Dlayer_Model_Image_Categories();
        
        if(strlen(trim($params['name'])) > 0 && 
        $this->model_categories->categoryExists($this->site_id, 
        trim($params['name'])) == FALSE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
    * Prepare the data, converts all the array values to the required data
    * type and trims and string values, called after the data has been
    * validated
    *
    * @param array $params Params array to prepare
    * @return array Prepared data array
    */
    protected function prepare(array $params)
    {
        return array('name'=>trim($params['name']));
    }
}