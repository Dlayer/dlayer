<?php
/**
* Root controller for the form builder module, this is where the user can 
* design all the forms that can be used for a site.
* 
* @note Forms are linked to a site not a template, there are likely to be 
* muiltiple templates for a site
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Form_IndexController extends Zend_Controller_Action
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
		$model_forms = new Dlayer_Model_Form();

		$this->dlayerMenu('/form/index/index');
		$this->view->forms = $model_forms->forms(
			$this->session_dlayer->siteId());
		$this->view->form_id = $this->session_form->formId();

		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - Form builder');
	}

	/**
	* Generate the base menu bar for the application.
	* 
	* @param string $url Selected url
	* @return string Html
	*/
	private function dlayerMenu($url) 
	{
		$items = array(array('url'=>'/form/index/index', 
			'name'=>'Form builder', 'title'=>'Dlayer Form builder'), 
			array('url'=>'', 'name'=>'Designers', 'title'=>'Choose a designer', 
				'children'=>array(
					array('url'=>'/content/index/index', 
						'name'=>'Content manager', 
						'title'=>'Dlayer Content manager'), 
					array('url'=>'/widget/index/index', 
						'name'=>'Widget designer', 
						'title'=>'Dlayer Widget designer'), 
					array('url'=>'/image/index/index', 
						'name'=>'Image library', 
						'title'=>'Dlayer Image library'),
					array('url'=>'/website/index/index', 
						'name'=>'Web site manager', 
						'title'=>'Dlayer Website manager'), 
					array('url'=>'/template/index/index', 
						'name'=>'Template designer', 
						'title'=>'Dlayer Template designer'))),
			array('url'=>'/form/settings/index', 
				'name'=>'Settings', 'title'=>'Form builder settings'), 
			array('url'=>'/dlayer/index/logout', 'name'=>'<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Sign out (' . 
				$this->session_dlayer->identity() . ')', 'title'=>'Sign out of my app'));

		$this->layout->assign('nav', array('class'=>'top_nav', 
			'items'=>$items, 'active_url'=>$url));
	}

	/**
	* Activate another form, checks that the given form id is valid and 
	* that it belongs to the site id in the session. If valid the form is 
	* activated and the user is sent back to the index action.
	* 
	* In addition to setting the form id the action clears the form session 
	* values to ensure no incorrect values can exist
	* 
	* If the load and return URL params are set the user will be sent directly 
	* to the designer and a session value will be set so a link can't be 
	* generated to allow the user to return to the preview designer.
	* 
	* @example /form/index/activate/form-id/1/load/1/return/content
	* 
	* @return void
	*/
	public function activateAction() 
	{
		$this->_helper->disableLayout(FALSE);

		$site_id = $this->session_dlayer->siteId();
		$form_id = Dlayer_Helper::getInteger('form-id');
		$load = Dlayer_Helper::getInteger('load');
		$return = $this->getRequest()->getParam('return');

		if($form_id != NULL) {           
			$model_forms = new Dlayer_Model_Form();        
			if($model_forms->valid($form_id, $site_id) == TRUE) {
				$this->session_form->clearAll();
				$this->session_form->setFormId($form_id);
			}
		}

		if($load != NULL && $return != NULL && $load == 1 && 
		in_array($return, array('content')) == TRUE) {
			$this->session_form->setReturnModule($return);
			$this->_redirect('/form/design/');
		} else {
			$this->_redirect('/form');
		}
	}

	/**
	* Allows the user to create a new form for the currently selected site
	* 
	* @return void
	*/
	public function newFormAction() 
	{
		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - New form');

		$model_sites = new Dlayer_Model_Site();

		$form = new Dlayer_Form_Site_NewForm($this->session_dlayer->siteId());

		// Validate and save the posted data
		if($this->getRequest()->isPost()) {

			$post = $this->getRequest()->getPost();

			if($form->isValid($post)) {
				$model_forms = new Dlayer_Model_Form();
				$form_id = $model_forms->addForm(
					$this->session_dlayer->siteId(), $post['name'], 
					$post['title']);
				$this->session_form->clearAll(TRUE);
				$this->session_form->setFormId($form_id);
				$this->_redirect('/form');
			}
		}

		$this->view->form = $form;
		$this->view->site = $model_sites->site($this->session_dlayer->siteId());
		$this->dlayerMenu('/form/index/index');
	}

	/**
	* Allows the user to edit the details for the currently selected form
	* 
	* @return void
	*/
	public function editFormAction() 
	{
		$this->layout->assign('css_include', array('css/dlayer.css'));
		$this->layout->assign('title', 'Dlayer.com - Edit form');

		$model_sites = new Dlayer_Model_Site();

		$form = new Dlayer_Form_Site_EditForm($this->session_dlayer->siteId(), 
			$this->session_form->formId());

		// Validate and save the posted data
		if($this->getRequest()->isPost()) {

			$post = $this->getRequest()->getPost();

			if($form->isValid($post)) {
				$model_forms = new Dlayer_Model_Form();
				$model_forms->editForm($this->session_dlayer->siteId(), 
					$this->session_form->formId(), $post['name']);
				$this->_redirect('/form');
			}
		}

		$this->view->form = $form;
		$this->view->site = $model_sites->site($this->session_dlayer->siteId());
		$this->dlayerMenu('/form/index/index');
	}
}