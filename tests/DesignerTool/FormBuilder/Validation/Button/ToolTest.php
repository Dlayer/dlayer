<?php

final class DesignerTool_FormBuilder_Validation_Button_ToolTest extends
    \PHPUnit_Framework_TestCase
{
    private $site_id;
    private $form_id;

    /**
     * @var Dlayer_Tool_Form
     */
    private $tool;

    public function setUp()
    {
        $this->site_id = 1;
        $this->form_id = 1;

        $this->tool = new Dlayer_DesignerTool_FormBuilder_Button_Tool();
    }

    /**
     * Expected submit_label, reset_label, value for reset_label optional
     */
    public function testFailsValidationMissingParams()
    {
        $result = $this->tool->validateAuto(
            array(),
            $this->site_id,
            $this->form_id
        );

        $this->assertFalse($result);
    }

    /**
     * Expected submit_label, reset_label, value for reset_label optional
     */
    public function testFailsValidationMissingParamSubmitLabel()
    {
        $result = $this->tool->validateAuto(
            array(
                'reset_label' => 'label'
            ),
            $this->site_id,
            $this->form_id
        );

        $this->assertFalse($result);
    }

    /**
     * Expected form_title and form_subtitle indexes, value for form_subtitle optional
     */
    public function testFailsValidationMissingParamResetLabel()
    {
        $result = $this->tool->validateAuto(
            array(
                'submit_label' => 'label'
            ),
            $this->site_id,
            $this->form_id
        );

        $this->assertFalse($result);
    }

    /**
     * Expected submit_label, reset_label, value for reset_label optional
     */
    public function testFailsValidationSubmitLabelEmpty()
    {
        $result = $this->tool->validateAuto(
            array(
                'submit_label' => '',
                'reset_label' => 'label'
            ),
            $this->site_id,
            $this->form_id
        );

        $this->assertFalse($result);
    }

    /**
     * Expected submit_label, reset_label, value for reset_label optional
     */
    public function testPassesValidationParamsSet()
    {
        $result = $this->tool->validateAuto(
            array(
                'submit_label' => 'Label 1',
                'reset_label' => 'Label 2'
            ),
            $this->site_id,
            $this->form_id
        );

        $this->assertTrue($result);
    }

    /**
     * Expected submit_label, reset_label, value for reset_label optional
     */
    public function testPassesValidationResetLabelEmpty()
    {
        $result = $this->tool->validateAuto(
            array(
                'submit_label' => 'Label 1',
                'reset_label' => null
            ),
            $this->site_id,
            $this->form_id
        );

        $this->assertTrue($result);
    }

    /**
     * Expected submit_label, reset_label, value for reset_label optional
     */
    public function testPassesValidationSubmitLabelInteger()
    {
        $result = $this->tool->validateAuto(
            array(
                'submit_label' => 31415,
                'reset_label' => null
            ),
            $this->site_id,
            $this->form_id
        );

        $this->assertTrue($result);
    }

    /**
     * Expected submit_label, reset_label, value for reset_label optional
     */
    public function testFailsValidationSubmitLabelNull()
    {
        $result = $this->tool->validateAuto(
            array(
                'submit_label' => null,
                'reset_label' => ''
            ),
            $this->site_id,
            $this->form_id
        );

        $this->assertFalse($result);
    }

    /**
     * Expected submit_label, reset_label, value for reset_label optional
     */
    public function testFailsValidationSubmitLabelArray()
    {
        try {
            $this->tool->validateAuto(
                array(
                    'submit_label' => array(),
                    'reset_label' => null
                ),
                $this->site_id,
                $this->form_id
            );
            $this->assertTrue(false); // Fail
        } catch (\Exception $e) {
            $this->assertFalse(false);
        }
    }

    /**
     * Expected submit_label, reset_label, value for reset_label optional
     */
    public function testFailsValidationSubmitLabelObject()
    {
        try {
            $this->tool->validateAuto(
                array(
                    'submit_label' => new stdClass(),
                    'reset_label' => null
                ),
                $this->site_id,
                $this->form_id
            );
            $this->assertTrue(false); // Fail
        } catch (\Exception $e) {
            $this->assertFalse(false);
        }
    }
}
