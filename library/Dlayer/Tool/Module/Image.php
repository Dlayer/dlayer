<?php
/**
* Base abstract class for all the image library tool classes, all tool classes 
* need to define the abstract methods of this class and the Dlayer_Tool class
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
abstract class Dlayer_Tool_Module_Image extends Dlayer_Tool 
{
    protected $site_id;
    protected $category_id;
    protected $sub_category_id;
    protected $image_id;
    protected $version_id;
    
    protected $session_dlayer;
    
    /**
    * Process the request for a manual tool
    * 
    * @return array Contains relevant id and type of id
    */
    abstract public function process();
        
    /**
    * Process the request for an auto tool
    * 
    * @return integer Contains relevant id and type of id
    */
    abstract public function autoProcess();
    
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
    * @param integer $site_id
    * @param integer|NULL $category_id
    * @param integer|NULL $sub_category_id
    * @param integer|NULL $image_id 
    * @param integer|NULL $version_id
    * @return boolean
    */
    abstract public function validate(array $params = array(), $site_id, 
    $category_id=NULL, $sub_category_id=NULL, $image_id=NULL, $version_id=NULL);
    
    /**
    * Validate the supplied params, run before we call the autoProcess()
    * method. If the result of the tests is TRUE the internal validated
    * property is set to TRUE and the params are passed to an interal params
    * array. The autoProcess() method when called will operate on the params
    * array
    *
    * @param array $params Params post array
    * @param integer $site_id
    * @param integer|NULL $category_id
    * @param integer|NULL $sub_category_id
    * @param integer|NULL $image_id 
    * @param integer|NULL $version_id
    * @return boolean Is the request valid
    */
    abstract public function autoValidate(array $params = array(), $site_id, 
    $category_id=NULL, $sub_category_id=NULL, $image_id=NULL, $version_id=NULL);
}