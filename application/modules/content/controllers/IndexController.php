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
	* Type hinting for action helpers, hints the property to the code 
	* hinting class which exists in the library
	* 
	* @var Dlayer_Action_CodeHinting
	*/
	protected $_helper;
	/**
	 * @var Dlayer_Session_Content
	 */
	private $session_content;

	private $layout;
	private $site_id;
	private $content_page_form;

	/**
	 * Execute the setup methods for the controller and set the properties
	 *
	 * @return void
	 */
	public function init()
	{
		$this->_helper->authenticate();
		$this->_helper->setModule();
		$this->_helper->validateSiteId();

		$this->layout = Zend_Layout::getMvcInstance();

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
		$model_sites = new Dlayer_Model_Site();
		$model_pages = new Dlayer_Model_Page();

		$this->view->site = $model_sites->site($this->site_id);
		$this->view->pages = $model_pages->pages($this->site_id);
		$this->view->page_id = $this->session_content->pageId();

		$this->setLayoutProperties(array(), array('css/dlayer.css'), 'Dlayer.com - Content manager',
			'/content/index/index');
	}

	/**
	 * Setup the navbar for the module
	 *
	 * @param string $active_uri The uri that should display as active
	 * @return void Assigns the data to the layout
	 */
	private function navBar($active_uri) 
	{
		$items = array(
			array('uri'=>'/dlayer/index/home', 'name'=>'Dlayer Demo', 'title'=>'Dlayer.com: Web development simplified'),
			array('uri'=>'/content/index/index', 'name'=>'Content manager', 'title'=>'Content manager'),
			array('uri'=>'/content/settings/index', 'name'=>'Settings', 'title'=>'Settings'),
			array('uri'=>'http://www.dlayer.com/docs/', 'name'=>'Dlayer Docs', 'title'=>'Read the Docs for Dlayer')
		);
		
		$this->layout->assign('nav', array(
			'class'=>'top_nav', 'items'=>$items, 'active_uri'=>$active_uri));		
	}

	/**
	 * Activate another content page, check that the id is valid and also check that it belongs tpo the site set
	 * in the session
	 *
	 * @return void
	 */
	public function activateAction() 
	{
		$this->_helper->disableLayout(FALSE);

		$model_pages = new Dlayer_Model_Page();

		$page_id = Dlayer_Helper::getInteger('page-id');

		if($page_id !== NULL && $model_pages->valid($page_id, $this->site_id) == TRUE)
		{
			$page = $model_pages->page($page_id);
			
			if($page !== FALSE)
			{
				$this->session_content->clearAll();
				$this->session_content->setPageId($page_id);
			}
		}

		$this->redirect('/content');
	}
	
	/**
	 * Handle add content page, if successful the user is redirected after the ids for the new page has been set in
	 * the session
	 *
	 * @return void
	 */
	private function handleAddContentPage() 
	{
		$post = $this->getRequest()->getPost();
		
		if($this->content_page_form->isValid($post)) 
		{
			$model_pages = new Dlayer_Model_Page();
			$page_id = $model_pages->savePage($this->site_id, $post['name'], $post['title'], $post['description']);

			if($page_id !== FALSE)
			{
				$this->session_content->clearAll(TRUE);
				$this->session_content->setPageId($page_id);
				$this->redirect('/content');
			}
		}
	}

	/**
	 * Handle edit content page, if successful the user is redirected back to Content manager root
	 *
	 * @return void
	 */
	private function handleEditContentPage()
	{
		$post = $this->getRequest()->getPost();

		if($this->content_page_form->isValid($post))
		{
			$model_pages = new Dlayer_Model_Page();
			$page_id = $model_pages->savePage($this->site_id, $post['name'], $post['title'], $post['description'],
				$this->session_content->pageId());

			if($page_id !== FALSE)
			{
				$this->redirect('/content');
			}
		}
	}

	/**
	 * Create a new content page for the currently selected site, users needs to enter a name to identify the
	 * page within Dlayer as well as the title and description for the html
	 *
	 * @return void
	 */
	public function newPageAction() 
	{
		$model_sites = new Dlayer_Model_Site();

		$this->content_page_form = new Dlayer_Form_Site_ContentPage('/content/index/new-page', $this->site_id);

		if($this->getRequest()->isPost())
		{
			$this->handleAddContentPage();
		}

		$this->view->form = $this->content_page_form;
		$this->view->site = $model_sites->site($this->site_id);

		$this->setLayoutProperties(array(), array('css/dlayer.css'), 'Dlayer.com - New content page',
			'/content/index/index');
	}
	
	/**
	 * Edit the selected content page
	 * 
	 * @return void
	 */
	public function editPageAction() 
	{
		$model_sites = new Dlayer_Model_Site();
		
		$this->content_page_form = new Dlayer_Form_Site_ContentPage('/content/index/edit-page', $this->site_id,
			$this->session_content->pageId());
		
		if($this->getRequest()->isPost()) 
		{
			$this->handleEditContentPage();
		}
		
		$this->view->form = $this->content_page_form;
		$this->view->site = $model_sites->site($this->site_id);

		$this->setLayoutProperties(array(), array('css/dlayer.css'), 'Dlayer.com - Edit page',
			'/content/index/index');
	}

	/**
	 * Set layout properties for action, js and css files to include, page title and the active uri for the navbar
	 *
	 * @param array $js_includes Javascript includes array
	 * @param array $css_includes CSS includes array
	 * @param string $title Page title
	 * @param string $active_uri Active uri for navbar
	 * @return void
	 */
	private function setLayoutProperties(array $js_includes, array $css_includes, $title, $active_uri)
	{
		$this->layout->assign('js_include', $js_includes);
		$this->layout->assign('css_include', $css_includes);
		$this->layout->assign('title', $title);
		$this->navBar($active_uri);
	}
}
