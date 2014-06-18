<?php
/**
* Add or edit a form content item, only responsible for the container data 
* and the id of the form being linked, the form is managed within the form 
* builder
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: ImportForm.php 1861 2014-05-27 11:30:18Z Dean.Blackborough $
*/
class Dlayer_Tool_Content_ImportForm extends Dlayer_Tool_Module_Content
{
    protected $content_type = 'form';

    /**
    * Import a form from the form builder or edit the container for a 
    * previously imported form. The data will have already been validated and 
    * prepared, the process method can just process the request
    *
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @param integer|NULL $content_id
    * @return integer The new content id or the existing content id
    */
    public function process($site_id, $page_id, $div_id,
    $content_id=NULL)
    {
        if($this->validated == TRUE) {
            if($content_id == NULL) {
                $content_id = $this->addContentItem($site_id, $page_id, 
                $div_id, $this->content_type);
            } else {
                $this->editContentItem($site_id, $page_id, $content_id);
            }

            return $content_id;
        }
    }

    /**
    * Check to see if the information supplied in the params array is valid,
    * if valid the data is written to the $this->parans array and the
    * $this->validated property is set to TRUE
    *
    * @param array $params Params $_POST array
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @return boolean TRUE if requested is valid, also sets the $this->params
    *                 property and set $this->validated to TRUE
    */
    public function validate(array $params = array(), $site_id, $page_id,
    $div_id)
    {
        if($this->validateValues($params) == TRUE &&
        $this->validateData($params, $site_id, $page_id, $div_id) == TRUE) {
            $this->params = $this->prepare($params);
            $this->validated = TRUE;
            return TRUE;
        } else {
            return FALSE;
        }

        return FALSE;
    }

    public function autoValidate(array $params = array())
    {
        // Not currently used by tool, may be used by the presets later
        return FALSE;
    }

    public function autoProcess($site_id, $page_id, $div_id,
    $content_id=NULL)
    {
        // Not currently used by tool, may be used by the presets later
    }

    /**
    * Check that the required values have been posted with the request, 
    * another method will check the validaty of the data, this just checks to 
    * see the indexes exist
    *
    * @param array $params $_POSTed params data array
    * @return boolean TRUE if the required values are in array
    */
    private function validateValues(array $params = array())
    {
        if(array_key_exists('form_id', $params) == TRUE &&
        array_key_exists('width', $params) == TRUE &&
        array_key_exists('padding', $params) == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
    * Check that the submitted data is valid, the format of the data needs to 
    * be valid and the values need to make sense, the form id must exists for 
    * the site and the form must be able to fit into the container
    *
    * 1. The form needs to exist for the site
    * 2. The form container width needs to be greater than 0
    * 3. The padding needs to be greater than or equal to 0
    * 4. The width and padding values need to be less that or equal to the
    * page div width
    * 
    * @todo Add the check to check the width of a form
    * 5. The complete form should be able to fit into the page block
    *
    * @param array $params Params array to validte
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @return boolean TRUE if the values are valid
    */
    private function validateData(array $params = array(), $site_id, $page_id,
    $div_id)
    {
        $model_forms = new Dlayer_Model_Form();
        $model_divs = new Dlayer_Model_Template_Div();
        
        $div_width = $model_divs->width($site_id, $div_id);

        if($model_forms->valid($params['form_id'], $site_id) == TRUE && 
        intval($params['width']) > 0 && intval($params['padding']) >= 0 &&
        (intval($params['width']) + (intval($params['padding']) * 2)) 
        <= $div_width) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
    * Prepare the data, convert the values to the correct data types and trim
    * any string values
    *
    * @param array $params Params array to prepare
    * @return array Prepared data array
    */
    protected function prepare(array $params)
    {
        return array('form_id'=>intval($params['form_id']),
        'width'=>intval($params['width']),
        'padding'=>intval($params['padding']));
    }
    
    /**
    * Assign the form to the page div. Form content item is added to the 
    * page content table, form content table is then supplied with the 
    * container data and related form id
    *
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @param string $content_type
    * @return integer Id for the new content item
    */
    private function addContentItem($site_id, $page_id, $div_id, 
    $content_type)
    {
        $model_content = new Dlayer_Model_Page_Content();
        $content_id = $model_content->addContentItem($site_id, $page_id, 
        $div_id, $content_type);
        
        $model_form = new Dlayer_Model_Page_Content_Items_Form();
        $model_form->addContentItemData($site_id, $page_id, $content_id, $this->params);

        return $content_id;
    }
    
    /**
    * Edit the details for the selected imported form, user can edit the 
    * width, padding and which form they would like imported
    *
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $content_id
    * @return void
    */
    private function editContentItem($site_id, $page_id, $content_id)
    {
        $model_form = new Dlayer_Model_Page_Content_Items_Form();
        $model_form->editContentItemData($site_id, $page_id, $content_id, $this->params);
    }
}