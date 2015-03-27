<?php
/**
* Root controller for the template module, this will be where the user manages 
* their designs, listed via site, they will be able to edit an existing design 
* or create a new one from wither a template or scratch.
* 
* There will also need to be links to the settings section for the designer 
* module, examples of settings being color palettes
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Template_IndexController extends Zend_Controller_Action
{
	/**
	* Type hinting for action helpers, hints the property to the code 
	* hinting class which exists in the library
	* 
	* @var Dlayer_Action_CodeHinting
	*/
	protected $_helper;

	private $session_dlayer;
	private $session_template;

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
		$this->session_template = new Dlayer_Session_Template();

		// Include js and css files in layout
		$this->layout = Zend_Layout::getMvcInstance();
		$this->layout->assign('js_include', array());
		$this->layout->assign('css_include', array());
	}

	/**
	* Dlayer action, root action of the controller
	* 
	* @return void
	*/
	public function indexAction()
	{
		$model_sites = new Dlayer_Model_Site();
		$model_templates = new Dlayer_Model_Template();

		$this->dlayerMenu('/template/index/index');
		$this->view->site = $model_sites->site($this->session_dlayer->siteId());
		$this->view->templates = $model_templates->templates(
			$this->session_dlayer->siteId());
		$this->view->template_id = $this->session_template->templateId();

		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - Template management');
	}

	/**
	* Generate the base menu bar for the application.
	* 
	* @param string $url Selected url
	* @return string Html
	*/
	private function dlayerMenu($url) 
	{
		$items = array(array('url'=>'/template/index/index', 
			'name'=>'Template designer', 'title'=>'Dlayer Template designer'), 
			array('url'=>'', 'name'=>'Designers', 'title'=>'Choose a designer', 
				'children'=>array(
					array('url'=>'/content/index/index', 
						'name'=>'Content manager', 'title'=>'Dlayer Content manager'), 
					array('url'=>'/form/index/index', 
						'name'=>'Form builder', 'title'=>'Dlayer Form builder'), 
					array('url'=>'/website/index/index', 
						'name'=>'Web site manager', 'title'=>'Dlayer Website manager'), 
					array('url'=>'/image/index/index', 
						'name'=>'Image library', 'title'=>'Dlayer Image library'))), 
			array('url'=>'/template/settings/index', 
				'name'=>'Settings', 'title'=>'Template designer settings'), 
			array('url'=>'/dlayer/index/logout', 'name'=>'<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Sign out (' . 
				$this->session_dlayer->identity() . ')', 'title'=>'Sign out of my app'));

		$this->layout->assign('nav', array('class'=>'top_nav', 
			'items'=>$items, 'active_url'=>$url));
	}

	/**
	* Activate another template, checks that the given template id is valid and 
	* that it belongs to the site id in the session. If valid the template is 
	* activated and the user is sent back to the index action
	* 
	* @return void
	*/
	public function activateAction() 
	{
		$this->_helper->disableLayout(FALSE);

		$template_id = Dlayer_Helper::getInteger('template-id');

		if($template_id != NULL) {   		
			$model_templates = new Dlayer_Model_Template();		
			if($model_templates->valid($template_id, 
			$this->session_dlayer->siteId()) == TRUE) {				
				$this->session_template->setTemplateId($template_id);
			}
		}

		$this->_redirect('/template');
	}

	/**
	* Allows the user to create a new template
	* 
	* @return void
	*/
	public function newTemplateAction() 
	{
		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - New web site template');

		$model_sites = new Dlayer_Model_Site();

		$form = new Dlayer_Form_Site_NewTemplate(
			$this->session_dlayer->siteId());

		// Validate and save the posted data
		if($this->getRequest()->isPost()) {

			$post = $this->getRequest()->getPost();

			if($form->isValid($post)) {
				$model_templates = new Dlayer_Model_Template();
				$template_id = $model_templates->addTemplate(
					$this->session_dlayer->siteId(), $post['name']);
				$this->session_template->clearAll(TRUE);
				$this->session_template->setTemplateId($template_id);
				$this->_redirect('/template');
			}
		}

		$this->view->form = $form;
		$this->view->site = $model_sites->site($this->session_dlayer->siteId());
		$this->dlayerMenu('/template/index/index');
	}

	/**
	* Allows the user to edit the details for the currently selected template
	* 
	* @return void
	*/
	public function editTemplateAction() 
	{		
		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - Edit web site template');

		$model_sites = new Dlayer_Model_Site();

		$form = new Dlayer_Form_Site_EditTemplate(
			$this->session_dlayer->siteId(), $this->session_template->templateId());

		// Validate and save the posted data
		if($this->getRequest()->isPost()) {

			$post = $this->getRequest()->getPost();

			if($form->isValid($post)) {
				$model_templates = new Dlayer_Model_Template();
				$model_templates->editTemplate($this->session_dlayer->siteId(), 
					$this->session_template->templateId(), $post['name']);
				$this->_redirect('/template');
			}
		}

		$this->view->form = $form;
		$this->view->site = $model_sites->site($this->session_dlayer->siteId());
		$this->dlayerMenu('/template/index/index');
	}
}