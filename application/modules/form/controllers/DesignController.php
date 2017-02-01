<?php

/**
 * The design controller is the UI for the for Form Builder, all processing is handled by the process controller,
 * the Form Builder attempts to show a live, responsive, visually accurate versions of the form being built
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Form_DesignController extends Zend_Controller_Action
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
     * @var integer Id for the currently selected form
     */
    protected $form_id;

    /**
     * @var Dlayer_Session_Form Form Builder session, manages state of designer environment
     */
    private $session;

    /**
     * @var Dlayer_Session_Designer Designer session, manages state of shared designer tools,
     * the colour picker and image picker
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
        'settings' => array(),
        'preset' => array(),
        'standard' => array()
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
        array('uri' => '/form/index/index', 'name' => 'Form Builder', 'title' => 'Form Builder'),
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

        $this->session = new Dlayer_Session_Form();
        $this->form_id = $this->session->formId();

        $this->session_designer = new Dlayer_Session_Designer();
    }

    /**
     * Base action for the design controller, fetches the html/data for the tool bar ribbon and form page
     *
     * @return void
     */
    public function indexAction()
    {
        $this->_helper->setLayout('form-builder');

        $this->controlBar();

        $this->view->form = $this->form();
        $this->view->ribbon = $this->ribbon();

        $this->view->module = $this->getRequest()->getModuleName();

        $this->_helper->setLayoutProperties(
            $this->nav_bar_items,
            '/form/index/index',
            array(
                'css/dlayer.css',
                'css/designer-shared.css',
                'css/designer-1170.css'
            ),
            array(
                'scripts/dlayer.js',
                'scripts/designer.js',
                'scripts/form-builder.js',
                //'scripts/preview-form-builder.js'
            ),
            'Dlayer.com - Form Builder', '/form/design/preview');
    }

    /**
     * Base action for the design controller, fetches the html/data for the tool bar ribbon and form
     *
     * @return void
     */
    public function previewAction()
    {
        $this->_helper->setLayout('preview');

        $this->view->form = $this->formPreview();

        $layout = Zend_Layout::getMvcInstance();
        $layout->assign('css_include', array('css/dlayer.css'));
        $layout->assign('js_include', array());
        $layout->assign('title', 'Dlayer.com - Form preview');
    }

    /**
     * Generate the buttons for the control bar
     */
    private function controlBar()
    {
        $siblings = false;

        $this->controlBarBase();

        $this->contractBarSIblings($siblings);

        $this->controlBarTools($this->session->formId());

        $layout = Zend_Layout::getMvcInstance();
        $layout->assign('control_bar', $this->control_bar);
        $layout->assign('control_bar_siblings', $this->control_bar_siblings);
        $layout->assign('control_bar_tools', $this->control_bar_tools);
    }

    /**
     * Core navigation controls for the control bar
     *
     * @return void
     */
    private function controlBarBase()
    {
        $this->control_bar[] = array(
            'name' => 'Cancel',
            'class' => 'btn-danger',
            'uri' => '/form/design/set-tool/Cancel/reset/1'
        );
    }

    /**
     * Control bar siblings, allows selection of other fields
     *
     * @param $siblings
     * @return void
     */
    private function contractBarSiblings($siblings)
    {
        if ($siblings !== false) {
            // Loop through all fields, show a button for each in order
        }
    }

    /**
     * Control bar tool bar buttons
     *
     * @param integer $field_id Selected field
     *
     * @return void
     */
    private function controlBarTools($field_id)
    {
        $model_tool = new Dlayer_Model_Tool();

        $tools = $model_tool->tools($this->getRequest()->getModuleName());

        foreach ($tools as $tool_group) {
            foreach ($tool_group as $tool) {

                switch ($tool['group_id']) {
                    case 2:
                        $show = true;
                        $group = 'standard';
                        break;

                    default:
                        $show = false; // Don't include cancel tool
                        $group = null;
                        break;
                }

                $reset = null;
                if ($field_id !== null) {
                    $reset = '/reset/1';
                }

                if ($show === true) {
                    $this->control_bar_tools[$group][] = array(
                        'name' => $tool['name'],
                        'uri' => '/form/design/set-tool/tool/' . $tool['model'] . $reset
                    );
                }
            }
        }
    }

    /**
     * Generate the html for the form
     *
     * @return string
     */
    private function form()
    {
        $form = new Dlayer_Designer_Form($this->site_id, $this->form_id, true, $this->session->fieldId());

        $this->view->form = $form->form();
        $this->view->row_styling = $form->rowStyles();

        return $this->view->render("design/form.phtml");
    }

    /**
     * Generate the html for the preview of the form
     *
     * @return string
     */
    private function formPreview()
    {
        $form = new Dlayer_Designer_Form($this->site_id, $this->form_id);

        $this->view->form = $form->form();
        $this->view->row_styling = $form->rowStyles();

        return $this->view->render("design/preview.phtml");
    }

    /**
     * Generate the HTML for the ribbon, there are two states, tool selected and then the default view, if a tool is
     * selected we let the ribbon load the relevant HTML
     *
     * @return string
     */
    private function ribbon()
    {
        $tool = $this->session_designer->tool('form');

        if ($tool !== false) {
            $html = $this->ribbonHtml($tool['tool'], $tool['tab'], $tool['sub_tool']);
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
    private function ribbonHtml($tool, $tab, $sub_tool = null)
    {
        if ($this->session->fieldId() !== null) {
            $edit_mode = true;
        } else {
            $edit_mode = false;
        }

        $model_tool = new Dlayer_Model_Tool();
        $tabs = $model_tool->toolTabs('form', $tool, $edit_mode);

        if ($tabs !== false) {
            $this->view->selected_tool = $tool;
            $this->view->selected_tab = $tab;
            $this->view->selected_sub_tool = $sub_tool;
            $this->view->tabs = $tabs;
            $this->view->module = 'form';
            $html = $this->view->render('design/ribbon/ribbon-html.phtml');
        } else {
            $html = $this->view->render('design/ribbon/default.phtml');
        }

        return $html;
    }

    /**
     * Set the tool, validates that the requested tool is valid and then sets the params in the designer and
     * form session.
     *
     * After a tool has been set the view is refreshed, the ribbon will be updated based on the selected tool or item
     *
     * Unlike all the other tools the cancel tool clears all form and designer session values before refreshing the view
     *
     * @return void
     */
    public function setToolAction()
    {
        $this->_helper->disableLayout(false);

        $tool = $this->getRequest()->getParam('tool');

        if ($tool !== null && strlen($tool) > 0) {
            if ($tool !== 'Cancel') {
                if ($this->session_designer->setTool('form', $tool) === true) {
                    $reset = $this->getRequest()->getParam('reset');

                    if ($reset !== null && intval($reset) === 1) {
                        $this->session->clearFieldId();
                        $this->session_designer->clearAllImagePicker();
                    }

                    $this->redirect('/form/design');
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
     * The cancel tool clears all the currently set session vars, the user is returned to the Form Builder after
     * clearing all values
     *
     * @return void
     */
    private function cancelTool()
    {
        $this->session->clearAll();
        $this->session_designer->clearAllImagePicker();
        $this->session_designer->clearAllTool('form');

        $this->redirect('/form/design/index');
    }

    /**
     * Generate the html for the requested tool tab, called via Ajax. The tool and tab are checked to ensure they are
     * valid and active and then the data required to generate the tool tab is fetched and passed too the view
     *
     * @throws \Exception
     * @return string
     */
    public function ribbonTabHtmlAction()
    {
        $this->_helper->disableLayout();

        $module = $this->getRequest()->getModuleName();
        $tool = Dlayer_Helper::getParamAsString('tool');
        $sub_tool = Dlayer_Helper::getParamAsString('sub_tool');
        $tab = Dlayer_Helper::getParamAsString('tab');

        if ($tool !== null && $tab !== null) {
            $model_tool = new Dlayer_Model_Tool();

            $exists = $model_tool->tabExists($this->getRequest()->getModuleName(), $tool, $tab);

            if ($exists === true) {
                if ($this->session->fieldId() !== null) {
                    $edit_mode = true;
                } else {
                    $edit_mode = false;
                }

                $multi_use = $model_tool->multiUse($module, $tool, $tab);
                $this->session_designer->setToolTab('form', $tab, $sub_tool);

                $this->view->color_picker = $this->colorPicker();
                $this->view->data = $this->toolTabViewData($tool, $tab, $multi_use, $edit_mode);

                if ($sub_tool === null) {
                    $this->view->addScriptPath(DLAYER_LIBRARY_PATH . "/Dlayer/DesignerTool/FormBuilder/" .
                        $tool . "/scripts/");
                } else {
                    $this->view->addScriptPath(DLAYER_LIBRARY_PATH . "/Dlayer/DesignerTool/FormBuilder/" .
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
        $handler = new Dlayer_Ribbon_Handler_Form();

        return $handler->viewData(
            $this->site_id,
            $this->session->formId(),
            $tool,
            $tab,
            $multi_use,
            $edit_mode,
            $this->session->fieldId()
        );
    }

    /**
     * Set the id for the selected field
     *
     * @return void
     */
    public function setSelectedFieldAction()
    {
        $this->_helper->disableLayout(false);

        $id = Dlayer_Helper::getParamAsInteger('id');
        $tool = Dlayer_Helper::getParamAsString('tool');

        if ($this->session->setFieldId($id) === true &&
            $this->session_designer->setTool('form', $tool) === true
        ) {
            $this->redirect('/form/design');
        } else {
            $this->cancelTool();
        }
    }

    /**
     * Fetch the data for the color picker
     *
     * @return array
     */
    private function colorPicker()
    {
        $model_palettes = new Dlayer_Model_Palette();

        return array(
            'palettes' => $model_palettes->palettes($this->site_id),
            'history' => $model_palettes->lastNColors($this->site_id),
        );
    }
}
