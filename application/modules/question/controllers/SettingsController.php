<?php
/**
* Settings
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: SettingsController.php 1532 2014-02-07 15:41:19Z Dean.Blackborough $
*/
class Question_SettingsController extends Zend_Controller_Action 
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
        $this->layout->assign('js_include', array('scripts/dlayer-obj.js'));
        $this->layout->assign('css_include', array('styles/forms.css', 
        'styles/settings.css'));
    }

    /**
    * Base settings page for the web site manager
    * 
    * @return void
    */
    public function indexAction()
    {
    	$model_sites = new Dlayer_Model_Site();
    	
        $this->dlayerMenu('/question/settings/index');
        $this->settingsMenus('Question', '/question/settings/index', 
        '/question/settings/index');
        
        $this->view->site = $model_sites->site($this->session_dlayer->siteId());
        
        $this->layout->assign('title', 
        'Dlayer.com - Question manager settings');
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
    
    /**
    * Generate the setting and section menus for settings
    *
    * @param string $group Settings group to fetch settings for
    * @param string $group_url Active setting group url
    * @param string $setting_url Active setting url
    * @return string Html
    */
    private function settingsMenus($group, $group_url='', $setting_url='')
    {
    	$model_settings = new Dlayer_Model_Settings();
    	$setting_groups = $model_settings->settingGroups();
    	
    	$settings = $model_settings->settings($group);
        
        $this->view->setting_groups = array('class'=>'setting_groups', 
        'items'=>$setting_groups, 'active_url'=>$group_url);
        
        $this->view->settings = array('class'=>'settings', 
        'items'=>$settings, 'active_url'=>$setting_url);
    }
}