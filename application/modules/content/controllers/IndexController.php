<?php

/**
 * Root controller for the Content Manager, shows a lits of all the pages in the selected web site as well as links
 * the setting pages for the Content Manager
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Content_IndexController extends Zend_Controller_Action
{
    /**
     * Type hinting for action helpers
     *
     * @var Dlayer_Action_CodeHinting
     */
    protected $_helper;

    /**
     * @var Dlayer_Session_Content
     */
    private $session_content;

    private $site_id;
    private $content_page_form;

    /**
     * @var array Nav bar items
     */
    private $nav_bar_items = array(
        array(
            'uri' => '/dlayer/index/home',
            'name' => 'Dlayer Demo',
            'title' => 'Dlayer.com: Web development simplified'
        ),
        array('uri' => '/content/index/index', 'name' => 'Content Manager', 'title' => 'Content Manager'),
        array('uri' => 'http://www.dlayer.com/docs/', 'name' => 'Docs', 'title' => 'Read the Docs for Dlayer'),
    );

    /**
     * Execute the setup methods for the controller and set the properties
     *
     * @return void
     */
    public function init()
    {
        $this->_helper->validateModule();

        $this->_helper->authenticate();

        $this->_helper->validateSiteId();

        $session_dlayer = new Dlayer_Session();

        $this->site_id = $session_dlayer->siteId();
        $this->session_content = new Dlayer_Session_Content();
    }

    /**
     * Show a list of the pages that belong to the currently selected site along with add new page and edit/management
     * options
     *
     * @return void
     */
    public function indexAction()
    {
        $model_sites = new Dlayer_Model_Admin_Site();
        $model_pages = new Dlayer_Model_Admin_Page();
        
        $pages = $model_pages->pages($this->site_id);

        if ($this->session_content->pageId() === null && count($pages) === 1) {
            $this->redirect('/content/index/activate/page-id/' . $pages[0]['id']);
        }

        $this->view->site = $model_sites->site($this->site_id);
        $this->view->pages = $pages;
        $this->view->page_id = $this->session_content->pageId();

        $session_dlayer = new Dlayer_Session();
        $this->controlBar($session_dlayer->identityId(), $this->site_id);

        $this->_helper->setLayoutProperties($this->nav_bar_items, '/content/index/index', array('css/dlayer.css'),
            array(), 'Dlayer.com - Content Manager');
    }

    /**
     * Control bar
     *
     * @param integer $identity_id
     * @param integer $site_id
     *
     * @return void
     */
    private function controlBar($identity_id, $site_id)
    {
        $model = new Dlayer_Model_Admin_Site();

        $control_bar_buttons = array(
            array(
                'uri' => '/dlayer/index/home',
                'class' => 'default',
                'name' => 'Dashboard'
            ),
            array(
                'uri'=>'/content/admin/new',
                'class' => 'primary',
                'name'=>'New page'
            )
        );

        $control_bar_drops = array(
            array(
                'name' => 'Your websites',
                'class' => 'default',
                'buttons' => $model->sitesForControlBar($identity_id, $site_id)
            )
        );

        $this->_helper->populateControlBar($control_bar_buttons, $control_bar_drops);
    }

    /**
     * Activate another content page, check that the id is valid and also check that it belongs tpo the site set
     * in the session
     *
     * @return void
     */
    public function activateAction()
    {
        $this->_helper->disableLayout(false);

        $model = new Dlayer_Model_Admin_Page();

        $page_id = Dlayer_Helper::getParamAsInteger('page-id');

        if ($page_id !== null && $model->valid($page_id, $this->site_id) == true) {
            $page = $model->page($page_id);

            if ($page !== false) {
                $this->session_content->clearAll();
                $this->session_content->setPageId($page_id);
            }
        }

        $this->redirect('/content');
    }
}
