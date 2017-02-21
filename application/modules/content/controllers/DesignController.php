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
     * @var array Buttons to display on the control bar
     */
    private $control_bar;

    /**
     * @var array Buttons for the siblings section of control bar
     */
    private $control_bar_siblings;

    /**
     * @var array Buttons for the tools section of control bar
     */
    private $control_bar_tools = array(
        'layout' => array(),
        'create' => array(),
        'import' => array()
    );

    /**
     * @var array Nav bar items
     */
    private $nav_bar_items = array(
        array(
            'uri' => '/dlayer/index/home',
            'name' => 'Dlayer Demo',
            'title' => 'Dlayer.com: Web development simplified'
        ),
        array('uri' => '/content/index/index', 'name' => 'Content Manager', 'title' => 'Content Manager'),
        array('uri' => 'http://www.dlayer.com/docs/', 'name' => 'Docs', 'title' => 'Read the Docs for Dlayer'),
    );

    /**
     * Execute the setup methods for the controller and set the properties
     *
     * @return void
     */
    public function init()
    {
        $this->_helper->validateModule();

        $this->_helper->authenticate();

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
        $this->_helper->setLayout('content-manager');

        /**
         * Auto select the page if not selected, better UX as there is only one page per designer
         */
        if ($this->session_content->pageSelected() === null) {
            $this->redirect('/content/design/set-page-selected');
        }

        $this->controlBar();

        $this->view->page = $this->page();
        $this->view->ribbon = $this->ribbon();

        $this->view->module = $this->getRequest()->getModuleName();
        $this->view->page_selected = $this->session_content->pageSelected();
        $this->view->row_id = $this->session_content->rowId();
        $this->view->content_id = $this->session_content->contentId();
        $this->view->tool = $this->session_designer->tool('content');

        $this->_helper->setLayoutProperties(
            $this->nav_bar_items,
            '/content/index/index',
            array(
                'css/dlayer.css',
                'css/designer-shared.css',
                'css/designer-1170.css'
            ),
            array(
                'scripts/dlayer.js',
                'scripts/designer.js',
                'scripts/content-manager.js',
                'scripts/preview.js',
                'scripts/preview-content-manager.js'
            ),
            'Dlayer.com - Content Manager', '/content/design/preview');
    }

    /**
     * Generate the buttons for the control bar
     */
    private function controlBar()
    {
        $model_page = new Dlayer_Model_Page();

        $column_id = $this->session_content->columnId();
        $row_id = $this->session_content->rowId();
        $content_id = $this->session_content->contentId();
        $parent_column_id = $model_page->parentColumnId($row_id, $content_id);
        $parent_row_id = $model_page->parentRowId($column_id);

        $siblings = false;
        if ($content_id !== null) {
            $siblings = $model_page->contentSiblings($this->site_id, $this->page_id, $column_id, $content_id);
        }

        $this->controlBarBase($column_id, $parent_row_id, $parent_column_id, $row_id, $content_id);

        $this->contractBarSIblings($siblings);

        $this->controlBarTools($this->session_content->pageSelected(), $column_id, $row_id, $content_id);

        $layout = Zend_Layout::getMvcInstance();
        $layout->assign('control_bar', $this->control_bar);
        $layout->assign('control_bar_siblings', $this->control_bar_siblings);
        $layout->assign('control_bar_tools', $this->control_bar_tools);
    }

    /**
     * Preview for design
     *
     * @return void
     */
    public function previewAction()
    {
        $this->_helper->setLayout('preview');

        $this->view->dlayer_page = $this->pagePreview();

        $layout = Zend_Layout::getMvcInstance();
        $layout->assign('css_include', array('css/dlayer.css'));
        $layout->assign('js_include', array());
        $layout->assign('title', 'Dlayer.com - Design preview');
    }

    /**
     * Generate the HTML for the ribbon, there are two states, tool selected and then the default view, if a tool is
     * selected we let the ribbon load the relevant HTML
     *
     * @return string
     */
    private function ribbon()
    {
        $tool = $this->session_designer->tool('content');

        if ($tool !== false) {
            $html = $this->dlayerRibbonHtml($tool['tool'], $tool['tab'], $tool['sub_tool']);
        } else {
            $html = $this->view->render("design/ribbon/default.phtml");
        }

        $this->view->html = $html;

        return $this->view->render("design/ribbon.phtml");
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
    private function dlayerRibbonHtml($tool, $tab, $sub_tool = null)
    {
        if ($this->session_content->contentId() != null) {
            $edit_mode = true;
        } else {
            $edit_mode = false;
        }

        $model_tool = new Dlayer_Model_Tool();
        $tabs = $model_tool->toolTabs('content', $tool, $edit_mode);

        if ($tabs !== false) {
            $this->view->selected_tool = $tool;
            $this->view->selected_tab = $tab;
            $this->view->selected_sub_tool = $sub_tool;
            $this->view->tabs = $tabs;
            $this->view->module = 'content';
            $html = $this->view->render('design/ribbon/ribbon-html.phtml');
        } else {
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

        $this->controlBar();

        $module = $this->getRequest()->getModuleName();
        $tool = Dlayer_Helper::getParamAsString('tool');
        $sub_tool = Dlayer_Helper::getParamAsString('sub_tool');
        $tab = Dlayer_Helper::getParamAsString('tab');

        if ($tool !== null && $tab !== null) {
            $model_tool = new Dlayer_Model_Tool();
            $model_page = new Dlayer_Model_Page();

            $exists = $model_tool->tabExists($this->getRequest()->getModuleName(), $tool, $tab);

            if ($exists === true) {
                if ($this->session_content->contentId() !== null) {
                    $edit_mode = true;
                } else {
                    $edit_mode = false;
                }

                $multi_use = $model_tool->multiUse($module, $tool, $tab);
                $this->session_designer->setToolTab('content', $tab, $sub_tool);

                $this->view->color_picker_data = $this->colorPickerData();
                $this->view->data = $this->toolTabViewData($tool, $tab, $multi_use, $edit_mode);

                $column_id = $this->session_content->columnId();
                $column_contains_content = $model_page->columnContainsContent($column_id);

                if ($column_contains_content === true) {
                    $this->view->column_content = $model_page->columnContent($this->site_id, $this->page_id, $column_id);
                }

                $this->view->content_id = $this->session_content->contentId();
                $this->view->column_contains_content = $column_contains_content;
                $this->view->column_contains_rows = $model_page->columnContainsRows($column_id);
                $this->view->row_contains_columns = $model_page->rowContainsColumns($this->session_content->rowId());

                if ($sub_tool === null) {
                    $this->view->addScriptPath(DLAYER_LIBRARY_PATH . "/Dlayer/DesignerTool/ContentManager/" .
                        $tool . "/scripts/");
                } else {
                    $this->view->addScriptPath(DLAYER_LIBRARY_PATH . "/Dlayer/DesignerTool/ContentManager/" .
                        $tool . "/SubTool/" . $sub_tool . "/scripts/");
                }

                $html = $this->view->render($tab . '.phtml');
            } else {
                $html = $this->view->render("design/ribbon/default.phtml");
            }
        } else {
            $html = $this->view->render("design/ribbon/default.phtml");
        }

        $this->view->html = $html;
    }

    /**
     * Fetch the view data for the tool tabs
     *
     * @param string $tool
     * @param string $tab
     * @param integer $multi_use
     * @param boolean $edit_mode
     * @return string
     */
    private function toolTabViewData($tool, $tab, $multi_use, $edit_mode)
    {
        $handler = new Dlayer_Ribbon_Handler_Content();

        return $handler->viewData($this->site_id, $this->session_content->pageId(),
            $tool, $tab, $multi_use, $edit_mode, $this->session_content->rowId(),
            $this->session_content->columnId(), $this->session_content->contentId());
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
    private function page()
    {
        $designer_page = new Dlayer_Designer_Page($this->site_id, $this->page_id);

        $this->view->rows = $designer_page->rows();
        $this->view->columns = $designer_page->columns();
        $this->view->responsive_columns_widths = $designer_page->responsiveColumnWidths();
        $this->view->content = $designer_page->content();

        $this->view->page_id = $this->page_id;
        $this->view->page_selected = $this->session_content->pageSelected();
        $this->view->column_id = $this->session_content->columnId();
        $this->view->row_id = $this->session_content->rowId();
        $this->view->content_id = $this->session_content->contentId();

        $this->view->styling_content_items = $designer_page->contentItemStyles();
        $this->view->styling_columns = $designer_page->columnStyles();
        $this->view->styling_rows = $designer_page->rowStyles();
        $this->view->styling_page = $designer_page->pageStyles();

        return $this->view->render("design/page.phtml");
    }

    /**
     * Generate the preview for the page being created/edited
     *
     * @return string
     */
    private function pagePreview()
    {
        $designer_page = new Dlayer_Designer_Page($this->site_id, $this->page_id);

        $this->view->page_id = $this->page_id;

        $this->view->rows = $designer_page->rows();
        $this->view->columns = $designer_page->columns();
        $this->view->responsive_columns_widths = $designer_page->responsiveColumnWidths();
        $this->view->content = $designer_page->content();

        $this->view->styling_content_items = $designer_page->contentItemStyles();
        $this->view->styling_columns = $designer_page->columnStyles();
        $this->view->styling_rows = $designer_page->rowStyles();
        $this->view->styling_page = $designer_page->pageStyles();

        $control_bar_buttons = array(
            array(
                'uri' => '/content/design/index',
                'class' => 'primary',
                'name' => 'Return to Content Manager'
            )
        );

        $this->_helper->populateControlBar($control_bar_buttons, array());

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
        $this->_helper->disableLayout(false);

        $id = $this->getRequest()->getParam('id');
        if ($this->session_designer->setTool('content', 'row') === true) {
            $this->session_content->setRowId($id);

            if ($this->getRequest()->getParam('column') !== null) {
                $this->session_content->setColumnId($this->getRequest()->getParam('column'));
            }
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
        $this->_helper->disableLayout(false);

        $id = $this->getRequest()->getParam('id');

        if ($this->session_designer->setTool('content', 'column') === true) {
            $this->session_content->setColumnId($id);

            if ($this->getRequest()->getParam('row') !== null) {
                $this->session_content->setRowId($this->getRequest()->getParam('row'));
            }
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
        $this->_helper->disableLayout(false);

        if ($this->session_designer->setTool('content', 'Page') === true) {
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
        $this->_helper->disableLayout(false);

        $id = Dlayer_Helper::getParamAsInteger('id');
        $tool = Dlayer_Helper::getParamAsString('tool');
        $content_type = Dlayer_Helper::getParamAsString('content-type');

        if ($this->session_content->setContentId($id, $content_type) === true &&
            $this->session_designer->setTool('content', $tool) === true
        ) {
            $this->redirect('/content/design');
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
        $this->_helper->disableLayout(false);

        $tool = $this->getRequest()->getParam('tool');

        if ($tool !== null && strlen($tool) > 0) {
            if ($tool !== 'Cancel') {
                if ($this->session_designer->setTool('content', $tool) === true) {
                    $reset = $this->getRequest()->getParam('reset');

                    if ($reset !== null && intval($reset) === 1) {
                        $this->session_content->clearContentId();
                        $this->session_designer->clearAllImagePicker();
                    }

                    $this->redirect('/content/design');
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
     * We auto select the page to ease selections for user, should not always have to choose a page if there is only one
     *
     * @return void
     */
    private function cancelTool()
    {
        $this->session_content->clearAll();
        $this->session_designer->clearAllImagePicker();
        $this->session_designer->clearAllTool('content');

        $this->redirect('/content/design/set-page-selected');
    }

    /**
     * Move the row in the desired direction
     *
     * @return void User redirected back to designer regardless of outcome
     */
    public function moveRowAction()
    {
        $this->_helper->disableLayout(false);

        $direction = Dlayer_Helper::getParamAsString('direction');
        $row_id = Dlayer_Helper::getParamAsInteger('id');
        $page_id = $this->session_content->pageId();
        $column_id = $this->session_content->columnId();

        $model_page_content = new Dlayer_Model_Page();
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
        $this->_helper->disableLayout(false);

        $direction = Dlayer_Helper::getParamAsString('direction');
        $column_id = Dlayer_Helper::getParamAsInteger('id');
        $page_id = $this->session_content->pageId();
        $row_id = $this->session_content->rowId();

        $model_page_content = new Dlayer_Model_Page();
        $model_page_content->moveColumn($this->site_id, $page_id, $row_id, $column_id, $direction);

        $this->redirect('/content/design');
    }

    /**
     * Move the selected content item, before passing the request to the model
     * we check to ensure that the item can be moved in the requested direction
     * and also that the content item is valid for the requested content type and
     * page div
     *
     * @return void
     */
    public function moveContentAction()
    {
        $this->_helper->disableLayout(false);

        $direction = $this->getRequest()->getParam('direction');
        $content_id = $this->getRequest()->getParam('id');
        $page_id = $this->session_content->pageId();
        $column_id = $this->session_content->columnId();

        $model_page_content = new Dlayer_Model_Page();
        $model_page_content->moveContent($this->site_id, $page_id, $column_id, $content_id, $direction);

        $this->redirect('/content/design/');
    }

    /**
     * Core navigation controls for the control bar
     *
     * @param integer $column_id
     * @param integer $parent_row_id
     * @param integer $parent_column_id
     * @param integer $row_id
     * @param integer $content_id
     *
     * @return void
     */
    private function controlBarBase($column_id, $parent_row_id, $parent_column_id, $row_id, $content_id)
    {
        $this->control_bar[] = array(
            'name' => 'Cancel',
            'class' => 'btn-danger',
            'uri' => '/content/design/set-tool/Cancel/reset/1'
        );

        if ($column_id !== null) {
            if ($content_id !== null) {
                $this->control_bar[] = array(
                    'name' => 'Select parent row',
                    'class' => 'btn-default',
                    'uri' => '/content/design/set-selected-row/id/' . $row_id . '/column/' . $parent_column_id
                );
            } else {
                $this->control_bar[] = array(
                    'name' => 'Select parent row',
                    'class' => 'btn-default',
                    'uri' => '/content/design/set-selected-row/id/' . $row_id . '/column/' . $parent_column_id
                );
            }
        }

        if ($row_id !== null && $parent_column_id !== 0) {
            if ($content_id !== null) {
                $this->control_bar[] = array(
                    'name' => 'Select parent column',
                    'class' => 'btn-default',
                    'uri' => '/content/design/set-selected-column/id/' . $column_id . '/row/' . $row_id
                );
            } else {
                $this->control_bar[] = array(
                    'name' => 'Select parent column',
                    'class' => 'btn-default',
                    'uri' => '/content/design/set-selected-column/id/' . $parent_column_id . '/row/' . $parent_row_id
                );
            }
        }
    }

    /**
     * Control bar content item sibling movement controls
     *
     * @param $siblings
     * @return void
     */
    private function contractBarSiblings($siblings)
    {
        if ($siblings !== false && $siblings['previous'] !== false) {
            $this->control_bar_siblings[] = array(
                'name' => 'Previous',
                'uri' => '/content/design/set-selected-content/id/' . $siblings['previous'] . '/tool/' . $siblings['previous_data']['tool'] . '/content-type/' . $siblings['previous_data']['content_type'],
            );
        }

        if ($siblings !== false && $siblings['next'] !== false) {
            $this->control_bar_siblings[] = array(
                'name' => 'Next',
                'uri' => '/content/design/set-selected-content/id/' . $siblings['next'] . '/tool/' . $siblings['next_data']['tool'] . '/content-type/' . $siblings['next_data']['content_type'],
            );
        }
    }

    /**
     * Control bar tool bar buttons
     *
     * @return void
     */
    private function controlBarTools($page_selected, $column_id, $row_id, $content_id)
    {
        $model_tool = new Dlayer_Model_Tool();
        $model_page = new Dlayer_Model_Page();

        $column_contains_content = $model_page->columnContainsContent($column_id);
        $column_contains_rows = $model_page->columnContainsRows($column_id);

        $tools = $model_tool->tools($this->getRequest()->getModuleName());
        $current_tool = $this->session_designer->tool('content');

        foreach ($tools as $group_id => $group) {
            foreach ($group as $tool) {

                $show = false;
                $group = null;

                switch ($tool['group_id']) {
                    case 3: // Structure tools
                        $group = 'layout';

                        // Show the add row tool, when the page is selected
                        if ($tool['model'] === 'AddRow' && $page_selected === true && $row_id === null
                            && $column_id === 0 && $column_contains_content === false
                        ) {
                            $show = true;
                        }

                        // Show the add row tool when column selected
                        if ($tool['model'] === 'AddRow' && $page_selected === true && $row_id !== null
                            && ($column_id !== 0 || $column_id !== null) && $column_contains_content === false
                        ) {
                            $show = true;
                        }

                        // Hide add row tool when row selected
                        if ($tool['model'] === 'AddRow' && $current_tool !== false &&
                            ($current_tool['tool'] === 'Row' || $current_tool['tool'] === 'AddColumn') &&
                            $column_contains_content === false
                        ) {
                            $show = false;
                        }

                        // Show the column tool
                        if ($tool['model'] === 'AddColumn' && $page_selected === true && $column_id !== null
                            && $row_id !== null && $content_id === null
                        ) {
                            $show = true;
                        }

                        // Hide column tool
                        if ($tool['model'] === 'AddColumn' && $current_tool !== false && $current_tool['tool'] === 'Column') {
                            $show = false;
                        }
                        break;

                    case 4: // Content tools
                        $group = 'create';

                        if ($page_selected === true && $row_id !== null &&
                            ($column_id !== null && $column_id !== 0) &&
                            $column_contains_rows === false
                        ) {
                            $show = true;
                        }
                        break;

                    case 5: // Import tools
                        $group = 'import';

                        if ($page_selected === true && $row_id !== null &&
                            ($column_id !== null && $column_id !== 0 &&
                                $column_contains_rows === false)
                        ) {
                            $show = true;
                        }
                        break;

                    default:
                        break;
                }

                $reset = null;
                if ($content_id !== null) {
                    $reset = '/reset/1';
                }

                if ($show === true) {
                    $this->control_bar_tools[$group][] = array(
                        'name' => $tool['name'],
                        'uri' => '/content/design/set-tool/tool/' . $tool['model'] . $reset
                    );
                }
            }
        }
    }
}
