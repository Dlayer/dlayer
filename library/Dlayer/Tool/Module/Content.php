<?php
/**
* Base abstract class for the content module tools. All tool classes need
* to define the abstract methods of this class and the Dlayer_Tool class
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Content.php 1861 2014-05-27 11:30:18Z Dean.Blackborough $
*/
abstract class Dlayer_Tool_Module_Content extends Dlayer_Tool
{
    protected $content_type;

    /**
    * Process the request for a manual tool, adds or edits a content block
    *
    * @param integer $site_id Site id
    * @param integer $page_id Page id
    * @param integer $div_id Id of the selected div
    * @param integer|NULL $content_id If in edit mode the id of the content
    *                                 block being editied
    * @return integer Content id
    */
    abstract public function process($site_id, $page_id, $div_id,
    $content_id=NULL);

    /**
    * Process the request for an auto tool, adds ot edit a content block
    *
    * @param integer $site_id Site id
    * @param integer $page_id Page id
    * @param integer $div_id Id of the selected div
    * @param integer|NULL $content_id If in edit mode the id of the content
    *                                 block being editied
    * @return integer Content id
    */
    abstract public function autoProcess($site_id, $page_id, $div_id,
    $content_id=NULL);

    /**
    * Prepare the data, converts the values to the correct data types and
    * trims any string values
    *
    * @param array $params Params array to prepare
    * @return array Prepared data array
    */
    abstract protected function prepare(array $params);
    
    /**
    * Validate the supplied params, run before we call the process() method.
    * If the result of the tests is TRUE the internal validated property is set
    * to TRUE and the params are passed to an interal params array. The
    * process() method when called will operate on the params array
    *
    * @param array $params Params post array
    * @return boolean
    */
    abstract public function validate(array $params = array(), $site_id, 
    $page_id, $div_id);
    
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