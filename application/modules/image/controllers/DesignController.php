<?php
/**
* The design controller is the root of the image library, this is where the 
* user manages the images in their library
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Image_DesignController extends Zend_Controller_Action
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

    private $layout;

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

        $this->session_dlayer = new Dlayer_Session();
        $this->session_image = new Dlayer_Session_Image();

        // Include js and css files in layout
        $this->layout = Zend_Layout::getMvcInstance();
        $this->layout->assign('js_include', array('scripts/dlayer.js'));
        $this->layout->assign('css_include', array('styles/designer.css',
        'styles/designer/image.css', 'styles/ribbon.css', 
        'styles/ribbon/image.css'));
    }

    /**
    * Base action for the designer controller, loads in the html for the
    * menu, ribbon, modes, toolbar and template
    *
    * @return void
    */
    public function indexAction()
    {
        $this->dlayerMenu('/image/index/index');
        $this->view->dlayer_toolbar = $this->dlayerToolbar();
        $this->view->dlayer_library = $this->dlayerLibrary();
        $this->view->dlayer_ribbon = $this->dlayerRibbon();

        $this->view->module = $this->getRequest()->getModuleName();
        $this->view->image_id = $this->session_image->id();
        $this->view->tool = $this->session_image->tool();

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
        array('url'=>'/image/index/index', 'name'=>'Image Library', 
        'title'=>'Dlayer Image library', 
        'children'=>array(array('url'=>'/template/index/index', 
        'name'=>'Template designer', 'title'=>'Dlayer Template designer'), 
        array('url'=>'/content/index/index', 
        'name'=>'Content manager', 'title'=>'Dlayer Content manager'), 
        array('url'=>'/form/index/index', 
        'name'=>'Form builder', 'title'=>'Dlayer Form builder'), 
        array('url'=>'/website/index/index', 
        'name'=>'Web site manager', 'title'=>'Dlayer Website manager'))), 
        array('url'=>'/image/settings/index', 
        'name'=>'Settings', 'title'=>'Image library settings'), 
        array('url'=>'/dlayer/index/logout', 'name'=>'Logout (' . 
        $this->session_dlayer->identity() . ')', 'title'=>'Logout'));
        
        $this->layout->assign('nav', array('class'=>'top_nav', 
        'items'=>$items, 'active_url'=>$url));
    }

    /**
    * Generate the html for the tool bar, the enabled tools for the module are
    * selected and then passed to a view file. The view is generated using
    * the tools array and then the result is passed back to the index action
    *
    * @return string
    */
    private function dlayerToolbar()
    {
        $model_module = new Dlayer_Model_Module();

        $this->view->image_id = $this->session_image->id();
        $this->view->tools = $model_module->tools(
        $this->getRequest()->getModuleName());
        $this->view->tool = $this->session_image->tool();

        return $this->view->render("design/toolbar.phtml");
    }

    /**
    * Generate the html for the ribbon, there are three ribbon states,
    * the initial state, div selected and then tool selected. The contents
    * of the ribbon are loaded via AJAX, this method just generates the
    * container html for when a tool is selected and then the html for the
    * two base states
    *
    * @return string
    */
    private function dlayerRibbon()
    {
        $tool = $this->session_image->tool();

        if($tool != FALSE) {
            $html = $this->dlayerRibbonHtml($tool['tool'], $tool['tab']);
        } else {
            $ribbon = new Dlayer_Ribbon();

            if($this->session_image->Id() != NULL) {
                $html = $this->view->render($ribbon->selectedViewScriptPath());
            } else {
                $html = $this->view->render($ribbon->defaultViewScriptPath());
            }
        }

        $this->view->html = $html;

        return $this->view->render('design/ribbon.phtml');
    }

    /**
    * Generate the container html for a tool ribbon tab, view pulls the
    * tabs for the tool and then generates the tab bar and container. The
    * contents of the ribbon are loaded via AJAX
    *
    * @param string $tool
    * @param string $tab
    * @return string
    */
    private function dlayerRibbonHtml($tool, $tab)
    {
        $ribbon = new Dlayer_Ribbon();
        
        $edit_mode = FALSE;
        
        if($this->session_image->id() != NULL) {
            $edit_mode = TRUE;
        }
        
        $tabs = $ribbon->tabs($this->getRequest()->getModuleName(), $tool, 
        $edit_mode);

        if($tabs != FALSE) {
            $this->view->tab = $tab;
            $this->view->tool = $tool;
            $this->view->tabs = $tabs;
            $this->view->module = $this->getRequest()->getModuleName();
            $html = $this->view->render($ribbon->dynamicViewScriptPath());
        } else {
            $html = $this->view->render($ribbon->defaultViewScriptPath());
        }

        return $html;
    }  

    /**
    * Generate the html for the requested tool tab, called via AJAX by the
    * base view.
    *
    * The tool and tab are checked to see if they are valid and then the
    * daata required to generate the tab is pulled and passed to the view.
    *
    * @return string
    */
    public function ribbonTabHtmlAction()
    {
        $this->_helper->disableLayout();

        $tool = $this->getRequest()->getParam('tool');
        $tab = $this->getRequest()->getParam('tab');
        $module = $this->getRequest()->getModuleName();

        if($tab != NULL && $tool != NULL) {

            $ribbon = new Dlayer_Ribbon();
            $ribbon_tab = new Dlayer_Ribbon_Tab();

            $view_script = $ribbon_tab->viewScript(
            $this->getRequest()->getModuleName(), $tool, $tab);
            $multi_use = $ribbon_tab->multiUse($module, $tool, $tab);

            if($view_script != FALSE) {

                $this->session_image->setRibbonTab($tab);
                
                $edit_mode = FALSE;
                if($this->session_image->id() != NULL) {
                    $edit_mode = TRUE;
                }

                $this->view->image_id = $this->session_image->id();
                $this->view->data = $ribbon_tab->viewData($module, $tool,
                $tab, $multi_use, $edit_mode);
                $this->view->edit_mode = $edit_mode;

                $html = $this->view->render(
                $ribbon->viewScriptPath($view_script));
            } else {
                $html = $this->view->render(
                $ribbon->defaultViewScriptPath());
            }
        } else {
            $html = $this->view->render($ribbon->defaultViewScriptPath());
        }

        $this->view->html = $html;
    }

    /**
    * Generate the html for the library, list of thumbnails for the selected 
    * category and subcategory
    *
    * @return string
    */
    private function dlayerLibrary()
    {
        $designer_image_library = new Dlayer_Designer_ImageLibrary(
        $this->session_dlayer->siteId(), 
        $this->session_image->id(Dlayer_Session_Image::IMAGE), 
        $this->session_image->id(Dlayer_Session_Image::CATEGORY), 
        $this->session_image->id(Dlayer_Session_Image::SUBCATEGORY));
        
        return $this->view->render("design/library.phtml");
    }

    /**
    * Set the selected image and returns the user back to the designer
    * with the image selected
    *
    * @return void
    */
    public function setSelectedImageAction()
    {
        $this->_helper->disableLayout(FALSE);

        $id = $this->getRequest()->getParam('selected');

        if($this->session_image->setId($id) == TRUE) {
            $this->_redirect('/image/design');
        } else {
            $this->cancelTool();
        }
    }

    /**
    * Set the tool, validates that the requested tool is valid and then sets
    * the params in the content session.
    *
    * After a tool has been set the view is refreshed, the ribbon and designer
    * willbe updated based on the selected tool or item
    *
    * Unlike all the other tools the cancel tool clears all template session
    * values before refreshing the view
    *
    * @return void
    */
    public function setToolAction()
    {
        $this->_helper->disableLayout(FALSE);

        $tool = $this->getRequest()->getParam('tool');

        if($tool != NULL && strlen($tool) > 0) {
            if($tool != 'cancel') {
                if($this->session_image->setTool($tool) == TRUE) {
                    $this->_redirect('/image/design');
                } else {
                    $this->cancelTool();
                }
            } else {
                $this->cancelTool();
            }
        } else {
            $this->cancelTool();
        }
    }

    /**
    * The cancel tool clears all the currently set content template vars, the
    * user is returned to the manager after the session is cleared
    *
    * @return void
    */
    private function cancelTool()
    {
        $this->session_image->clearAll();
        $this->_redirect('/image/design');
    }
}