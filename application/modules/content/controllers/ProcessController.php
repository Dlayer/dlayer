<?php

/**
 * The process controller is where all the tools $_POST their data.
 *
 * The controller checks to see that the submitted tool is valid and then calls
 * the tool class. The validate method is called on the tool class to check
 * the submitted data.
 *
 * If the submitted data is valid the $_POST array is passed to the individial
 * tool class which does all the heaving lifting.
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Content_ProcessController extends Zend_Controller_Action
{
    /**
     * Type hinting for action helpers, hints the property to the code
     * hinting class which exists in the library
     *
     * @var Dlayer_Action_CodeHinting
     */
    protected $_helper;

    private $debug;
    private $tool_class_name;

    /**
     * Init the controller, run any set up code required by all the actions
     * in the controller
     *
     * @return void
     */
    public function init()
    {
        $this->_helper->validateModule();

        $this->_helper->authenticate();

        $this->_helper->disableLayout(false);

        $this->debug = intval($this->getInvokeArg('bootstrap')
            ->getOption('debug'));
    }

    /**
     * Validate the request, checks the tool is valid and the base environment params are correct. Values should be
     * validated before they get set in session so we can simply check they match here
     *
     * @param Dlayer_Session_Content $session_content
     * @param Dlayer_Session_Designer $session_designer
     *
     * @return boolean
     */
    private function validateRequest($session_content, $session_designer)
    {
        if ($session_content->pageId() === Dlayer_Helper::getParamAsInteger('page_id') &&
            $session_content->rowId() === Dlayer_Helper::getParamAsInteger('row_id') &&
            $session_content->columnId() === Dlayer_Helper::getParamAsInteger('column_id') &&
            (
                $session_content->contentId() === Dlayer_Helper::getParamAsInteger('content_id') ||
                $session_content->contentId() === null
            ) &&
            $session_designer->tool('content') !== false &&
            $session_designer->tool('content')['tool'] === Dlayer_Helper::getParamAsString('tool')
        ) {
            return true;
        } else {
            Dlayer_Helper::sendToErrorLog('ContentManager::validateRequest() returned FALSE');
            Dlayer_Helper::sendToErrorLog('- Session page id: ' . $session_content->pageId() . ' POSTed page id: ' .
                Dlayer_Helper::getParamAsInteger('page_id'));
            Dlayer_Helper::sendToErrorLog('- Session row id: ' . $session_content->rowId() . ' POSTed row id: ' .
                Dlayer_Helper::getParamAsInteger('row_id'));
            Dlayer_Helper::sendToErrorLog('- Session column id: ' . $session_content->columnId() .
                ' POSTed column id: ' .
                Dlayer_Helper::getParamAsInteger('column_id'));
            Dlayer_Helper::sendToErrorLog('- Session content id: ' . $session_content->contentId() .
                ' POSTed content id: ' .
                Dlayer_Helper::getParamAsInteger('content_id'));
            Dlayer_Helper::sendToErrorLog('- Session tool: ' . $session_designer->tool('content')['tool'] .
                ' POSTed tool: ' .
                Dlayer_Helper::getParamAsString('tool'));

            return false;
        }
    }

    /**
     * Validate the request, checks the tool is valid and the base environment params are correct. Values should be
     * validated before they get set in session so we can simply check they match here
     *
     * @param Dlayer_Session_Content $session_content
     * @param Dlayer_Session_Designer $session_designer
     *
     * @return boolean
     */
    private function validateAutoRequest($session_content, $session_designer)
    {
        if ($session_content->pageId() === Dlayer_Helper::getParamAsInteger('page_id') &&
            $session_designer->tool('content') !== false &&
            $session_designer->tool('content')['tool'] === Dlayer_Helper::getParamAsString('tool')
        ) {
            return true;
        } else {
            Dlayer_Helper::sendToErrorLog('ContentManager::validateAutoRequest() returned FALSE');
            Dlayer_Helper::sendToErrorLog('- Session page id: ' . $session_content->pageId() . ' POSTed page id: ' .
                Dlayer_Helper::getParamAsInteger('page_id'));
            Dlayer_Helper::sendToErrorLog('- Session tool: ' . $session_designer->tool('content')['tool'] .
                ' POSTed tool: ' .
                Dlayer_Helper::getParamAsString('tool'));

            return false;
        }
    }

    /**
     * Fetch the tool class, either returns the tool defined in the session or the tool that matches the
     * POSTed sub tool
     *
     * @param string $sub_tool_model
     *
     * @return Dlayer_Tool_Content
     */
    private function toolClass($sub_tool_model = null)
    {
        $session_designer = new Dlayer_Session_Designer();

        if ($sub_tool_model !== null) {
            $tool_class = 'Dlayer_DesignerTool_ContentManager_' . $session_designer->tool('content')['tool'] .
                '_SubTool_' . $sub_tool_model . '_Tool';
        } else {
            $tool_class = 'Dlayer_DesignerTool_ContentManager_' . $session_designer->tool('content')['tool'] . '_Tool';
        }

        $this->tool_class_name = $tool_class;

        return new $tool_class();
    }

    /**
     * Set the environment id
     *
     * @param array $environment_ids
     *
     * @return void
     */
    private function setEnvironmentIds(array $environment_ids)
    {
        $session_designer = new Dlayer_Session_Designer();
        $session_content = new Dlayer_Session_Content();
        $session_content->clearAll();

        foreach ($environment_ids as $id) {
            switch ($id['type']) {
                case 'page_id':
                    $session_content->setPageId($id['id']);
                    $session_content->setPageSelected();
                    break;

                case 'row_id':
                    $session_content->setRowId($id['id']);
                    break;

                case 'column_id':
                    $session_content->setColumnId($id['id']);
                    break;

                case 'content_id':
                    $session_content->setContentId($id['id'], $id['content_type']);
                    break;

                case 'tool':
                    $session_designer->setTool('content', $id['id']);
                    break;

                case 'tab':
                    $session_designer->setToolTab('content', $id['id'], $id['sub_tool']);
                    break;

                default:
                    break;
            }
        }
    }

    /**
     * Process method for the manual tools, manual tools are any tools where the user has to provide input which needs
     * validating. Assuming the environment params are correct and they match the corresponding session values we
     * simply pass the request off to the tool class.
     * In all cases, success and failure, the user is returned back to the designer, the only difference being
     * whether the state of the designer is maintained, that depends on the success of the request and whether the
     * tool is multi-use or not
     *
     * @return void
     */
    public function toolAction()
    {
        $session_dlayer = new Dlayer_Session();
        $session_content = new Dlayer_Session_Content();
        $session_designer = new Dlayer_Session_Designer();

        if ($this->validateRequest($session_content, $session_designer) === false) {
            $this->returnToDesigner(false);
        }

        $tool = $this->toolClass(Dlayer_Helper::getParamAsString('sub_tool_model', null));

        if ($tool->validate($this->getRequest()
                ->getPost('params'), $session_dlayer->siteId(),
                $session_content->pageId(), $session_content->rowId(), $session_content->columnId(),
                $session_content->contentId()) === true
        ) {
            $return_ids = $tool->process();

            if ($return_ids !== false && is_array($return_ids) === true) {
                $this->setEnvironmentIds($return_ids);
                $this->returnToDesigner(true);
            } else {
                $this->returnToDesigner(false);
            }
        }
    }

    /**
     * Process method for the auto tools, auto tools affect the structure of a page and can set multiple ids after
     * processing
     *
     * @return void
     */
    public function toolAutoAction()
    {
        $session_dlayer = new Dlayer_Session();
        $session_content = new Dlayer_Session_Content();
        $session_designer = new Dlayer_Session_Designer();

        if ($this->validateAutoRequest($session_content, $session_designer) === false) {
            $this->returnToDesigner(false);
        }

        $tool = $this->toolClass(Dlayer_Helper::getParamAsString('sub_tool_model', null));

        if ($tool->validateAuto($this->getRequest()
                ->getPost('params'), $session_dlayer->siteId(),
                $session_content->pageId(), $session_content->rowId(), $session_content->columnId()) === true
        ) {

            $return_ids = $tool->processAuto();

            if ($return_ids !== false) {
                $this->setEnvironmentIds($return_ids);

                /**
                 * Multi use does not really apply to structure tools so not calling returnToDesigner, will review
                 * that as we add more tools, may just need another param for the method
                 *
                 * @todo Review this
                 */
                $this->redirect('content/design');
            } else {
                $this->returnToDesigner(false);
            }
        } else {
            Dlayer_Helper::sendToErrorLog('Validation failure for tool ' . $this->tool_class_name . ' POST' .
                var_export($this->getRequest()
                    ->getPost('params')));
        }
    }

    /**
     * Redirect the user back to the designer, will call the cancel tool to clear all environment variables unless the
     * tool is marked as multi use
     *
     * If the debug param is set the redirect will not occur, will remain on process action so errors can be shown
     *
     * @todo Need to add logging, success does nothing
     *
     * @param boolean $success Whether or not the request should be considered successful
     *
     * @return void
     */
    public function returnToDesigner($success = true)
    {
        if ($success === false) {
            $this->redirect('content/design/set-tool/tool/cancel');
        }

        if ($this->debug === 1) {
            exit();
        }

        $multi_use = Dlayer_Helper::getParamAsInteger('multi_use');

        if ($multi_use !== null && $multi_use === 1) {
            $this->redirect('content/design');
        } else {
            $this->redirect('content/design/set-tool/tool/cancel');
        }
    }
}
