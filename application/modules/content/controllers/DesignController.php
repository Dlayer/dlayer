<?php
/**
* The design controller is the root of the content manager, this is where
* the user add content to a page. A page is based on an template and the user
* get to see a visually accurate version of their page
*
* The manager has a tool bar to the right that shows all the tools for the
* selected div or content field and a ribbon at the top that updates based on
* the selected item
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Content_DesignController extends Zend_Controller_Action
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

		$this->_helper->validateTemplateId(TRUE);

		$this->_helper->validateContentId();

		$this->session_dlayer = new Dlayer_Session();
		$this->session_content = new Dlayer_Session_Content();

		// Include js and css files in layout
		$this->layout = Zend_Layout::getMvcInstance();
		$this->layout->assign('js_include', array('scripts/dlayer.js'));
		$this->layout->assign('css_include', array('styles/designer.css',
			'styles/designer/content.css', 
			'styles/designer/content-item-form.css', 'styles/ribbon.css',
			'styles/ribbon/content.css'));
	}

	/**
	* Base action for the designer controller, loads in the html for the
	* menu, ribbon, modes, toolbar and template
	*
	* @return void
	*/
	public function indexAction()
	{
		$this->dlayerMenu('/content/index/index');
		$this->view->dlayer_toolbar = $this->dlayerToolbar();
		$this->view->dlayer_page = $this->dlayerPage();
		$this->view->dlayer_ribbon = $this->dlayerRibbon();

		$this->view->module = $this->getRequest()->getModuleName();
		$this->view->div_id = $this->session_content->divId();
		$this->view->content_id = $this->session_content->contentId();
		$this->view->tool = $this->session_content->tool();

		$this->layout->assign('css_include', 
			array('css/dlayer.css', 'css/designers.css'));
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
			array('url'=>'/dlayer/index/logout', 'name'=>'<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout (' . 
				$this->session_dlayer->identity() . ')', 'title'=>'Logout'));

		$this->layout->assign('nav', array('class'=>'top_nav', 
			'items'=>$items, 'active_url'=>$url));
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

		$this->view->div_id = $this->session_content->divId();
		$this->view->content_id = $this->session_content->contentId();
		$this->view->tools = $model_module->tools(
			$this->getRequest()->getModuleName());
		$this->view->tool = $this->session_content->tool();

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
		$tool = $this->session_content->tool();

		if($tool != FALSE) {
			$html = $this->dlayerRibbonHtml($tool['tool'], $tool['tab']);
		} else {
			$ribbon = new Dlayer_Ribbon();

			if($this->session_content->divId() != NULL) {
				$html = $this->view->render($ribbon->selectedViewScriptPath());
			} else {
				$html = $this->view->render($ribbon->defaultViewScriptPath());
			}
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

		$edit_mode = FALSE;

		if($this->session_content->contentId() != NULL) {
			$edit_mode = TRUE;
		}

		$tabs = $ribbon->tabs($this->getRequest()->getModuleName(), $tool, 
			$edit_mode);

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
	* Fetch the page container metrics
	* 
	* @return array Contains the usable height and width for the page container
	*/
	private function pageContainerMetrics() 
	{
		$metrics = array('width'=>0, 'height'=>'Dynamic');

		if($this->session_content->divId() != NULL && 
		$this->session_content->tool() != FALSE) {
			$model_template_div = new Dlayer_Model_Template_Div();
			$site_id = $this->session_dlayer->siteId();
			$div_id = $this->session_content->divId();

			$metrics['width'] = $model_template_div->width($site_id, 
				$div_id);

			$height = $model_template_div->height($site_id, $div_id);
			if($height['fixed'] == TRUE) {
				$metrics['height'] = $height['height'] . ' pixels';
			}
		}

		return $metrics;
	}

	/**
	* Fetch the content item metrics for the selected content item
	* 
	* @return array An array containing the metrics for the selected 
	*                 content item 
	*/
	private function contentItemMetrics() 
	{
		$metrics = array('width'=>0, 'height'=>'Dynamic', 
			'border'=>array('top'=>0, 'right'=>0, 'bottom'=>0, 'left'=>0), 
			'margin'=>array('top'=>0, 'right'=>0, 'bottom'=>0, 'left'=>0), 
			'padding'=>array('top'=>0, 'right'=>0, 'bottom'=>0, 'left'=>0));

		$model_metrics = new Dlayer_Model_Page_Content_Metrics();

		$item_metrics = $model_metrics->data(
			$this->session_dlayer->siteId(), $this->session_content->pageId(), 
			$this->session_content->divId(), $this->session_content->contentId());

		if($item_metrics != FALSE) {
			$metrics = $item_metrics;
		}

		return $metrics;
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

		$site_id = $this->session_dlayer->siteId();

		return array('palettes'=>$model_palettes->palettes($site_id), 
			'history'=>$model_palettes->lastNColors($site_id));
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

				$this->session_content->setRibbonTab($tab);

				$edit_mode = FALSE;
				if($this->session_content->contentId() != NULL) {
					$edit_mode = TRUE;
				}

				$this->view->color_picker_data = $this->colorPickerData();
				$this->view->div_id = $this->session_content->divId();
				$this->view->data = $ribbon_tab->viewData($module, $tool,
					$tab, $multi_use, $edit_mode);
				$this->view->edit_mode = $edit_mode;

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
	* Generate the html for the page, this will be a visually accurate
	* version of the page
	*
	* The template data is pulled from the database and then passed to the view,
	* multiple view helpers are called in the view to generate the final html,
	* styles and content are included
	*
	* In the final version of Dlayer, public versions of web sites won't be
	* generating the html in real-time, a version will be exported from
	* Dlayer and that will be used for the public site. The goal being that
	* the entire system is transparent to both the end users and Dlayer users
	*
	* @return string
	*/
	private function dlayerPage()
	{
		$designer_page = new Dlayer_Designer_Page(
			$this->session_dlayer->siteId(), $this->session_content->templateId(),
			$this->session_content->pageId(), $this->session_content->divId(),
			$this->session_content->contentId());

		$model_settings = new Dlayer_Model_View_Settings();

		$this->view->heading_styles = $model_settings->headingStyles(
			$this->session_dlayer->siteId());
		$this->view->base_font_family = $model_settings->baseFontFamily(
			$this->session_dlayer->siteId(), 'content');
		$this->view->template = $designer_page->template();
		$this->view->template_styles = $designer_page->templateStyles();
		$this->view->content_styles = $designer_page->contentStyles();
		$this->view->content = $designer_page->content();
		$this->view->form_field_styles = $designer_page->formFieldStyles();
		$this->view->div_id = $this->session_content->divId();
		$this->view->page_container_metrics = $this->pageContainerMetrics();
		if($this->session_content->divId() != NULL) {
			$this->view->content_item_metrics = $this->contentItemMetrics();
		}
		$this->view->content_id = $this->session_content->contentId();

		return $this->view->render("design/page.phtml");
	}

	/**
	* Sets the selected div and returns the user back to the designer so that
	* they can choose a content tool, this is a sister method to
	* setSelectedContentAction(), this sets the selected div, the other sets
	* the content block.
	*
	* @return void
	*/
	public function setSelectedDivAction()
	{
		$this->_helper->disableLayout(FALSE);

		$id = $this->getRequest()->getParam('selected');
		$this->session_content->setDivId($id);
		$this->_redirect('/content/design');
	}

	/**
	* Set the selected content item and returns the user back to the designer
	* with the content item selected and the ribbon showing the options and
	* data for the corresponding tool
	*
	* @return void
	*/
	public function setSelectedContentAction()
	{
		$this->_helper->disableLayout(FALSE);

		$id = $this->getRequest()->getParam('selected');
		$tool = $this->getRequest()->getParam('tool');
		$content_type = $this->getRequest()->getParam('content-type');

		if($this->session_content->setContentId($id, $content_type) == TRUE && 
		$this->session_content->setTool($tool) == TRUE) {
			$this->_redirect('/content/design');
		} else {
			$this->cancelTool();
		}
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
		$content_type = $this->getRequest()->getParam('type');
		$content_id = $this->getRequest()->getParam('content-id');
		$div_id = $this->getRequest()->getParam('div-id');
		$page_id = $this->getRequest()->getParam('page-id');

		$model_page_content = new Dlayer_Model_Page_Content();

		if($model_page_content->valid($content_id, 
		$this->session_dlayer->siteId(), $page_id, $div_id, $content_type) && 
		in_array($direction, array('up', 'down')) == TRUE) {
			$model_page_content->moveContentItem($direction, $content_type, 
				$content_id, $div_id, $page_id, $this->session_dlayer->siteId());
		}

		$this->_redirect('/content/design/');
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
				if($this->session_content->setTool($tool) == TRUE) {
					$reset = $this->getRequest()->getParam('reset');
					if($reset != NULL && $reset == 1) {
						$this->session_content->clearContentId();
					}
					$this->_redirect('/content/design');
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
	* The cancel tool clears all the currently set content template vars, the
	* user is returned to the manager after the session is cleared
	*
	* @return void
	*/
	private function cancelTool()
	{
		$this->session_content->clearAll();
		$this->_redirect('/content/design');
	}
}