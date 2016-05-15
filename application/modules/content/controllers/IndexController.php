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

		// Set layout properties, JS, CSS, page title and navbar
		$this->layout->assign('js_include', array());
		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - Content manager');
		$this->navBar('/content/index/index');
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
			array('uri'=>'/dlayer/index/home', 'name'=>'Dlayer Demo', 
				'title'=>'Dlayer.com: Web development simplified'),
			array('uri'=>'/content/index/index', 
				'name'=>'Content manager', 'title'=>'Content manager'), 
			array('uri'=>'/content/settings/index', 
				'name'=>'Settings', 'title'=>'Settings'), 
			array('uri'=>'http://www.dlayer.com/docs/', 
				'name'=>'Dlayer Docs', 'title'=>'Read the Docs for Dlayer')
		);
		
		$this->layout->assign('nav', array(
			'class'=>'top_nav', 'items'=>$items, 'active_uri'=>$active_uri));		
	}

	/**
	* Activate another page, checks that the given page id is valid and 
	* that it belongs to the site id in the session. If valid the page is 
	* activated and the user is sent back to the index action. 
	* 
	* In addition to setting the page id the action sets the template id that 
	* matches the page, required to pull the data for the page and it means 
	* that when the user uses the mode buttons in the top right they will 
	* be taken to the template for the current page when they click the 
	* template button
	* 
	* The content id is cleared in the content session because the set value 
	* may relate to an existing template
	* 
	* @return void
	*/
	public function activateAction() 
	{
		$this->_helper->disableLayout(FALSE);

		$page_id = Dlayer_Helper::getInteger('page-id');

		if($page_id != NULL) {           
			$model_pages = new Dlayer_Model_Page();
			if($model_pages->valid($page_id, 
			$this->site_id) == TRUE) {
				$page = $model_pages->page($page_id);
				if($page != FALSE) {
					$this->session_content->clearAll();
					$this->session_content->setPageId($page_id);
					$this->session_content->setTemplateId($page['template_id']);
				}
			}
		}

		$this->_redirect('/content');
	}

	/**
	* Allows the user to create a new page for the currently selected site, 
	* they need to choose the template to use and provide a name
	* 
	* @return void
	*/
	public function newPageAction() 
	{
		$model_sites = new Dlayer_Model_Site();
		$model_templates = new Dlayer_Model_Template();

		$templates = $model_templates->templateNames(
			$this->site_id);

		$form = NULL;

		if(count($templates) > 0) {

			$form = new Dlayer_Form_Site_NewPage(
				$this->site_id, $templates);

			// Validate and save the posted data
			if($this->getRequest()->isPost()) {

				$post = $this->getRequest()->getPost();

				if($form->isValid($post)) {
					$model_pages = new Dlayer_Model_Page();
					$page_id = $model_pages->addPage(
						$this->site_id, $post['name'], 
						$post['template'], $post['title'], $post['description']);
					$this->session_content->clearAll(TRUE);
					$this->session_content->setPageId($page_id);
					$this->session_content->setTemplateId($post['template']);
					$this->_redirect('/content');
				}
			}

			$this->view->form = $form;
		}

		$this->view->site = $model_sites->site($this->site_id);

		// Set layout properties, JS, CSS, page title and navbar
		$this->layout->assign('js_include', array());
		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - New content page');
		$this->navBar('/content/index/index');
	}

	/**
	* Allows the user to edit the details for the currently selected page
	* 
	* @return void
	*/
	public function editPageAction() 
	{
		$model_sites = new Dlayer_Model_Site();

		$form = new Dlayer_Form_Site_EditPage($this->site_id, 
			$this->session_content->pageId());

		// Validate and save the posted data
		if($this->getRequest()->isPost()) {

			$post = $this->getRequest()->getPost();

			if($form->isValid($post)) {
				$model_pages = new Dlayer_Model_Page();
				$model_pages->editPage($this->site_id, 
					$this->session_content->pageId(), $post['name'], 
					$post['title'], $post['description']);
				$this->_redirect('/content');
			}
		}

		$this->view->form = $form;
		$this->view->site = $model_sites->site($this->site_id);

		// Set layout properties, JS, CSS, page title and navbar
		$this->layout->assign('js_include', array());
		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - Edit page');
		$this->navBar('/content/index/index');
	}
}
