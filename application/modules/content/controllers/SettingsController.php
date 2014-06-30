<?php
/**
* Settings
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: SettingsController.php 1942 2014-06-15 12:52:34Z Dean.Blackborough $
*/
class Content_SettingsController extends Zend_Controller_Action 
{
    /**
    * Type hinting for action helpers, hints the property to the code 
    * hinting class which exists in the library
    * 
    * @var Dlayer_Action_CodeHinting
    */
    protected $_helper;
    
    private $session_dlayer;
    private $session_content;
    
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
        $this->session_content = new Dlayer_Session_Content();
        
        // Include js and css files in layout
        $this->layout = Zend_Layout::getMvcInstance();
        $this->layout->assign('js_include', array('scripts/dlayer.js'));
        $this->layout->assign('css_include', array('styles/forms.css', 
        'styles/settings.css', 'styles/settings/content.css'));
    }

    /**
    * Base settings page for the content manager settings
    * 
    * @return void
    */
    public function indexAction()
    {
    	$model_sites = new Dlayer_Model_Site();
    	
        $this->dlayerMenu('/content/settings/index');
        $this->settingsMenus('Content', '/content/settings/index', 
        '/content/settings/index');
        
        $this->view->site = $model_sites->site($this->session_dlayer->siteId());
        
        $this->layout->assign('title', 'Dlayer.com - Content manager settings');
        
        $this->_redirect('/content/settings/base-font-family');
    }
    
    /**
    * Set the styles for the headings
    * 
    * @return void
    */
    public function headingsAction()
    {
        $model_sites = new Dlayer_Model_Site();
        $model_settings = new Dlayer_Model_Settings();
        $model_settings_content = new Dlayer_Model_Settings_Content();
        
        $heading_settings = $model_settings_content->headings(
        $this->session_dlayer->siteId());
        
        $setting = $model_settings->setting(
        $this->getRequest()->getRequestUri());
        
        if($setting == FALSE) {
			$this->_redirect('/dlayer/index/home');
        }
        
        $heading_styles = array();
        $heading_styles['font_styles'] = $model_settings->fontStyles();
        $heading_styles['font_weights'] = $model_settings->fontWeights();
        $heading_styles['font_decorations'] = 
        $model_settings->fontDecorations();
        
        // Create the heading setting forms
        $heading_forms = array();
        
        foreach($heading_settings as $heading) {
            $heading_forms[$heading['id']] = 
            new Dlayer_Form_Settings_Content_Heading($heading);            
        }
        
        // Validate and save the posted data
        if($this->getRequest()->isPost()) {
            
            $post = $this->getRequest()->getPost();
            
            if(is_array($post) && array_key_exists('heading_id', $post) && 
            array_key_exists($post['heading_id'], $heading_forms)) {
                
                $form = $heading_forms[$post['heading_id']];
                
                if($form->isValid($post)) {
                    $model_settings_content->updateHeadings(
                    $this->session_dlayer->siteId(), $post);
                    $this->_redirect('/content/settings/headings');
                }
            }
        }
        
        // Assign content view vars
        $this->view->setting = $setting;
        $this->view->heading_settings = $heading_settings;
        $this->view->heading_forms = $heading_forms;
        $this->view->heading_styles = $heading_styles;
        $this->view->site = $model_sites->site($this->session_dlayer->siteId());
        
        $this->dlayerMenu('/content/settings/index');
        $this->settingsMenus('Content', '/content/settings/index', 
        '/content/settings/headings');
        
        $this->layout->assign('title', 'Dlayer.com - Heading styles');
    }
    
    /**
    * Set the base content font family
    * 
    * @return void
    */
    public function baseFontFamilyAction()
    {
        $model_sites = new Dlayer_Model_Site();
        $model_settings = new Dlayer_Model_Settings();
        $model_settings_content = new Dlayer_Model_Settings_Content();
        
        $setting = $model_settings->setting(
        $this->getRequest()->getRequestUri());
        
        if($setting == FALSE) {
			$this->_redirect('/dlayer/index/home');
        }
        
        $base_font_family = $model_settings_content->baseFontFamily(
        $this->session_dlayer->siteId());
        
        $font_families = $model_settings->fontFamilies();
        
        $form = new Dlayer_Form_Settings_Content_BaseFont(
        $base_font_family['id']);
        
        // Validate and save the posted data
        if($this->getRequest()->isPost()) {
            
            $post = $this->getRequest()->getPost();
        
            if($form->isValid($post)) {
                $model_settings_content->updateFontFamily(
                $this->session_dlayer->siteId(), $post['font_family']);
                $this->_redirect('/content/settings/base-font-family');
            }
        }
        
        // Assign content view vars
        $this->view->setting = $setting;
        $this->view->form = $form;
        $this->view->font_families = $font_families;
        $this->view->base_font_family = $base_font_family;
        $this->view->site = $model_sites->site($this->session_dlayer->siteId());
        
        $this->dlayerMenu('/content/settings/index');
        $this->settingsMenus('Content', '/content/settings/index', 
        '/content/settings/base-font-family');
        
        $this->layout->assign('title', 'Dlayer.com - Base font family - 
        Content manager');
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
        array('url'=>'/content/index/index', 'name'=>'Content manager', 
        'title'=>'Dlayer Content manager', 
        'children'=>array(array('url'=>'/template/index/index', 
        'name'=>'Template designer', 'title'=>'Dlayer Template designer'), 
        array('url'=>'/form/index/index', 
        'name'=>'Form builder', 'title'=>'Dlayer Form builder'), 
        array('url'=>'/website/index/index', 
        'name'=>'Web site manager', 'title'=>'Dlayer Website manager'), 
        array('url'=>'/image/index/index', 
        'name'=>'Image library', 'title'=>'Dlayer Image library'))), 
        array('url'=>'/content/settings/index', 
        'name'=>'Settings', 'title'=>'Content manager settings'), 
        array('url'=>'/dlayer/index/logout', 'name'=>'Logout (' . 
        $this->session_dlayer->identity() . ')', 'title'=>'Logout'));
        
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