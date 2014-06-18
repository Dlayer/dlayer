<?php
/**
* Root controller for the widget module, The widget module allows the user to 
* create reusable fragments to use either on templates, on content pages or 
* in other widgets
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: IndexController.php 1568 2014-02-14 14:59:50Z Dean.Blackborough $
*/
class Widget_IndexController extends Zend_Controller_Action
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
    * Root action, show an overview of the widgets for the web site
    * 
    * @return void
    */
    public function indexAction()
    {
    	$model_sites = new Dlayer_Model_Site();
    	
    	$this->dlayerMenu('/widget/index/index');
        $this->view->site = $model_sites->site($this->session_dlayer->siteId());
    	
        $this->layout->assign('title', 'Dlayer.com - Widget designer');
    }
    
    /**
    * Generate the base menu bar for the application.
    * 
    * @param string $url Selected url
    * @return string Html
    */
    private function dlayerMenu($url) 
    {
		$items = array(array('url'=>'/dlayer/index/home', 'name'=>'Dlayer'), 
    	array('url'=>'/widget/index/index', 'name'=>'Widget designer'), 
    	array('url'=>'/widget/settings/index', 'name'=>'Settings'), 
    	array('url'=>'/dlayer/index/logout', 'name'=>'Logout (' . 
        $this->session_dlayer->identity() . ')'));
    	
    	$this->layout->assign('nav', array('class'=>'top_nav', 
        'items'=>$items, 'active_url'=>$url));
    }
}