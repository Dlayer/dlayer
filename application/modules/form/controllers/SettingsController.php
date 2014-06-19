<?php
/**
* Settings
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: SettingsController.php 1942 2014-06-15 12:52:34Z Dean.Blackborough $
*/
class Form_SettingsController extends Zend_Controller_Action
{
    /**
    * Type hinting for action helpers, hints the property to the code
    * hinting class which exists in the library
    *
    * @var Dlayer_Action_CodeHinting
    */
    protected $_helper;

    private $session_dlayer;
    private $session_form;

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
        $this->session_form = new Dlayer_Session_Form();

        // Include js and css files in layout
        $this->layout = Zend_Layout::getMvcInstance();
        $this->layout->assign('js_include', array('scripts/dlayer.js'));
        $this->layout->assign('css_include', array('styles/forms.css', 
        'styles/settings.css', 'styles/settings/form.css'));
    }

    /**
    * Settings action, settings for the module
    *
    * @return void
    */
    public function indexAction()
    {
    	$model_sites = new Dlayer_Model_Site();

        $this->dlayerMenu('/form/settings/index');
        $this->settingsMenus('Form', '/form/settings/index', 
        '/form/settings/index');
        
        $this->view->site = $model_sites->site($this->session_dlayer->siteId());

        $this->layout->assign('title', 'Dlayer.com - Form builder settings');
        
        $this->_redirect('/form/settings/base-font-family');
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
        array('url'=>'/form/index/index', 'name'=>'Form builder'), 
        array('url'=>'/form/settings/index', 
        'name'=>'Settings'), 
        array('url'=>'/dlayer/index/logout', 'name'=>'Logout (' . 
        $this->session_dlayer->identity() . ')'));
        
        $this->layout->assign('nav', array('class'=>'top_nav', 
        'items'=>$items, 'active_url'=>$url));
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
        $model_settings_form = new Dlayer_Model_Settings_Form();
        
        $setting = $model_settings->setting(
        $this->getRequest()->getRequestUri());
        
        if($setting == FALSE) {
			$this->_redirect('/dlayer/index/home');
        }

        $base_font_family = $model_settings_form->baseFontFamily(
        $this->session_dlayer->siteId());

        $font_families = $model_settings->fontFamilies();

        $form = new Dlayer_Form_Settings_Form_BaseFont(
        $base_font_family['id']);

        // Validate and save the posted data
        if($this->getRequest()->isPost()) {

            $post = $this->getRequest()->getPost();

            if($form->isValid($post)) {
                $model_settings_form->updateFontFamily(
                $this->session_dlayer->siteId(), $post['font_family']);
                $this->_redirect('/form/settings/base-font-family');
            }
        }

        // Assign content view vars
        $this->view->setting = $setting;
        $this->view->form = $form;
        $this->view->font_families = $font_families;
        $this->view->base_font_family = $base_font_family;
        $this->view->site = $model_sites->site($this->session_dlayer->siteId());
        
        $this->dlayerMenu('/form/settings/index');
        $this->settingsMenus('Form', '/form/settings/index', 
        '/form/settings/base-font-family');

        $this->layout->assign('title', 'Dlayer.com - Base font family -
        form builder');
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