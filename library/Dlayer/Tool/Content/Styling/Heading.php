<?php
/**
* Add or edit the styling for the heading content item container, user can 
* define the background color.
* 
* @todo Need to allow the user to define a border color, width and style
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Heading.php 1861 2014-05-27 11:30:18Z Dean.Blackborough $
*/
class Dlayer_Tool_Content_Styling_Heading extends Dlayer_Tool_Module_Content
{
    protected $content_type = 'heading';

    /**
    * Update the styling for the content container, this method uses 
    * the params array, all values will have already been validated, just need 
    * to process the request
    *
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @param integer|NULL $content_id
    * @return integer Content id
    */
    public function process($site_id, $page_id, $div_id,
    $content_id=NULL)
    {
        if($this->validated == TRUE) {
            $this->setStyling($site_id, $page_id, $div_id, $content_id);
        }

        return $content_id;
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
        if(array_key_exists('background_color', $params) == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
    * Checks that the submitted data is all valid, both the form and the 
    * values themselves
    * 
    * Checks the following
    * 
    * 1. Background color must either be empty of a valid hex value
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
    	if(strlen(trim($params['background_color'])) == 0 ||
    	Dlayer_Validate::colorHex($params['background_color']) == TRUE) {
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
    	$clear_background = FALSE;
    	
    	if(strlen(trim($params['background_color'])) == 0) {
			$clear_background = TRUE;
    	}
    	
        return array('background_color'=>trim($params['background_color']),
        'clear_background'=>$clear_background);
    }
    
    /**
    * Set the styling for the text item content container, logic for each style 
    * settings depends on whether there are existing values and whether or not 
    * the style changes affects the size of the content container
    * 
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @param integer $content_id
    * @return void
    */
    private function setStyling($site_id, $page_id, $div_id, $content_id) 
    {
    	if(array_key_exists('background_color', $this->params) == TRUE) {
			$this->setStylingBackgroundColor($site_id, $page_id, $div_id, 
			$content_id, $this->params['background_color'], 
			$this->params['clear_background']);
    	}
    }
    
    /**
    * Set the styling for the border, checks to see if we are adding a new 
    * value, overwriting an existing value or deleting an existing value
    * 
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @param integer $content_id
    * @param string $background_color
    * @param boolean $clear_background
    * @return void
    */
    private function setStylingBackgroundColor($site_id, $page_id, $div_id, 
    $content_id, $background_color, $clear_background) 
    {
    	$model_styling = new Dlayer_Model_Page_Content_Styling();
    	
    	$styling_id = $model_styling->existingBackgroundColor($site_id, 
    	$page_id, $div_id, $content_id, $this->content_type);
    	
    	if($styling_id == FALSE) {
			if($clear_background == FALSE) {
				$model_styling->addBackgroundColor($site_id, $page_id, $div_id, 
				$content_id, $this->content_type, $background_color);
				
				$this->addToColorHistory($site_id, $background_color);
			}
    	} else {
			if($clear_background == FALSE) {
				$model_styling->updateBackgroundColor($styling_id, 
				$background_color);
				
				$this->addToColorHistory($site_id, $background_color);
			} else {
				$model_styling->clearBackgroundColor($styling_id);
			}
    	}
    }
}