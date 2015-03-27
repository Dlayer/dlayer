<?php
/**
* Root controller for the module. The controller should show the user a list of 
* the pages in their site and the corresponding templates, they can either edit 
* a page or create a new page using a template.
*  
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
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
		$this->layout->assign('js_include', array());
		$this->layout->assign('css_include', array());
	}

	/**
	* Root action, should show the user a list of their current content
	* 
	* @return void
	*/
	public function indexAction()
	{
		$model_sites = new Dlayer_Model_Site();
		$model_pages = new Dlayer_Model_Page();

		$this->dlayerMenu('/content/index/index');
		$this->view->site = $model_sites->site($this->session_dlayer->siteId());
		$this->view->pages = $model_pages->pages(
			$this->session_dlayer->siteId());
		$this->view->page_id = $this->session_content->pageId();

		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - Content manager');
	}

	/**
	* Generate the base menu bar for the application.
	* 
	* @param string $url Selected url
	* @return string Html
	*/
	private function dlayerMenu($url) 
	{
		$items = array(array('url'=>'/content/index/index', 
			'name'=>'Content manager', 'title'=>'Dlayer Content manager'), 
			array('url'=>'', 'name'=>'Designers', 'title'=>'Choose a designer', 
				'children'=>array(
					array('url'=>'/template/index/index', 
						'name'=>'Template designer', 'title'=>'Dlayer Template designer'), 
					array('url'=>'/form/index/index', 
						'name'=>'Form builder', 'title'=>'Dlayer Form builder'), 
					array('url'=>'/website/index/index', 
						'name'=>'Web site manager', 'title'=>'Dlayer Website manager'), 
					array('url'=>'/image/index/index', 
						'name'=>'Image library', 'title'=>'Dlayer Image library'))), 
			array('url'=>'/content/settings/index', 
				'name'=>'Settings', 'title'=>'Content manager settings'), 
			array('url'=>'/dlayer/index/logout', 'name'=>'<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Sign out (' . 
				$this->session_dlayer->identity() . ')', 'title'=>'Sign out of my app'));

		$this->layout->assign('nav', array('class'=>'top_nav', 
			'items'=>$items, 'active_url'=>$url));
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
			$this->session_dlayer->siteId()) == TRUE) {
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
		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - New content page');

		$model_sites = new Dlayer_Model_Site();
		$model_templates = new Dlayer_Model_Template();

		$templates = $model_templates->templateNames(
			$this->session_dlayer->siteId());

		$form = NULL;

		if(count($templates) > 0) {

			$form = new Dlayer_Form_Site_NewPage(
				$this->session_dlayer->siteId(), $templates);

			// Validate and save the posted data
			if($this->getRequest()->isPost()) {

				$post = $this->getRequest()->getPost();

				if($form->isValid($post)) {
					$model_pages = new Dlayer_Model_Page();
					$page_id = $model_pages->addPage(
						$this->session_dlayer->siteId(), $post['name'], 
						$post['template'], $post['title'], $post['description']);
					$this->session_content->clearAll(TRUE);
					$this->session_content->setPageId($page_id);
					$this->session_content->setTemplateId($post['template']);
					$this->_redirect('/content');
				}
			}

			$this->view->form = $form;
		}

		$this->view->site = $model_sites->site($this->session_dlayer->siteId());
		$this->dlayerMenu('/content/index/index');
	}

	/**
	* Allows the user to edit the details for the currently selected page
	* 
	* @return void
	*/
	public function editPageAction() 
	{
		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - Edit page');

		$model_sites = new Dlayer_Model_Site();

		$form = new Dlayer_Form_Site_EditPage($this->session_dlayer->siteId(), 
			$this->session_content->pageId());

		// Validate and save the posted data
		if($this->getRequest()->isPost()) {

			$post = $this->getRequest()->getPost();

			if($form->isValid($post)) {
				$model_pages = new Dlayer_Model_Page();
				$model_pages->editPage($this->session_dlayer->siteId(), 
					$this->session_content->pageId(), $post['name'], 
					$post['title'], $post['description']);
				$this->_redirect('/content');
			}
		}

		$this->view->form = $form;
		$this->view->site = $model_sites->site($this->session_dlayer->siteId());
		$this->dlayerMenu('/content/index/index');
	}
}