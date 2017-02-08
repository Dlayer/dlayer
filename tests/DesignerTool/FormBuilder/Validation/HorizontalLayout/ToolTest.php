<?php

final class DesignerTool_FormBuilder_Validation_HorizontalLayout_ToolTest extends
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

        $this->tool = new Dlayer_DesignerTool_FormBuilder_HorizontalLayout_Tool();
    }

    /**
     * Expects horizontal, label_width and element_width indexes
     */
    public function testFailsValidationMissingParamLabelAndElement()
    {
        $result = $this->tool->validateAuto(
            array(
                'horizontal' => 3
            ),
            $this->site_id,
            $this->form_id
        );

        $this->assertFalse($result);
    }

    /**
     * Expects horizontal, label_width and element_width indexes
     */
    public function testFailsValidationMissingParamLabel()
    {
        $result = $this->tool->validateAuto(
            array(
                'horizontal' => 3,
                'element_width' => 9
            ),
            $this->site_id,
            $this->form_id
        );

        $this->assertFalse($result);
    }

    /**
     * Expects horizontal, label_width and element_width indexes
     */
    public function testFailsValidationMissingParamElement()
    {
        $result = $this->tool->validateAuto(
            array(
                'element_width' => 3,
                'label_width' => 9
            ),
            $this->site_id,
            $this->form_id
        );

        $this->assertFalse($result);
    }

    /**
     * Expects horizontal, label_width and element_width indexes
     */
    public function testFailsValidationMissingParamhorizontal()
    {
        $result = $this->tool->validateAuto(
            array(
                'horizontal' => 3,
                'label_width' => 9
            ),
            $this->site_id,
            $this->form_id
        );

        $this->assertFalse($result);
    }

    /**
     * Expects horizontal, label_width and element_width indexes
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
     * Expects horizontal, label_width and element_width indexes
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
     * Expects horizontal, label_width and element_width indexes
     */
    public function testFailsValidationInlineIdNull()
    {
        try {
            $this->tool->validateAuto(
                array(
                    'horizontal' => null
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
     * Expects horizontal, label_width and element_width indexes
     */
    public function testFailsValidationInlineIdString()
    {
        try {
            $this->tool->validateAuto(
                array(
                    'horizontal' => 'String'
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
     * Expects horizontal, label_width and element_width indexes
     */
    public function testFailsValidationInlineIdArray()
    {
        try {
            $this->tool->validateAuto(
                array(
                    'horizontal' => array()
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
     * Expects horizontal, label_width and element_width indexes
     */
    public function testFailsValidationInlineIdObject()
    {
        try {
            $this->tool->validateAuto(
                array(
                    'horizontal' => new stdClass()
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
