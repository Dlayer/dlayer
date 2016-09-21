<?php
/**
* The design controller is the root of the web site manager, this is where
* the user manages the relationships between pages and also manages the site 
* level data for widgets
*
* The manager has a tool bar to the right that shows all the tools for the
* selected page and a options section underneath for all the controls
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Website_DesignController extends Zend_Controller_Action
{
	/**
	* Type hinting for action helpers, hints the property to the code
	* hinting class which exists in the library
	*
	* @var Dlayer_Action_CodeHinting
	*/
	protected $_helper;

	private $session_dlayer;
	private $session_website;

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
		$this->session_website = new Dlayer_Session_Website();

		// Include js and css files in layout
		$this->layout = Zend_Layout::getMvcInstance();
		$this->layout->assign('js_include', array('scripts/dlayer.js'));
		$this->layout->assign('css_include', 
			array(
				'css/dlayer.css', 
				'css/designer-970.css',
			)
		);
	}

	/**
	* Base action for the designer controller, loads in the html for the
	* menu, ribbon, modes, toolbar and template
	*
	* @return void
	*/
	public function indexAction()
	{
		$this->navBar('/website/index/index');
		$this->view->dlayer_toolbar = $this->dlayerToolbar();
		$this->view->dlayer_website = $this->dlayerWebsite();
		$this->view->dlayer_ribbon = $this->dlayerRibbon();
		
		$this->layout->assign('title', 'Dlayer.com - Web site manager');
	}

	/**
	* Assign the content for the nav bar
	* 
	* @param string $active_uri Uri
	* @return void Assigns values to the layout
	*/
	private function navBar($active_uri) 
	{
		$items = array(
			array('uri'=>'/dlayer/index/home', 'name'=>'Dlayer Demo', 
				'title'=>'Dlayer.com: Web development simplified'),
			array('uri'=>'/website/index/index', 
				'name'=>'Web site manager', 'title'=>'Web site management'), 
			array('uri'=>'/dlayer/settings/index', 
				'name'=>'Settings', 'title'=>'Settings'), 
			array('uri'=>'http://www.dlayer.com/docs/', 
				'name'=>'Docs', 'title'=>'Read the Docs for Dlayer')
		);
		
		$this->layout->assign('nav', array(
			'class'=>'top_nav', 'items'=>$items, 'active_uri'=>$active_uri));		
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

		$this->view->page_id = $this->session_website->pageId();
		$this->view->tools = $model_module->tools(
			$this->getRequest()->getModuleName());
		$this->view->tool = $this->session_website->tool();

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
		$tool = $this->session_website->tool();

		if($tool != FALSE) {
			$html = $this->dlayerRibbonHtml($tool['tool'], $tool['tab']);
		} else {
			$ribbon = new Dlayer_Ribbon();
			$html = $this->view->render($ribbon->defaultViewScriptPath());
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

		$tabs = $ribbon->tabs($this->getRequest()->getModuleName(), $tool);

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

				$this->session_website->setRibbonTab($tab);

				$this->view->page_id = $this->session_website->pageId();
				$this->view->data = $ribbon_tab->viewData($module, $tool,
					$tab, $multi_use);

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
	* Generate the html for the web site overview, includes a section for 
	* un assigned pages and also a section for the pages in the site.
	* 
	* The user can only ever see three levels of the site map at one time, 
	* their selected level, the children and the parents
	*
	* @return string
	*/
	private function dlayerWebsite()
	{
		$designer_website = new Dlayer_Designer_Website(
			$this->session_dlayer->siteId(), $this->session_website->pageId());

		$this->view->unassigned_pages = $designer_website->unassignedPages();
		$this->view->selected_pages = $designer_website->selectedPages();
		$this->view->parent_pages = $designer_website->parentPages();
		$this->view->child_pages = $designer_website->childPages();

		return $this->view->render("design/website.phtml");
	}

	/**
	* Sets the selected page as the active page, designer then updates to show
	* the new children and parents
	* 
	* @return void
	*/
	public function setSelectedPageAction()
	{
		$this->_helper->disableLayout(FALSE);

		$id = $this->getRequest()->getParam('selected');
		$this->session_website->setPageId($id);
		$this->_redirect('/website/design');
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
				if($this->session_website->setTool($tool) == TRUE) {
					$this->_redirect('/website/design');
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
	* The cancel tool clears all the currently set web site manager template 
	* vars, user is returned to the manager after all session data is cleared
	*
	* @return void
	*/
	private function cancelTool()
	{
		$this->session_website->clearAll();
		$this->_redirect('/website/design');
	}
}
