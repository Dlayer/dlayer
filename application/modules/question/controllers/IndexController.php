<?php
/**
* Root controller for the module. 
* 
* The question manager allow a user to create polls, quizzes and tests, these 
* can later be imported into the content manager as content items
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: IndexController.php 1532 2014-02-07 15:41:19Z Dean.Blackborough $
*/
class Question_IndexController extends Zend_Controller_Action
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
    	$model_sites = new Dlayer_Model_Site();
    	
    	$this->dlayerMenu('/question/index/index');
        $this->view->site = $model_sites->site($this->session_dlayer->siteId());
    	
        $this->layout->assign('title', 'Dlayer.com - Question manager');
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
    	array('url'=>'/question/index/index', 'name'=>'Question manager'), 
    	array('url'=>'/question/settings/index', 'name'=>'Settings'), 
    	array('url'=>'/dlayer/index/logout', 'name'=>'Logout (' . 
        $this->session_dlayer->identity() . ')'));
    	
    	$this->layout->assign('nav', array('class'=>'top_nav', 
        'items'=>$items, 'active_url'=>$url));
    }
}