<?php
/**
* The design controller is the root of the image library, this is where the 
* user manages the images in their library
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Image_DesignController extends Zend_Controller_Action
{
	/**
	* Type hinting for action helpers, hints the property to the code
	* hinting class which exists in the library
	*
	* @var Dlayer_Action_CodeHinting
	*/
	protected $_helper;

	private $session_dlayer;
	private $session_image;

	private $designer_image_library;

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
		$this->session_image = new Dlayer_Session_Image();

		// Include js and css files in layout
		$this->layout = Zend_Layout::getMvcInstance();
		$this->layout->assign('js_include', array('scripts/dlayer.js'));
		$this->layout->assign('css_include', 
			array(
				'css/dlayer.css', 
				'css/designer-970.css',
			)
		);

		// Set category and sub category values if currently NULL
		$category_id = $this->session_image->imageId(
			Dlayer_Session_Image::CATEGORY);
		$sub_category_id = $this->session_image->imageId(
			Dlayer_Session_Image::SUB_CATEGORY);

		if($category_id == NULL || $sub_category_id == NULL) {
			$model_image_categories = new Dlayer_Model_Image_Categories();

			$default_category = $model_image_categories->category(
				$this->session_dlayer->site_id, 0);
			$default_sub_category = $model_image_categories->subCategory(
				$this->session_dlayer->site_id, $default_category['id'], 0);

			$this->session_image->setEditMode();
			$this->session_image->setImageId($default_category['id'], 
				Dlayer_Session_Image::CATEGORY);
			$this->session_image->setImageId($default_sub_category['id'], 
				Dlayer_Session_Image::SUB_CATEGORY);
		}

		$this->designer();
	}

	/**
	* Instantiate the designer class
	* 
	* @return void
	*/
	private function designer() 
	{
		$sort_ordering = $this->session_image->sortOrder();

		$this->designer_image_library = new Dlayer_Designer_ImageLibrary(
			$this->session_dlayer->siteId(), 
			$this->session_image->imageId(Dlayer_Session_Image::CATEGORY), 
			$this->session_image->imageId(Dlayer_Session_Image::SUB_CATEGORY), 
			$sort_ordering['sort'], $sort_ordering['order'], 
			$this->session_image->imageId(Dlayer_Session_Image::IMAGE), 
			$this->session_image->imageId(Dlayer_Session_Image::VERSION));
	}

	/**
	* Base action for the designer controller, loads in the html for the
	* menu, ribbon, modes, toolbar and template
	*
	* @return void
	*/
	public function indexAction()
	{        
		$this->navBar('/image/index/index');
		$this->view->dlayer_toolbar = $this->dlayerToolbar();
		$this->view->dlayer_library = $this->dlayerLibrary();
		$this->view->dlayer_ribbon = $this->dlayerRibbon();

		$this->view->module = $this->getRequest()->getModuleName();
		$this->view->tool = $this->session_image->tool();
		$this->view->filter_form = $this->designer_image_library->filterForm();

		$this->view->image_id = $this->session_image->imageId();
				
		$this->layout->assign('title', 'Dlayer.com - Image library');
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
			array('uri'=>'/image/index/index', 
				'name'=>'Image library', 'title'=>'Media management'), 
			array('uri'=>'/dlayer/settings/index', 
				'name'=>'Settings', 'title'=>'Settings'), 
			array('uri'=>'http://www.dlayer.com/docs/', 
				'name'=>'Dlayer Docs', 'title'=>'Read the Docs for Dlayer')
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

		$this->view->tools = $model_module->tools(
			$this->getRequest()->getModuleName());
		$this->view->tool = $this->session_image->tool();
		$this->view->image_id = $this->session_image->imageId();

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
		$tool = $this->session_image->tool();

		if($tool != FALSE) {
			$html = $this->dlayerRibbonHtml($tool['tool'], $tool['tab']);
		} else {
			$ribbon = new Dlayer_Ribbon();

			$image_id = $this->session_image->imageId(Dlayer_Session_Image::IMAGE);

			if($image_id != NULL) {
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

		if($this->session_image->editMode() == 1) {
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

				$this->session_image->setRibbonTab($tab);

				$edit_mode = FALSE;

				if($this->session_image->editMode() == 1) {
					$edit_mode = TRUE;
				}

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
	* Generate the html for the library, list of thumbnails for the selected 
	* category and subcategory or if an image is selected the detail page 
	* for the image
	*
	* @return string
	*/
	private function dlayerLibrary()
	{
		if($this->session_image->imageId() == NULL) {
			return $this->dlayerLibraryThumbnails();
		} else {
			return $this->dlayerLibraryDetail();
		}
	}

	/**
	* Display thumbnails
	*/
	private function dlayerLibraryThumbnails() 
	{
		$per_page = Dlayer_Config::IMAGE_LIBRARY_THUMB_PER_PAGE;
		$start = Dlayer_Helper::getInteger('start', 0);

		$sort_order = $this->session_image->sortOrder();
		$images = $this->designer_image_library->images(
			$per_page, $start);

		$this->view->sort = $sort_order['sort'];
		$this->view->sort_order = $sort_order['order'];
		$this->view->images = $images['results'];
		$this->view->title = $this->designer_image_library->titleData();

		// Pagination params
		$this->view->images_count = $images['count'];
		$this->view->per_page = $per_page;
		$this->view->start = $start;

		return $this->view->render("design/library.phtml");
	}

	/**
	* Display detail
	*/
	private function dlayerLibraryDetail() 
	{
		$detail = $this->designer_image_library->detail();        
		$versions = $this->designer_image_library->versions();
		$usage = $this->designer_image_library->usage();

		// Unable to correctly fetch data, clear all session data and return 
		// the user to the library
		if($detail == FALSE || $versions == FALSE) {
			$this->session_image->clearAll();
			$this->_redirect('/image');
		}

		$this->view->detail = $detail;
		$this->view->versions = $versions;
		$this->view->usage = $usage;
		$this->view->image_id = $this->session_image->imageId();
		$this->view->version_id = $this->session_image->imageId(
			Dlayer_Session_Image::VERSION);

		return $this->view->render("design/detail.phtml");
	}

	/**
	* Set the selected image and versionn, after setting the properties the 
	* user is sent to the detyail page for an image
	*
	* @return void
	*/
	public function setSelectedImageAction()
	{
		$this->_helper->disableLayout(FALSE);

		$image_id = $this->getRequest()->getParam('image');
		$version_id = $this->getRequest()->getParam('version');

		if($this->session_image->setImageId($image_id) == TRUE && 
			$this->session_image->setImageId($version_id, 
				Dlayer_Session_Image::VERSION) == TRUE) {
				$this->session_image->clearTool();
				$this->_redirect('/image/design');            
		} else {
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
		$edit = $this->getRequest()->getParam('edit', 0);

		$this->session_image->setEditMode();

		if($tool != NULL && strlen($tool) > 0) {
			if($tool != 'cancel') {
				if($this->session_image->setTool($tool) == TRUE) {                    
					if($edit == 1) {
						$this->session_image->setEditMode(1);
					}
					$this->_redirect('/image/design');
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
		$this->session_image->clearAll();
		$this->_redirect('/image/design');
	}

	/**
	* Set the filter
	* 
	* @todo Need to chjeck that the submitted values are valid values
	* @return void
	*/
	public function filterAction() 
	{
		if(array_key_exists('category_filter', $_POST) == TRUE && 
		array_key_exists('sub_category_filter', $_POST) == TRUE) {
			$this->session_image->setImageId($_POST['category_filter'], 
				Dlayer_Session_Image::CATEGORY);
			$this->session_image->setImageId($_POST['sub_category_filter'], 
				Dlayer_Session_Image::SUB_CATEGORY);

			$this->session_image->setEditMode();
		}

		$this->_redirect('/image/design');
	}

	/**
	* Set the sort options, sets the values in the session and them returns the 
	* user to the designer
	* 
	* @return void
	*/
	public function setSortAction() 
	{
		$sort = $this->getRequest()->getParam('sort');
		$order = $this->getRequest()->getParam('order');

		$sort_order = $this->session_image->sortOrder();

		// User only needs to set one param at a time so we pull the current 
		// values from the session if noi values are submitted for ether sort 
		// or order
		if($sort == NULL) {
			$sort = $sort_order['sort'];
		}
		if($order == NULL) {
			$order = $sort_order['order'];
		}

		$this->session_image->setSort($sort, $order);

		$this->_redirect('/image/design/index');
	}
}