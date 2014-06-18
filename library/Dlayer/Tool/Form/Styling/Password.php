<?php
/**
* Styling sub tool for the password field input, allows the user to style the 
* row and field
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Password.php 1861 2014-05-27 11:30:18Z Dean.Blackborough $
*/
class Dlayer_Tool_Form_Styling_Password extends Dlayer_Tool_Module_Form
{
    /**
    * Update the styling for the form field row and element, formatting is 
    * handled by another sub tool. Edit only sub tool, field id is always 
    * known. This method just handles the request, the params will have already 
    * been validated and prepared by the other tool methods
    *
    * @param integer $site_id Site id
    * @param integer $form_id Form id
    * @param integer|NULL $field_id If in edit mode the id of the field being
    *                               edited
    * @return integer Field id
    */
    public function process($site_id, $form_id, $field_id=NULL)
    {
        if($this->validated == TRUE) {
                $this->setStyling($site_id, $form_id, $field_id);
        }
        
        return $field_id;
    }

    /**
    * Check to see if the information supplied is valid. If all the values
    * are valid the values are written to the $this->params property and 
    * $this->validated is set to TRUE
    *
    * @param array $params Params post array
    * @return boolean TRUE if validation passed
    */
    public function validate(array $params = array())
    {
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

    public function autoValidate(array $params = array())
    {
        // Not currently used by tool, may be used by the presets later
        return FALSE;
    }

    public function autoProcess($site_id, $form_id, $field_id=NULL)
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
        if(array_key_exists('background_color', $params) == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
    * Check that the submitted data values are all in the correct, both form 
    * and values if necessary
    * 
    * Following checks are made
    * 
    * 1. Background color must be either empty or a valid hex value
    *
    * @param array $params Params array to check
    * @return boolean TRUE if the values are valid
    */
    private function validateData(array $params = array())
    {
    	if(strlen(trim($params['background_color'])) == 0 ||
    	Dlayer_Validate::colorHex($params['background_color']) == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
    * Prepare the data, converts all the array values to the required data
    * type and trims and string values, called after the params array has been 
    * checked and the values validated
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
    * Set the styling for the selected form field, logic for each of the 
    * style settings depends on whether ther are existing values or not, all 
    * handled by their own sub methods
    * 
    * @param integer $site_id
    * @param integer $form_id
    * @param integer $field_id
    * @return void
    */
    private function setStyling($site_id, $form_id, $field_id) 
    {
    	if(array_key_exists('background_color', $this->params) == TRUE) {
			$this->setStylingBackgroundColor($site_id, $form_id, $field_id, 
			$this->params['background_color'], 
			$this->params['clear_background']);
    	}
    }
    
    /**
    * Set the styling for the form field row, checks to see if we are adding 
    * a new value, overwriting an existing value or deleting an existing value
    * 
    * @param integer $site_id
    * @param integer $form_id
    * @param integer $field_id
    * @param string $background_color
    * @param boolean $clear_background
    * @return void
    */
    private function setStylingBackgroundColor($site_id, $form_id, $field_id, 
    $background_color, $clear_background) 
    {
    	$model_styling = new Dlayer_Model_Form_Styling();
    	
    	$styling_id = $model_styling->existingRowBackgroundColor($site_id, 
    	$form_id, $field_id);
    	
    	if($styling_id == FALSE) {
			if($clear_background == FALSE) {
				$model_styling->addRowBackgroundColor($site_id, $form_id, 
				$field_id, $background_color);
				
				$this->addToColorHistory($site_id, $background_color);
			}
    	} else {
			if($clear_background == FALSE) {
				$model_styling->updateRowBackgroundColor($styling_id, 
				$background_color);
				
				$this->addToColorHistory($site_id, $background_color);
			} else {
				$model_styling->clearRowBackgroundColor($styling_id);
			}
    	}
    }
}