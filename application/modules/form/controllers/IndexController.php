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
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Form_IndexController extends Zend_Controller_Action
{
	/**
	 * Type hinting for action helpers
	 *
	 * @var Dlayer_Action_CodeHinting
	 */
	protected $_helper;

	/**
	 * @var Dlayer_Session_Form
	 */
	private $session_form;

	private $site_id;

	/**
	 * @var Zend_Form
	 */
	private $form_form;

	/**
	 * @var array Nav bar items
	 */
	private $nav_bar_items = array(
		array('uri'=>'/dlayer/index/home', 'name'=>'Dlayer Demo', 'title'=>'Dlayer.com: Web development simplified'),
		array('uri'=>'/form/index/index','name'=>'Form builder', 'title'=>'Form builder'),
		array('uri'=>'/form/settings/index','name'=>'Settings', 'title'=>'Settings'),
		array('uri'=>'http://www.dlayer.com/docs/', 'name'=>'Docs', 'title'=>'Read the Docs for Dlayer'),
	);

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

		$session_dlayer = new Dlayer_Session();

		$this->site_id = $session_dlayer->siteId();
		$this->session_form = new Dlayer_Session_Form();
	}

	/**
	* Dlayer action, root action of the controller
	* 
	* @return void
	*/
	public function indexAction()
	{
		$model_forms = new Dlayer_Model_Form();
		$model_sites = new Dlayer_Model_Site();

		$this->view->forms = $model_forms->forms($this->site_id);
		$this->view->form_id = $this->session_form->formId();
		$this->view->site = $model_sites->site($this->site_id);

		$this->_helper->setLayoutProperties($this->nav_bar_items, '/form/index/index', array('css/dlayer.css'),
			array(), 'Dlayer.com - Form builder');
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

		$session_dlayer = new Dlayer_Session();

		$form_id = Dlayer_Helper::getInteger('form-id');
		$load = Dlayer_Helper::getInteger('load');
		$return = $this->getRequest()->getParam('return');

		if($form_id !== NULL)
		{
			$model_forms = new Dlayer_Model_Form();        
			if($model_forms->valid($form_id, $session_dlayer->siteId()) === TRUE)
			{
				$this->session_form->clearAll();
				$this->session_form->setFormId($form_id);
			}
		}

		if($load !== NULL && $return !== NULL && $load == 1 && in_array($return, array('content')) == TRUE)
		{
			$this->session_form->setReturnModule($return);
			$this->redirect('/form/design/');
		}
		else
		{
			$this->redirect('/form');
		}
	}

	/**
	 * Create a new form for use on the site, initially user needs to define the name for the form, a title and
	 * the email to use if the form is to send copy of submissions
	 *
	 * @return void
	 */
	public function newFormAction() 
	{
		$model_sites = new Dlayer_Model_Site();

		$this->form_form = new Dlayer_Form_Site_Form('/form/index/new-form', $this->site_id);

		if($this->getRequest()->isPost())
		{
			$this->handleAddForm();
		}

		$this->view->form = $this->form_form;
		$this->view->site = $model_sites->site($this->site_id);

		$this->_helper->setLayoutProperties($this->nav_bar_items, '/content/index/index', array('css/dlayer.css'),
			array(), 'Dlayer.com - New content page');
	}

	/**
	 * Edit the details for the selected form
	 *
	 * @return void
	 */
	public function editFormAction()
	{
		$model_sites = new Dlayer_Model_Site();

		$this->form_form = new Dlayer_Form_Site_Form('/form/index/edit-form', $this->site_id,
			$this->session_form->formId());

		if($this->getRequest()->isPost())
		{
			$this->handleEditForm();
		}

		$this->view->form = $this->form_form;
		$this->view->site = $model_sites->site($this->site_id);

		$this->_helper->setLayoutProperties($this->nav_bar_items, '/form/index/index', array('css/dlayer.css'),
			array(), 'Dlayer.com - Edit form');
	}

	/**
	 * Handle add form, if successful the user is redirected after the id for the new form has been set in the session
	 *
	 * @return void
	 */
	private function handleAddForm()
	{
		$post = $this->getRequest()->getPost();

		if($this->form_form->isValid($post))
		{
			$model_forms = new Dlayer_Model_Form();
			$form_id = $model_forms->saveForm($this->site_id, $post['name'], $post['email'], $post['title'],
				$post['sub_title']);

			if($form_id !== FALSE)
			{
				$this->session_form->clearAll(TRUE);
				$this->session_form->setFormId($form_id);
				$this->redirect('/form');
			}
		}
	}

	/**
	 * Handle edit form, if successful the user is redirected back to form builder root
	 *
	 * @return void
	 */
	private function handleEditForm()
	{
		$post = $this->getRequest()->getPost();

		if($this->form_form->isValid($post))
		{
			$model_forms = new Dlayer_Model_Form();
			$form_id = $model_forms->saveForm($this->site_id, $post['name'], $post['email'], NULL, NULL,
				$this->session_form->formId());

			if($form_id !== FALSE)
			{
				$this->redirect('/form');
			}
		}
	}
}
