<?php
/**
* Create a new heading content item using an existing piece of text content
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: ImportHeading.php 1949 2014-06-16 00:34:49Z Dean.Blackborough $
*/
class Dlayer_Tool_Content_ImportHeading extends Dlayer_Tool_Module_Content
{
    protected $content_type = 'heading';

    /**
    * Create a new heading content item using existing text, the data will 
    * have already been validated and prepared so the process method can just
    * process the request
    *
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @param integer|NULL $content_id
    * @return integer The new content id or the given content id
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
    * Check that the required values have been posted through with the
    * request, another method will validate the values themselves, no
    * point attempting to validate the data is we don't have the correct
    * data to start with
    *
    * @param array $params $_POSTed params data array
    * @return boolean TRUE if the required values are in array
    */
    private function validateValues(array $params = array())
    {
        if(array_key_exists('name', $params) == TRUE && 
        array_key_exists('heading', $params) == TRUE &&
        array_key_exists('heading_type', $params) == TRUE &&
        array_key_exists('padding_top', $params) == TRUE &&
        array_key_exists('padding_bottom', $params) == TRUE &&
        array_key_exists('padding_left', $params) == TRUE &&
        array_key_exists('width', $params) == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
    * Check that the submitted data is all valid, both the format of the data
    * and the values themselves
    *
    * Checks the following
    *
    * 1. There needs to be content for the heading
    * 2. The heading container width needs to be greater than 0
    * 3. The margin values need to be greater than or larger than 0
    * 4. The width and left margin value need to be equal or less than the
    * page div width
    *
    * @param array $params Params array to validte
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @return boolean TRUE if the values are valid
    */
    private function validateData(array $params=array(), $site_id, $page_id,
    $div_id)
    {
        $model_divs = new Dlayer_Model_Template_Div();
        $width = $model_divs->width($site_id, $div_id);

        if(strlen(trim($params['name'])) > 0 && 
        strlen(trim($params['heading'])) > 0 &&
        intval($params['width']) > 0 &&
        intval($params['padding_top']) >= 0 &&
        intval($params['padding_bottom']) >= 0 &&
        intval($params['padding_left']) >= 0 &&
        (intval($params['width']) + 
        intval($params['padding_left'])) <= $width) {
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
        $prepared = array('heading'=>trim($params['heading']),
        'width'=>intval($params['width']),
        'heading_type'=>intval($params['heading_type']),
        'padding_top'=>intval($params['padding_top']),
        'padding_bottom'=>intval($params['padding_bottom']),
        'padding_left'=>intval($params['padding_left']),
        'name'=>trim($params['name']));
        
        return $prepared;
    }

    /**
    * Add a new heading content item, one the base content item has been added 
    * the new id is used to add the data for the heading content item
    *
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @param string $content_type
    * @return integer Id for the new content item
    */
    private function addContentItem($site_id, $page_id, $div_id, $content_type)
    {
        $model_content = new Dlayer_Model_Page_Content();
        $content_id = $model_content->addContentItem($site_id, $page_id, 
        $div_id, $content_type);

        $model_heading = new Dlayer_Model_Page_Content_Items_Heading();
        $model_heading->addContentItemData($site_id, $page_id, $content_id,
        $this->params);

        return $content_id;
    }

    /**
    * Edit the existing heading, just need to edit the heading data, no need
    * to edit the base content heading data
    *
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $content_id
    * @return void
    */
    private function editContentItem($site_id, $page_id, $content_id)
    {
        $model_headiing = new Dlayer_Model_Page_Content_Items_Heading();
        $model_headiing->editContentItemData($site_id, $page_id, $content_id,
        $this->params);
    }
}