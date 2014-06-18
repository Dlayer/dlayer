<?php
/**
* Add or edit the position values for the heading content container, manages 
* the margin values
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Heading.php 1861 2014-05-27 11:30:18Z Dean.Blackborough $
*/
class Dlayer_Tool_Content_Position_Heading extends Dlayer_Tool_Module_Content
{
    protected $content_type = 'heading';
    
    /**
    * Update the position (margin) values for the selected content container, 
    * this method uses the params array, all the values will have already been 
    * validated, just need to process the request
    *
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @param integer|NULL $content_id
    * @return integer Content id
    */
    public function process($site_id, $page_id, $div_id, $content_id=NULL)
    {
        if($this->validated == TRUE) {
            $this->setMarginValues($site_id, $page_id, $div_id, $content_id);
        }

        return $content_id;
    }

    /**
    * Check  to see if the data supplied in the params array is valid, if valid 
    * the data is written to the $this->params array and the $this->validated 
    * property is set to TRUE
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
    * Check that the required values have been posted as part of the params 
    * array, another method will validate the values themselves, no point 
    * attempting top validate the data if we don't have all the correct data to 
    * begin with
    *
    * @param array $params $_POSTed params data array
    * @return boolean TRUE if the required values are in array
    */
    private function validateValues(array $params = array())
    {
        if(array_key_exists('top', $params) == TRUE && 
        array_key_exists('right', $params) == TRUE && 
        array_key_exists('bottom', $params) == TRUE && 
        array_key_exists('left', $params) == TRUE && 
        array_key_exists('content_container_id', $params) == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
    * Check to see that the submitted data is all valid, both the form and 
    * the values themselves
    * 
    * Checks the following
    * 
    * 1. Values are all integers
    * 2. Values all equal to or smaller than 1000, table field int 4
    * 3. All values greater than or equal to 0, don't yet support negative 
    * margins
    * 4. Sum of content container and new margin width values is smaller than 
    * or equal to the page container width
    * 
    * @todo Add support for negative margin values
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
    	$model_divs = new Dlayer_Model_Template_Div();
        $page_container_width = $model_divs->width($site_id, $div_id);
        
        $model_page_content_heading = new Dlayer_Model_Page_Content_Items_Heading();
        $box_dimensions = $model_page_content_heading->boxDimensions(
        $params['content_container_id'], $site_id, $page_id, $div_id);
        
        if($box_dimensions != FALSE) {
			$content_container_width = intval($box_dimensions['width']) + 
			intval($box_dimensions['padding_left']) + intval($params['left']) 
			+ intval($params['right']);
        }
        
        $model_position = new Dlayer_Model_Page_Content_Position();
        
        if($model_position->marginValueValid($params['top']) == TRUE && 
        $model_position->marginValueValid($params['right']) == TRUE && 
        $model_position->marginValueValid($params['bottom']) == TRUE && 
        $model_position->marginValueValid($params['left']) == TRUE && 
    	$box_dimensions != FALSE && 
    	$content_container_width <= $page_container_width) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
    * Prepare the data, converts all the values to the correct data types 
    * and trims any string values. In addition to setting the margin values we 
    * check to see if all values are set to 0, if so we set the clear_margins 
    * index to 0, we can them delete the margin values rather than set them 
    * all to 0
    *
    * @param array $params Params array to prepare
    * @return array Prepared data array
    */
    protected function prepare(array $params)
    {
    	$clear_margins = FALSE;
    	
    	if(intval($params['top']) == 0 && 
    	intval($params['right']) == 0 && 
    	intval($params['bottom']) == 0 && 
    	intval($params['left']) == 0) {
			$clear_margins = TRUE;
    	}
    	
        return array('top'=>intval($params['top']), 
        'right'=>intval($params['right']), 
        'bottom'=>intval($params['bottom']), 
        'left'=>intval($params['left']),
        'clear_margins'=>$clear_margins);
    }
    
    /**
    * Set the margin values for the selected text item container
    * 
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @param integer $content_id
    * @return void
    */
    private function setMarginValues($site_id, $page_id, $div_id, $content_id) 
    {
    	$model_position = new Dlayer_Model_Page_Content_Position();
    	
    	$margins_id = $model_position->existingMarginValues($site_id, 
    	$page_id, $div_id, $content_id, $this->content_type);
    	
    	if($margins_id == FALSE && $this->params['clear_margins'] == FALSE) {
			$model_position->addMarginValues($site_id, $page_id, $div_id, 
			$content_id, $this->content_type, $this->params);
    	} else {
			if($this->params['clear_margins'] == FALSE) {
				$model_position->updateMarginValues($margins_id, 
				$this->params);
			} else {
				$model_position->clearMarginValues($margins_id);
			}
    	}
    }
}