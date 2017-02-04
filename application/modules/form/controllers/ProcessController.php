<?php

/**
 * The process controller is where all the tools $_POST their data.
 *
 * The controller checks to see that the submitted tool is valid and then calls the tool class. The validate method is
 * called on the tool class to check the submitted data. If the submitted data is valid the $_POST array is passed
 * to the individual tool class which does all the heaving lifting.
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Form_ProcessController extends Zend_Controller_Action
{
    /**
     * Type hinting for action helpers, hints the property to the code
     * hinting class which exists in the library
     *
     * @var Dlayer_Action_CodeHinting
     */
    protected $_helper;

    /**
     * @var boolean
     */
    private $debug;

    /**
     * @var string
     */
    private $tool_name;

    /**
     * Init the controller, run any set up code required by all the actions
     *
     * @return void
     */
    public function init()
    {
        $this->_helper->validateModule();

        $this->_helper->authenticate();

        $this->_helper->disableLayout(false);

        $this->debug = intval($this->getInvokeArg('bootstrap')->getOption('debug'));
    }

    /**
     * Validate the request, checks the tool is valid and the base environment params are correct. Values should be
     * validated before they get set in session so we can simply check they match here
     *
     * @param Dlayer_Session_Form $session
     * @param Dlayer_Session_Designer $session_designer
     *
     * @return boolean
     */
    private function validateRequest($session, $session_designer)
    {
        if ($session->formId() === Dlayer_Helper::getParamAsInteger('form_id') &&
            (
                $session->fieldId() === Dlayer_Helper::getParamAsInteger('field_id') ||
                $session->fieldId() === null
            ) &&
            $session_designer->tool('form') !== false &&
            $session_designer->tool('form')['tool'] === Dlayer_Helper::getParamAsString('tool')
        ) {
            return true;
        } else {
            Dlayer_Helper::sendToErrorLog('FormBuilder::validateRequest() returned FALSE');
            Dlayer_Helper::sendToErrorLog('- Session form id: ' . $session->formId() . ' POSTed form id: ' .
                Dlayer_Helper::getParamAsInteger('form_id'));
            Dlayer_Helper::sendToErrorLog('- Session field id: ' . $session->fieldId() . ' POSTed field id: ' .
                Dlayer_Helper::getParamAsInteger('field_id'));
            Dlayer_Helper::sendToErrorLog('- Session tool: ' . $session_designer->tool('form')['tool'] .
                ' POSTed tool: ' . Dlayer_Helper::getParamAsString('tool'));

            return false;
        }
    }

    /**
     * Validate the request, checks the tool is valid and the base environment params are correct. Values should be
     * validated before they get set in session so we can simply check they match here
     *
     * @param Dlayer_Session_Form $session
     * @param Dlayer_Session_Designer $session_designer
     *
     * @return boolean
     */
    private function validateAutoRequest($session, $session_designer)
    {
        if ($session->formId() === Dlayer_Helper::getParamAsInteger('form_id') &&
            $session_designer->tool('form') !== false &&
            $session_designer->tool('form')['tool'] === Dlayer_Helper::getParamAsString('tool')
        ) {
            return true;
        } else {
            Dlayer_Helper::sendToErrorLog('FormBuilder::validateAutoRequest() returned FALSE');
            Dlayer_Helper::sendToErrorLog('- Session form id: ' . $session->formId() . ' POSTed form id: ' .
                Dlayer_Helper::getParamAsInteger('form_id'));
            Dlayer_Helper::sendToErrorLog('- Session tool: ' . $session_designer->tool('form')['tool'] .
                ' POSTed tool: ' . Dlayer_Helper::getParamAsString('tool'));

            return false;
        }
    }

    /**
     * Return the instantiated tool class
     *
     * @param string $sub_tool_model
     *
     * @return Dlayer_Tool_Form
     */
    private function toolClass($sub_tool_model = null)
    {
        $session_designer = new Dlayer_Session_Designer();

        if ($sub_tool_model !== null) {
            $class_name = 'Dlayer_DesignerTool_FormBuilder_' . $session_designer->tool('form')['tool'] .
                '_SubTool_' . $sub_tool_model . '_Tool';
        } else {
            $class_name = 'Dlayer_DesignerTool_FormBuilder_' . $session_designer->tool('form')['tool'] .
                '_Tool';
        }

        $this->tool_name = $class_name;

        return new $class_name();
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
        $session = new Dlayer_Session_Form();
        $session->clearAll();

        foreach ($environment_ids as $id) {
            switch ($id['type']) {
                case 'form_id':
                    $session->setFormId($id['id']);
                    break;

                case 'field_id':
                    $session->setFieldId($id['id']);
                    break;

                case 'tool':
                    $session_designer->setTool('form', $id['id']);
                    break;

                case 'tab':
                    $session_designer->setToolTab('form', $id['id'], $id['sub_tool']);
                    break;

                default:
                    break;
            }
        }
    }

    /**
     * Process method for the manual tools, manual tools are any tools where the user has to provide input which needs
     * validating. Assuming the environment params are correct and they match the corresponding session values we
     * simply pass the request off to the tool class. In all cases, success and failure, the user is returned back to
     * the designer, the only difference being whether the state of the designer is maintained, that depends on the
     * success of the request and whether the tool is multi-use or not
     *
     * @return void
     */
    public function toolAction()
    {
        $session_dlayer = new Dlayer_Session();
        $session = new Dlayer_Session_Form();
        $session_designer = new Dlayer_Session_Designer();

        if ($this->validateRequest($session, $session_designer) === false) {
            $this->returnToDesigner(false);
        }

        $tool = $this->toolClass(Dlayer_Helper::getParamAsString('sub_tool_model', null));

        if ($tool->validate($this->getRequest()->getPost('params'), $session_dlayer->siteId(),
                $session->formId(), $this->getRequest()->getPost('field_type'), $session->fieldId()) === true) {

            $return_ids = $tool->process();

            if ($return_ids !== false && is_array($return_ids) === true) {
                $this->setEnvironmentIds($return_ids);
                $this->returnToDesigner(true);
            } else {
                $this->returnToDesigner(false);
            }
        } else {
            Dlayer_Helper::sendToErrorLog('Validation failure for tool ' . $this->tool_name . ' POSTed: ' .
                var_export($this->getRequest()->getPost(), true));
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
        $session = new Dlayer_Session_Form();
        $session_designer = new Dlayer_Session_Designer();

        if ($this->validateAutoRequest($session, $session_designer) === false) {
            $this->returnToDesigner(false);
        }

        $tool = $this->toolClass(Dlayer_Helper::getParamAsString('sub_tool_model', null));

        if ($tool->validateAuto($this->getRequest()->getPost('params'), $session_dlayer->siteId(),
                $session->formId()) === true) {

            $return_ids = $tool->processAuto();

            if ($return_ids !== false && is_array($return_ids) === true) {
                $this->setEnvironmentIds($return_ids);

                /**
                 * Multi use does not really apply to structure tools so not calling returnToDesigner, will review
                 * that as we add more tools, may just need another param for the method
                 *
                 * @todo Review this
                 */
                $this->redirect('form/design');
            } else {
                $this->returnToDesigner(false);
            }
        } else {
            Dlayer_Helper::sendToErrorLog('Validation failure for tool ' . $this->tool_name . ' POST' .
                var_export($this->getRequest()->getPost(), true));
        }
    }

    /**
     * Redirect the user back to the designer, will call the cancel tool to clear all environment variables unless the
     * tool is marked as multi use. If the debug param is set the redirect will not occur, will remain on process
     * action so errors can be shown
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
            $this->redirect('form/design/set-tool/tool/Cancel');
        }

        if ($this->debug === 1) {
            exit();
        }

        $multi_use = Dlayer_Helper::getParamAsInteger('multi_use');

        if ($multi_use !== null && $multi_use === 1) {
            $this->redirect('form/design');
        } else {
            $this->redirect('form/design/set-tool/tool/Cancel');
        }
    }
}
