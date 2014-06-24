<?php
/**
* Manage the settings for the form
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Tool_Form_FormSettings extends Dlayer_Tool_Module_Form
{
    protected $tool = 'form-settings';

    /**
    * Update the settings for the form. Uses the data in the params array 
    * for the request, this data will have already been both prepared and 
    * validated by the tool class
    *
    * @param integer $site_id Site id
    * @param integer $form_id Form id
    * @param integer|NULL $field_id Not used by this tool
    * @return integer Form id
    */
    public function process($site_id, $form_id, $field_id=NULL)
    {
        if($this->validated == TRUE) {            
            $this->manageSettings($site_id, $form_id);
            
            return $form_id;
        }
    }

    /**
    * Check to see if the information supplied is valid. If all the values
    * are valid the values are written to the $this->params property
    *
    * @param array $params Params post array
    * @return boolean
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
        if(array_key_exists('width', $params) == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
    * Check that the submitted data values are all in the correct format, 
    * the validateValues(0 method will have already been run so we can just 
    * check the format of the data calling indexes directly
    *
    * @param array $params Params array to check
    * @return boolean TRUE if the values are valid
    */
    private function validateData(array $params = array())
    {
        if(intval($params['width']) > 0 && intval($params['width']) < 1000) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
    * Prepare the data, converts all the array values to the required data 
    * types and trims any string values, called after both the validateValues() 
    * and validateData have run
    *
    * @param array $params Params array to prepare
    * @return array Prepared data array
    */
    protected function prepare(array $params)
    {
        return array('width'=>intval($params['width']));
    }
    
    /**
    * Manage the form settings, calls a method for each of the form settings, 
    * each handle all the relevant processing
    * 
    * @param integer $site_id
    * @param integer $form_id
    * @return void
    */
    private function manageSettings($site_id, $form_id) 
    {
        var_dump($this->params); die('hfhfhfhfhf');
    }
}