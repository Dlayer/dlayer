<?php
/**
* The design controller is the root of the template designer, this is where
* the user builds their templates working on a visually accurate version of the
* template.
*
* The designer has a tool bar to the right that shows all the tools for the
* selected div and a ribbon at the top that updates based on the selected tool
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: DesignController.php 1842 2014-05-19 14:59:09Z Dean.Blackborough $
*/
class Template_DesignController extends Zend_Controller_Action
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

		$this->_helper->validateTemplateId();

		$this->session_dlayer = new Dlayer_Session();
		$this->session_template = new Dlayer_Session_Template();

		// Set the js and css files
		$this->layout = Zend_Layout::getMvcInstance();
		$this->layout->assign('js_include', array('scripts/dlayer.js'));
		$this->layout->assign('css_include', array('styles/ribbon.css',
			'styles/ribbon/template.css', 'styles/designer.css',
			'styles/designer/template.css'));
	}

	/**
	* Fetch the content block metrics, these are displayed in the designer view 
	* when the user is working with a content block
	* 
	* @return array Contains the height, width and border dimensions for the 
	* 				content block
	*/
	private function contentBlockMetrics() 
	{
		$metrics = array('id'=>0, 'width'=>0, 'height'=>'0', 'fixed'=>FALSE, 
			'borders'=>array('top'=>0, 'right'=>0, 'left'=>0, 'bottom'=>0));

		if($this->session_template->divId() != NULL && 
		$this->session_template->tool() != FALSE) {
			$model_template_div = new Dlayer_Model_Template_Div();
			$model_template_div_borders = 
			new Dlayer_Model_Template_Div_Border();

			$site_id = $this->session_dlayer->siteId();
			$div_id = $this->session_template->divId();
			$template_id = $this->session_template->templateId();

			$metrics['id'] = $div_id;
			$metrics['width'] = $model_template_div->width($site_id, 
				$div_id);

			$height = $model_template_div->height($site_id, $div_id);

			$display_height = '';

			if($height['fixed'] == FALSE) {
				$display_height = 'Dynamic (display): ';
			} else {
				$display_height = 'Fixed: ';
				$metrics['fixed'] = TRUE;
			}

			$display_height .= $height['height'] . ' pixels';

			$metrics['height'] = $display_height;

			$borders = $model_template_div_borders->existingBorders($site_id, 
				$template_id, $div_id);

			if($borders != FALSE) {
				$metrics['borders'] = $borders;
			}
		}

		return $metrics;
	}

	/**
	* Base action for the designer controller, loads in the html for the
	* menu, ribbon, modes, toolbar and template
	*
	* @return void
	*/
	public function indexAction()
	{
		$this->dlayerMenu('/template/index/index');
		$this->view->dlayer_ribbon = $this->dlayerRibbon();
		$this->view->dlayer_toolbar = $this->dlayerToolbar();
		$this->view->dlayer_template = $this->dlayerTemplate();

		$this->view->module = $this->getRequest()->getModuleName();
		$this->view->div_id = $this->session_template->divId();
		$this->view->tool = $this->session_template->tool();
		$this->view->content_block_metrics = $this->contentBlockMetrics();

		$this->layout->assign('css_include', 
			array('css/dlayer.css', 'css/designers.css'));
		$this->layout->assign('title', 'Dlayer.com - Template designer');
	}

	/**
	* Set the tool, validates that the requested tool is valid and then sets
	* the params in the template session.
	*
	* After a tool has been set the view is refreshed, ribbon and designer will
	* be updated based on the selected tool
	*
	* Unlike all the other tools the cancel tool clears all template session
	* values before refreshing the view
	* 
	* @todo Need to clean up the logic below, shoudln't be five levels, find 
	*		another way to solve the problem
	*
	* @return void
	*/
	public function setToolAction()
	{
		$this->_helper->disableLayout(FALSE);

		$tool = $this->getRequest()->getParam('tool');

		if($tool != NULL && strlen($tool) > 0) {
			if($tool != 'cancel') {
				if($this->session_template->setTool($tool) == TRUE) {                	
					/**
					* Check to see if the tool is a destructive tool and 
					* whether or not the request should be cancelled, active 
					* page with active content in template div id
					*/                	
					$selected_tool = $this->session_template->tool();
					if($selected_tool['destructive'] == 0) {
						$this->_redirect('/template/design');
					} else {
						$model_pages = new Dlayer_Model_Page();
						if($model_pages->pageCreatedUsingTemplate(
						$this->session_template->templateId(), 
						$this->session_dlayer->siteId()) == TRUE) {
							if($model_pages->templateDivHasContent(
							$this->session_template->divId(), 
							$this->session_dlayer->siteId(), 
							$this->session_template->templateId()) == FALSE) {
								$this->_redirect('/template/design');
							} else {
								$this->cancelTool();
							}							
						} else {
							$this->_redirect('/template/design');
						}
					}
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
	* The cancel tool clears all the currently set session template vars, the
	* user is returned to the designer after the session is cleared
	*
	* @return void
	*/
	private function cancelTool()
	{
		$this->session_template->clearAll();
		$this->_redirect('/template/design');
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

		/**
		* If the template has been used to create a page and the specific 
		* template div id has a form of content (form, widget, content) on 
		* the page then we disable some tools. 
		* 
		* Until I add the logic that attempts to handle moving content 
		* references changes that appear destructive are disabled.
		*/
		$has_content = FALSE;

		$div_id = $this->session_template->divId();
		$template_id = $this->session_template->templateId();
		$site_id = $this->session_dlayer->siteId();

		if($div_id != NULL) {
			$model_pages = new Dlayer_Model_Page();

			if($model_pages->pageCreatedUsingTemplate($template_id, 
			$site_id) == TRUE) {        		
				if($model_pages->templateDivHasContent($div_id, $site_id, 
				$template_id) == TRUE) {
					$has_content = TRUE;
				}
			}
		}

		$this->view->div_id = $div_id;
		$this->view->tools = $model_module->tools(
			$this->getRequest()->getModuleName());
		$this->view->tool = $this->session_template->tool();
		$this->view->has_content = $has_content;

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
		$tool = $this->session_template->tool();

		if($tool != FALSE) {
			$html = $this->dlayerRibbonHtml($tool['tool'], $tool['tab']);
		} else {
			$ribbon = new Dlayer_Ribbon();

			if($this->session_template->divId() != NULL) {
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

				$this->session_template->setRibbonTab($tab);

				$this->view->color_picker_data = $this->colorPickerData();
				$this->view->div_id = $this->session_template->divId();
				$this->view->data = $ribbon_tab->viewData($module, $tool,
					$tab, $multi_use);
				$this->view->multi_use = $multi_use;

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
	* Generate the html for the template, this will be a visually accurate
	* version of the template.
	*
	* The template data is pulled from the database and then passed to the view,
	* multiple view helpers are called in the view to generate the final html
	*
	* Templates are typically very simple, they cannot have content assigned
	* to them, just widgets and forms.
	*
	* In the final version of Dlayer, public versions of web sites won't be
	* generating the html in real-time, a version will be exported from
	* Dlayer and that will be used for the public site. The goal being that
	* the entire system is transparent to both the end users and Dlayer users
	*
	* @return string
	*/
	private function dlayerTemplate()
	{
		$designer_template = new Dlayer_Designer_Template(
			$this->session_dlayer->siteId(), $this->session_template->templateId(),
			$this->session_template->divId());

		$this->view->template = $designer_template->template();
		$this->view->styles = $designer_template->styles();
		$this->view->div_id = $this->session_template->divId();

		return $this->view->render("design/template.phtml");
	}

	/**
	* Sets the selected template div and refreshes the view, the tool bar to
	* the right of the designer will show the tools that are available based
	* on the selected element.
	*
	* The validity of the template div is checked, if for some reason the
	* div is not valid the cancel tool is called
	*
	* @return void
	*/
	public function setSelectedDivAction()
	{
		$this->_helper->disableLayout(FALSE);

		$id = $this->getRequest()->getParam('selected');

		if($this->session_template->setDivId($id) == TRUE) {
			$this->_redirect('/template/design');
		} else {
			$this->cancelTool();
		}
	}
	
	/**
	* Switch the div between fixed height and dynamic heeight, this is handled 
	* by setting a height value or clearing the height value
	* 
	* @return void	
	*/
	public function switchHeightSettingAction() 
	{
		$this->_helper->disableLayout(FALSE);
		$id = $this->getParam('id');
		
		$model_template = new Dlayer_Model_View_Template();
		if($model_template->divExists($id, 
			$this->session_template->templateId()) == TRUE) {
				
			$site_id = $this->session_dlayer->siteId();
            
            $model_div = new Dlayer_Model_Template_Div();
            $height = $model_div->height($site_id, $id);
            
            // Set height by passing in opposite to fixed
            $model_div->setHeight($site_id, $id, $height['height'], 
                !$height['fixed']);                
        }
        
        $this->_redirect('/template/design');
	}
}