<?php
/**
* AJAX controller for all the ajax calls used in the Image library
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Image_AjaxController extends Zend_Controller_Action
{
    /**
    * Type hinting for action helpers, hints the property to the code
    * hinting class which exists in the library
    *
    * @var Dlayer_Action_CodeHinting
    */
    protected $_helper;

    private $session_dlayer;
    private $session_image;

    /**
    * Initialise the controller, run any required set up code and set
    * properties required by controller actions
    *
    * @return void
    */
    public function init()
    {
    	$this->_helper->authenticate();

        $this->_helper->setModule();

    	$this->_helper->validateSiteId();

    	$this->_helper->disableLayout(FALSE);

        $this->session_dlayer = new Dlayer_Session();
        $this->session_image = new Dlayer_Session_Image();
    }
    
    /**
    * Returns the json array for the sub catyegories that below to the 
    * selected category
    * 
    * @return void
    */
    public function subCategoriesAction() 
    {
        $this->getResponse()->setHeader('Content-Type', 'application/json');
        
        if($this->getRequest()->getParam('all', 1) == 1) {
            $append_all = TRUE;
        } else {
            $append_all = FALSE;
        }
        
        $model_categories = new Dlayer_Model_Image_Categories();
        $sub_categories = $model_categories->subCategories(
        $this->session_dlayer->siteId(), 
        $this->getRequest()->getParam('category_id'), $append_all);
        
        $json = array('data'=>FALSE);
        
        if(count($sub_categories) > 0) {
            $json = array('data'=>true, "sub_categories"=>$sub_categories);
        }
        
        echo Zend_Json::encode($json);
    }
}