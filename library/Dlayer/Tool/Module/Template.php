<?php
/**
* Base abstract class for the template module tools. All tool classes need
* to define the abstract methods of this class and the Dlayer_Tool class
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Template.php 1861 2014-05-27 11:30:18Z Dean.Blackborough $
*/
abstract class Dlayer_Tool_Module_Template extends Dlayer_Tool
{
    /**
    * Calculates the changes for the advanced modes of the ribbon, works out
    * what needs to be done and then passes the requests to the div model. The
    * method checks to ensure that the request is valid and that params exist
    * before running
    *
    * @param integer $site_id Site id
    * @param integer $template_id Template id
    * @param integer $id Template div id
    * @return void
    */
    abstract public function process($site_id, $template_id, $id);

    /**
    * Calculates the changes for the quick modes of the ribbon, works out what
    * needs to be done and then passes the requests to the div model. The
    * method checks to ensure that the request is valid and that params exist
    * before running
    *
    * @param integer $site_id Site id
    * @param integer $template_id Template id
    * @param integer $id Template div id
    * @return void
    */
    abstract public function autoProcess($site_id, $template_id, $id);

    /**
    * Check to see if changes to the div will required changes to content.
    * If the template is being used by a page and the template div has active
    * content we will need to manipulate the content data to match the new
    * div sizes
    *
    * @param integer $div_id
    * @param integer $site_id
    * @param integer $template_id
    * @return boolean TRUE if one or more content blocks needs to be modified
    */
    protected function needToModifyContent($div_id, $site_id, $template_id)
    {
        $model_pages = new Dlayer_Model_Page();

        if($model_pages->pageCreatedUsingTemplate($template_id,
        $site_id) == TRUE) {
            if($model_pages->templateDivHasContent($div_id, $site_id,
            $template_id) == TRUE) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    
    /**
    * Validate the supplied params, run before we call the process() method.
    * If the result of the tests is TRUE the internal validated property is set
    * to TRUE and the params are passed to an interal params array. The
    * process() method when called will operate on the params array
    *
    * @param array $params Params post array
    * @return boolean
    */
    abstract public function validate(array $params = array());
    
    /**
    * Validate the supplied params, run before we call the autoProcess()
    * method. If the result of the tests is TRUE the internal validated
    * property is set to TRUE and the params are passed to an interal params
    * array. The autoProcess() method when called will operate on the params
    * array
    *
    * @param array $params Params post array
    * @return boolean Is the request valid
    */
    abstract public function autoValidate(array $params = array());
    
    /**
    * Add a new value into the color history table
    * 
    * @param integer $site_id
    * @param string $color_hex
    */
    protected function addToColorHistory($site_id, $color_hex) 
    {
		$model_palettes = new Dlayer_Model_Palette();
		$model_palettes->addToHistory($site_id, $color_hex);
    }
}