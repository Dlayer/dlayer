<?php

/**
 * The design controller is the UI for the for Content manager, all processing is handled by the process controller, the Content manager attempts to show a live, responsive, visually accurate versions of the content page being worked upon
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Content_DesignController extends Zend_Controller_Action
{
	/**
	 * Type hinting for action helpers, hints the property to the code hinting class so we can see the action helpers
	 *
	 * @var Dlayer_Action_CodeHinting
	 */
	protected $_helper;

	/**
	 * @var integer Id for the currently selected site
	 */
	protected $site_id;

	/**
	 * @var integer Id for the currently selected content page
	 */
	protected $page_id;

	/**
	 * @var Dlayer_Session_Content Content manager session, manages state of designer environment
	 */
	private $session_content;

	/**
	 * @var Dlayer_Session_Designer Designer session, manages state of shared designer tools, the colour picker and image picker
	 */
	private $session_designer;

	/**
	 * @var array Nav bar items
	 */
	private $nav_bar_items = array(
		array('uri' => '/dlayer/index/home', 'name' => 'Dlayer Demo', 'title' => 'Dlayer.com: Web development simplified'),
		array('uri' => '/content/index/index', 'name' => 'Content manager', 'title' => 'Content manager'),
		array('uri' => '/content/settings/index', 'name' => 'Settings', 'title' => 'Settings'),
		array('uri' => 'http://www.dlayer.com/docs/', 'name' => 'Dlayer Docs', 'title' => 'Read the Docs for Dlayer'),
	);

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

		$session_dlayer = new Dlayer_Session();
		$this->site_id = $session_dlayer->siteId();

		$this->session_content = new Dlayer_Session_Content();
		$this->page_id = $this->session_content->pageId();

		$this->session_designer = new Dlayer_Session_Designer();
	}

	/**
	 * Base action for the design controller, fetches the html/data for the tool bar ribbon and content page
	 *
	 * @return void
	 */
	public function indexAction()
	{
		$this->_helper->setLayout('designer');

		$this->view->dlayer_toolbar = $this->dlayerToolbar();
		$this->view->dlayer_page = $this->dlayerPage();
		$this->view->dlayer_ribbon = $this->dlayerRibbon();

		$this->view->module = $this->getRequest()->getModuleName();
		$this->view->page_selected = $this->session_content->pageSelected();
		$this->view->row_id = $this->session_content->rowId();
		$this->view->content_id = $this->session_content->contentId();
		$this->view->tool = $this->session_content->tool();

		$this->_helper->setLayoutProperties($this->nav_bar_items, '/content/design/index',
			array('css/dlayer.css', 'css/designer-shared.css', 'css/designer-1170.css',),
			array('scripts/dlayer.js','scripts/designer.js', 'scripts/content-manager.js'),
			'Dlayer.com - Content manager', '/content/design/preview');
	}

	/**
	 * Preview for design
	 *
	 * @return void
	 */
	public function previewAction()
	{
		$this->_helper->setLayout('preview');

		$this->view->dlayer_page = $this->dlayerPagePreview();

		$layout = Zend_Layout::getMvcInstance();
		$layout->assign('css_include', array('css/dlayer.css'));
		$layout->assign('js_include', array());
		$layout->assign('title', 'Dlayer.com - Design preview');
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

		$this->view->page_selected = $this->session_content->pageSelected();
		$this->view->row_id = $this->session_content->rowId();
		$this->view->column_id = $this->session_content->columnId();
		$this->view->content_id = $this->session_content->contentId();

		$this->view->tools = $model_tool->tools($this->getRequest()->getModuleName());
		$this->view->tool = $this->session_content->tool();

		return $this->view->render("design/toolbar.phtml");
	}

	/**
	 * Generate the HTML for the ribbon, there are two states, tool selected and then the default view, if a tool is
	 * selected we let the ribbon load the relevant HTML
	 *
	 * @return string
	 */
	private function dlayerRibbon()
	{
		$tool = $this->session_content->tool();

		if($tool !== FALSE)
		{
			$html = $this->dlayerRibbonHtml($tool['tool'], $tool['tab'], $tool['sub_tool']);
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
		if($this->session_content->contentId() != NULL)
		{
			$edit_mode = TRUE;
		}
		else
		{
			$edit_mode = FALSE;
		}

		$model_tool = new Dlayer_Model_Tool();
		$tabs = $model_tool->toolTabs('content', $tool, $edit_mode);

		if($tabs !== FALSE)
		{
			$this->view->selected_tool = $tool;
			$this->view->selected_tab = $tab;
			$this->view->selected_sub_tool = $sub_tool;
			$this->view->tabs = $tabs;
			$this->view->module = 'content';
			$html = $this->view->render('design/ribbon/ribbon-html.phtml');
		}
		else
		{
			$html = $this->view->render('design/ribbon/default.phtml');
		}

		return $html;
	}

	/**
	 * Fetch the data for the color picker, passed to the ribbon tab view
	 * so color picker can be pre populated for all tabs.
	 *
	 * Returns an array with two indexs, palettes and history, if there was a
	 * problem fetching data FALSE will be returned for the index that failed,
	 * the view will display a friendly error message
	 *
	 * @return array
	 */
	private function colorPickerData()
	{
		$model_palettes = new Dlayer_Model_Palette();

		return array(
			'palettes' => $model_palettes->palettes($this->site_id),
			'history' => $model_palettes->lastNColors($this->site_id),
		);
	}

	/**
	 * Generate the html for the requested tool tab, called via Ajax. The tool and tab are checked to ensure they are
	 * valid and active and then the data required to generate the tool tab is fetched and passed too the view
	 *
	 * @todo Update code, needs to actually check validity of tool and current status
	 * @throws \Exception
	 * @return string
	 */
	public function ribbonTabHtmlAction()
	{
		$this->_helper->disableLayout();

		$module = $this->getRequest()->getModuleName();
		$tool = $this->getParamAsString('tool');
		$sub_tool = $this->getParamAsString('sub_tool');
		$tab_script = $this->getParamAsString('tab_script');

		$ribbon = new Dlayer_Ribbon();
		$ribbon_tab = new Dlayer_Ribbon_Tab();

		if($tool !== NULL && $tab_script !== NULL)
		{
			$exists = $ribbon_tab->viewScript($this->getRequest()->getModuleName(), $tool, $tab_script, TRUE);
			$multi_use = $ribbon_tab->multiUse($module, $tool, $tab_script);

			if($exists === TRUE)
			{
				if($this->session_content->contentId() !== NULL)
				{
					$edit_mode = TRUE;
				}
				else
				{
					$edit_mode = FALSE;
				}
				$this->session_content->setRibbonTab($tab_script, $sub_tool);

				$this->view->color_picker_data = $this->colorPickerData();
				$this->view->data = $ribbon_tab->viewData($module, $tool, $tab_script, $multi_use, $edit_mode);

				if($sub_tool === NULL)
				{
					$this->view->addScriptPath(DLAYER_LIBRARY_PATH . "\\Dlayer\\DesignerTool\\ContentManager\\" .
						$tool . "\\scripts\\");
				}
				else
				{
					$this->view->addScriptPath(DLAYER_LIBRARY_PATH . "\\Dlayer\\DesignerTool\\ContentManager\\" .
						$tool . "\\SubTool\\" . $sub_tool ."\\scripts\\");
				}

				$html = $this->view->render($tab_script . '.phtml');
			}
			else
			{
				$html = $this->view->render($ribbon->defaultViewScriptPath());
			}
		}
		else
		{
			$html = $this->view->render($ribbon->defaultViewScriptPath());
		}

		$this->view->html = $html;
	}

	/**
	 * Generate the html for the content page, this will be as visually accurate to the live version of the
	 * page as possible
	 *
	 * The structure of the data is fetched and passed to the view for the structure view helpers to consume, after
	 * that all the defined styles for the page are fetched and passed to a base view helper which calls a child view
	 * helper for each item type and style group
	 *
	 * On the final version of Dlayer, public versions of the page will be generated by Dlayer and then exported,
	 * management is only ever possible within the Dlayer designers
	 *
	 * @return string
	 */
	private function dlayerPage()
	{
		// Instantiate the page object and styles object
		$designer_page = new Dlayer_Designer_Page($this->site_id, $this->page_id); // Fix this
		$designer_page_styles = new Dlayer_Designer_Styles_Page($this->site_id, $this->page_id);

		// fetch the styles defined in the settings, heading styles and base font families
		$this->view->heading_styles = $designer_page_styles->headingStyles();
		$this->view->base_font_family_content = $designer_page_styles->baseFontFamilyContentManager();
		$this->view->base_font_family_form = $designer_page_styles->baseFontFamilyFormBuilder();

		// Fetch the data that defines the structure of the page
		$this->view->rows = $designer_page->rows();
		$this->view->columns = $designer_page->columns();
		$this->view->content = $designer_page->content();

		// Fetch the defined styles for this content page by item type
		/*$this->view->row_styles = $designer_page_styles->rowStyles();
		$this->view->content_container_styles = $designer_page_styles->contentContainerStyles();
		$this->view->content_styles = $designer_page_styles->contentItemStyles();
		$this->view->form_styles = $designer_page_styles->formStyles();*/

		$this->view->row_styles = array();
		$this->view->content_container_styles = array();
		$this->view->content_styles = array();
		$this->view->form_styles = array();

		// Set the vars to determine the state of the designer
		$this->view->page_selected = $this->session_content->pageSelected();
		$this->view->column_id = $this->session_content->columnId();
		$this->view->row_id = $this->session_content->rowId();
		$this->view->content_id = $this->session_content->contentId();

		return $this->view->render("design/page.phtml");
	}

	/**
	 * Generate the preview for the page being created/edited
	 *
	 * @return string
	 */
	private function dlayerPagePreview()
	{
		// Instantiate the page object and styles object
		$designer_page = new Dlayer_Designer_Page($this->site_id, $this->page_id); // Fix this
		$designer_page_styles = new Dlayer_Designer_Styles_Page($this->site_id, $this->page_id);

		// fetch the styles defined in the settings, heading styles and base font families
		$this->view->heading_styles = $designer_page_styles->headingStyles();
		$this->view->base_font_family_content = $designer_page_styles->baseFontFamilyContentManager();
		$this->view->base_font_family_form = $designer_page_styles->baseFontFamilyFormBuilder();

		// Fetch the data that defines the structure of the page
		$this->view->rows = $designer_page->rows();
		$this->view->columns = $designer_page->columns();
		$this->view->content = $designer_page->content();

		$this->view->row_styles = array();
		$this->view->content_container_styles = array();
		$this->view->content_styles = array();
		$this->view->form_styles = array();

		return $this->view->render("design/page-preview.phtml");
	}

	/**
	 * Set the id for the selected row
	 *
	 * @todo Add a check to ensure id is valid, check needs to look at set column (page). Not sure yet if check is best in this controller, an action helper ot in the session class, review
	 * @return void
	 */
	public function setSelectedRowAction()
	{
		$this->_helper->disableLayout(FALSE);

		$id = $this->getRequest()->getParam('id');
		if($this->session_content->setTool('row') === TRUE)
		{
			$this->session_content->setRowId($id);
		}

		$this->redirect('/content/design');
	}

	/**
	 * Set the id for the selected column
	 * 
	 * @todo As above add a check for column validity
	 * @return void
	 */
	public function setSelectedColumnAction()
	{
		$this->_helper->disableLayout(FALSE);

		$id = $this->getRequest()->getParam('id');

		if($this->session_content->setTool('column') === TRUE) 
		{
			$this->session_content->setColumnId($id);
		}

		$this->redirect('/content/design/');
	}
	

	/**
	 * Set the current page as selected in the designer
	 *
	 * @todo Add a check to ensure id is valid, check needs to ensure page is valid for user. Not sure yet if check is best in this controller, an action helper ot in the session class, review
	 * @return void
	 */
	public function setPageSelectedAction()
	{
		$this->_helper->disableLayout(FALSE);

		if($this->session_content->setTool('Page') === TRUE) {
			$this->session_content->setPageSelected();
		}

		$this->redirect('/content/design');
	}

	/**
	 * Set the id for the selected content item
	 *
	 * @return void
	 */
	public function setSelectedContentAction()
	{
		$this->_helper->disableLayout(FALSE);

		$id = $this->getParamAsInteger('id');
		$tool = $this->getParamAsString('tool');
		$content_type = $this->getParamAsString('content-type');

		if($this->session_content->setContentId($id, $content_type) === TRUE &&
			$this->session_content->setTool($tool) === TRUE)
		{
			$this->redirect('/content/design');
		}
		else
		{
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

		if($tool != NULL && strlen($tool) > 0)
		{
			if($tool != 'cancel')
			{
				if($this->session_content->setTool($tool) == TRUE)
				{
					$reset = $this->getRequest()->getParam('reset');

					if($reset != NULL && $reset == 1)
					{
						$this->session_content->clearContentId();
						$this->session_designer->clearAllImagePicker();
					}

					$this->redirect('/content/design');
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
	 * The cancel tool clears all the currently set content template vars, the
	 * user is returned to the manager after the session is cleared
	 *
	 * @return void
	 */
	private function cancelTool()
	{
		$this->session_content->clearAll();
		$this->session_designer->clearAllImagePicker();

		$this->redirect('/content/design');
	}

	/**
	 * Move the row in the desired direction
	 *
	 * @return void User redirected back to designer regardless of outcome
	 */
	public function moveRowAction()
	{
		$this->_helper->disableLayout(FALSE);

		$direction = $this->getParamAsString('direction');
		$row_id = $this->getParamAsInteger('id');
		$page_id = $this->session_content->pageId();
		$column_id = $this->session_content->columnId();

		$model_page_content = new Dlayer_Model_Page_Content();
		$model_page_content->moveRow($this->site_id, $page_id, $column_id, $row_id, $direction);

		$this->redirect('/content/design');
	}

	/**
	 * Move the column in the desired direction
	 *
	 * @return void User is redirected back to designer regardless of outcome
	 */
	public function moveColumnAction()
	{
		$this->_helper->disableLayout(FALSE);

		$direction = $this->getParamAsString('direction');
		$column_id = $this->getParamAsInteger('id');
		$page_id = $this->session_content->pageId();
		$row_id = $this->session_content->rowId();

		$model_page_content = new Dlayer_Model_Page_Content();
		$model_page_content->moveColumn($this->site_id, $page_id, $row_id, $column_id, $direction);

		$this->redirect('/content/design');
	}

	/**
	 * Move the selected content item, before passing the request to the model
	 * we check to ensure that the item can be moved in the requested direction
	 * and also that the content item is valid for the requested content type and
	 * page div
	 *
	 * @return div
	 */
	public function moveContentAction()
	{
		$this->_helper->disableLayout(FALSE);

		$direction = $this->getRequest()->getParam('direction');
		$content_id = $this->getRequest()->getParam('id');
		$page_id = $this->session_content->pageId();
		$column_id = $this->session_content->columnId();

		$model_page_content = new Dlayer_Model_Page_Content();
		$model_page_content->moveContent($this->site_id, $page_id, $column_id, $content_id, $direction);

		$this->redirect('/content/design/');
	}

	/**
	 * Get a post param
	 *
	 * @todo Move this out of controller
	 * @param string $param
	 * @param integer|NULL $default
	 * @return integer|NULL
	 */
	private function getParamAsInteger($param, $default = NULL)
	{
		return ($this->getRequest()->getParam($param) !== '' ? intval($this->getRequest()->getParam($param)) : $default);
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
