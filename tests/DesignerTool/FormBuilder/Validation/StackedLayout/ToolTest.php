<?php

final class DesignerTool_FormBuilder_Validation_StackedLayout_ToolTest extends
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

        $this->tool = new Dlayer_DesignerTool_FormBuilder_StackedLayout_Tool();
    }

    /**
     * Expects inline index
     */
    public function testFailsValidationMissingParam()
    {
        $result = $this->tool->validateAuto(
            array(),
            $this->site_id,
            $this->form_id
        );

        $this->assertFalse($result);
    }

    /**
     * Expects inline index and value of 2
     */
    /*public function testPassesValidation()
    {
        $result = $this->tool->validateAuto(
            array(
                'inline' => 2
            ),
            $this->site_id,
            $this->form_id
        );

        // No test yet, need database connection

        $this->assertTrue(true);
    }*/

    /**
     * Expects inline index and value of 2
     */
    /*public function testFailsValidationInlineIdInvalid()
    {

        $result = $this->tool->validateAuto(
            array(
                'inline' => 3
            ),
            $this->site_id,
            $this->form_id
        );

        // No test yet, need database connection

        $this->assertFalse(false);
    }*/

    /**
     * Expects inline index and value of 2
     */
    public function testFailsValidationInlineIdNull()
    {
        try {
            $this->tool->validateAuto(
                array(
                    'stacked' => null
                ),
                $this->site_id,
                $this->form_id
            );
        } catch (\Exception $e) {
            $this->assertFalse(false);
            return;
        }

        $this->assertTrue(true);
    }

    /**
     * Expects inline index and value of 2
     */
    public function testFailsValidationInlineIdString()
    {
        try {
            $this->tool->validateAuto(
                array(
                    'stacked' => 'String'
                ),
                $this->site_id,
                $this->form_id
            );
        } catch (\Exception $e) {
            $this->assertFalse(false);
            return;
        }

        $this->assertTrue(true);
    }

    /**
     * Expects inline index and value of 2
     */
    public function testFailsValidationInlineIdArray()
    {
        try {
            $this->tool->validateAuto(
                array(
                    'stacked' => array()
                ),
                $this->site_id,
                $this->form_id
            );
        } catch (\Exception $e) {
            $this->assertFalse(false);
            return;
        }

        $this->assertTrue(true);
    }

    /**
     * Expects inline index and value of 2
     */
    public function testFailsValidationInlineIdObject()
    {
        try {
            $this->tool->validateAuto(
                array(
                    'stacked' => new stdClass()
                ),
                $this->site_id,
                $this->form_id
            );
        } catch (\Exception $e) {
            $this->assertFalse(false);
            return;
        }

        $this->assertTrue(true);
    }
}
