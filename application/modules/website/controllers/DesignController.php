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

	/**
	 * @var Dlayer_Session_Website
	 */
	private $session_website;

	private $layout;

	/**
	 * @var array Nav bar items
	 */
	private $nav_bar_items = array(
		array('uri' => '/dlayer/index/home', 'name' => 'Dlayer Demo', 'title' => 'Dlayer.com: Web development simplified'),
		array('uri' => '/website/index/index', 'name' => 'Web site manager', 'title' => 'Web site management'),
		array('uri' => '/dlayer/settings/index', 'name' => 'Settings', 'title' => 'Settings'),
		array('uri' => 'http://www.dlayer.com/docs/', 'name' => 'Docs', 'title' => 'Read the Docs for Dlayer'),
	);

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
	}

	/**
	 * Base action for the designer controller, loads in the html for the
	 * menu, ribbon, modes, toolbar and template
	 *
	 * @return void
	 */
	public function indexAction()
	{
		$this->view->dlayer_toolbar = $this->dlayerToolbar();
		$this->view->dlayer_website = $this->dlayerWebsite();
		$this->view->dlayer_ribbon = $this->dlayerRibbon();

		$this->_helper->setLayoutProperties($this->nav_bar_items, '/form/index/index',
			array('css/dlayer.css','css/designer-shared.css', 'css/designer-1170.css'),
			array('scripts/dlayer.js', 'scripts/designer.js'),
			'Dlayer.com - Web site manager');
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
		$model_tool = new Dlayer_Model_Tool();

		$this->view->page_id = $this->session_website->pageId();

		$this->view->tools = $model_tool->tools($this->getRequest()->getModuleName());
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

		if($tool != FALSE)
		{
			$html = $this->dlayerRibbonHtml($tool['tool'], $tool['tab']);
		}
		else
		{
			$ribbon = new Dlayer_Ribbon();
			$html = $this->view->render($ribbon->defaultViewScriptPath());
		}

		$this->view->html = $html;

		return $this->view->render('design/ribbon.phtml');
	}

	/**
	 * Generate the tabs for the selected tool, an empty container is generated for each tab which will be populated
	 * via an AJAX request
	 *
	 * @param string $tool
	 * @param string $tab
	 * @param string|NULL $sub_tool
	 * @return string
	 */
	private function dlayerRibbonHtml($tool, $tab, $sub_tool = NULL)
	{
		$model_tool = new Dlayer_Model_Tool();
		$tabs = $model_tool->toolTabs('website', $tool, FALSE);

		if($tabs != FALSE)
		{
			$this->view->selected_tool = $tool;
			$this->view->selected_tab = $tab;
			$this->view->selected_sub_tool = $sub_tool;
			$this->view->tabs = $tabs;
			$this->view->module = 'website';
			$html = $this->view->render('design/ribbon/ribbon-html.phtml');
		}
		else
		{
			$html = $this->view->render('design/ribbon/default.phtml');
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

		$module = $this->getRequest()->getModuleName();
		$tool = $this->getParamAsString('tool');
		$sub_tool = $this->getParamAsString('sub_tool');
		$tab = $this->getParamAsString('tab');

		if($tool !== NULL && $tab !== NULL)
		{
			$model_tool = new Dlayer_Model_Tool();

			$exists = $model_tool->tabExists($this->getRequest()->getModuleName(), $tool, $tab);

			if($exists === TRUE)
			{
				/**
				 * @todo Need to remove this class eventually
				 */
				$ribbon_tab = new Dlayer_Ribbon_Tab();

				$this->session_website->setRibbonTab($tab, $sub_tool);

				$this->view->data = $ribbon_tab->viewData($module, $tool, $tab, $model_tool->multiUse($module, $tool, $tab), FALSE);

				if($sub_tool === NULL)
				{
					$this->view->addScriptPath(DLAYER_LIBRARY_PATH . "\\Dlayer\\DesignerTool\\WebsiteManager\\" .
						$tool . "\\scripts\\");
				}
				else
				{
					$this->view->addScriptPath(DLAYER_LIBRARY_PATH . "\\Dlayer\\DesignerTool\\WebsiteManager\\" .
						$tool . "\\SubTool\\" . $sub_tool ."\\scripts\\");
				}

				$html = $this->view->render($tab . '.phtml');
			}
			else
			{
				$html = $this->view->render("design\\ribbon\\default.phtml");
			}
		}
		else
		{
			$html = $this->view->render("design\\ribbon\\default.phtml");
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

		if($tool != NULL && strlen($tool) > 0)
		{
			if($tool !== 'Cancel')
			{
				if($this->session_website->setTool($tool) == TRUE)
				{
					$this->redirect('/website/design');
				}
				else
				{
					$this->cancelTool();
				}
			}
			else
			{
				$this->cancelTool();
			}
		}
		else
		{
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
		$this->redirect('/website/design');
	}

	/**
	 * Get a post param
	 *
	 * @todo Move this out of controller
	 * @param string $param
	 * @param integer|NULL $default
	 * @return string|NULL
	 */
	private function getParamAsString($param, $default = NULL)
	{
		return $this->getRequest()->getParam($param, $default);
	}
}
