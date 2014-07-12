<?php
/**
* Root controller for the image library. 
* 
* The image library is where the user manages all their images
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Image_IndexController extends Zend_Controller_Action
{
    /**
    * Type hinting for action helpers, hints the property to the code 
    * hinting class which exists in the library
    * 
    * @var Dlayer_Action_CodeHinting
    */
    protected $_helper;
    
    private $session_dlayer;
    
    private $layout;
    
    /**
    * Init the controller, run any set up code required by all the actions 
    * in the controller
    * 
    * @return void
    */
    public function init()
    {
    	$this->_helper->authenticate();
    	
        $this->_helper->setModule();
        
        $this->_helper->validateSiteId();
        
        $this->session_dlayer = new Dlayer_Session();
        
        // Include js and css files in layout
        $this->layout = Zend_Layout::getMvcInstance();
        $this->layout->assign('js_include', array());
        $this->layout->assign('css_include', array());
    }

    /**
    * Root action, shows overview of the user's site
    * 
    * @return void
    */
    public function indexAction()
    {
        $session_image = new Dlayer_Session_Image();
        
        // Set category and sub category values if currently NULL
        $category_id = $session_image->id(Dlayer_Session_Image::CATEGORY);
        $sub_category_id = $session_image->id(
        Dlayer_Session_Image::SUB_CATEGORY);
        
        if($category_id == NULL || $sub_category_id == NULL) {
            $model_image_categories = new Dlayer_Model_Image_Categories();
            
            $default_category = $model_image_categories->category(
            $this->session_dlayer->site_id, 0);
            $default_sub_category = $model_image_categories->subCategory(
            $this->session_dlayer->site_id, $default_category['id'], 0);
            
            $session_image->setId($default_category['id'], 
            Dlayer_Session_Image::CATEGORY);
            $session_image->setId($default_sub_category['id'], 
            Dlayer_Session_Image::SUB_CATEGORY);
        }
        
        $this->_redirect('/image/design/index');
        
    	$model_sites = new Dlayer_Model_Site();
    	
    	$this->dlayerMenu('/image/index/index');
        $this->view->site = $model_sites->site($this->session_dlayer->siteId());
    	
        $this->layout->assign('title', 'Dlayer.com - Image library');
    }
    
    /**
    * Generate the base menu bar for the application.
    * 
    * @param string $url Selected url
    * @return string Html
    */
    private function dlayerMenu($url) 
    {
		$items = array(array('url'=>'/dlayer/index/home', 'name'=>'Dlayer', 
        'title'=>'Dlayer.com: Web development simplified'), 
        array('url'=>'/image/index/index', 'name'=>'Image library', 
        'title'=>'Dlayer Image library', 
        'children'=>array(array('url'=>'/template/index/index', 
        'name'=>'Template designer', 'title'=>'Dlayer Template designer'), 
        array('url'=>'/content/index/index', 
        'name'=>'Content manager', 'title'=>'Dlayer Content manager'), 
        array('url'=>'/form/index/index', 
        'name'=>'Form builder', 'title'=>'Dlayer Form builder'), 
        array('url'=>'/website/index/index', 
        'name'=>'Web site manager', 'title'=>'Dlayer Website manager'))), 
        array('url'=>'/content/settings/index', 
        'name'=>'Settings', 'title'=>'Content manager settings'), 
        array('url'=>'/dlayer/index/logout', 'name'=>'Logout (' . 
        $this->session_dlayer->identity() . ')', 'title'=>'Logout'));
        
        $this->layout->assign('nav', array('class'=>'top_nav', 
        'items'=>$items, 'active_url'=>$url));
    }
}