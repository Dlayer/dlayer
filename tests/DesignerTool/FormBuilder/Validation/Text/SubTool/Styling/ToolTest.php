<?php

final class DesignerTool_FormBuilder_Validation_Text_SubTool_Styling_ToolTest extends
    \PHPUnit_Framework_TestCase
{
    private $site_id;
    private $form_id;
    private $field_type;

    /**
     * @var Dlayer_Tool_Content
     */
    private $tool;

    public function setUp()
    {
        $this->site_id = 1;
        $this->form_id = 1;
        $this->field_type = 'Text';

        $this->tool = new Dlayer_DesignerTool_FormBuilder_Text_SubTool_Styling_Tool();
    }

    /**
     * Expects all the possible styling indexes
     */
    public function testFailsValidationMissingParam()
    {
        $result = $this->tool->validate(
            array(),
            $this->site_id,
            $this->form_id,
            $this->field_type
        );
        $this->assertFalse($result);
    }

    /**
     * Expects all the possible styling indexes, values optional
     */
    public function testPassesValidationNoValues()
    {
        $result = $this->tool->validate(
            array(
                'row_background_color' => ''
            ),
            $this->site_id,
            $this->form_id,
            $this->field_type
        );
        $this->assertTrue($result);
    }

    /**
     * Expects all the possible styling indexes, values optional
     */
    public function testFailsValidationRowBackgroundColourNotHexBadString()
    {
        try {
            $this->tool->validate(
                array(
                    'row_background_color' => 'AGp'
                ),
                $this->site_id,
                $this->form_id,
                $this->field_type
            );
        } catch (\Exception $e) {
            $this->assertFalse(false);
            return;
        }

        $this->assertTrue(true);
    }

    /**
     * Expects all the possible styling indexes, values optional
     */
    public function testFailsValidationRowBackgroundColourNotHexArray()
    {
        try {
            $this->tool->validate(
                array(
                    'row_background_color' => array()
                ),
                $this->site_id,
                $this->form_id,
                $this->field_type
            );
        } catch (\Exception $e) {
            $this->assertFalse(false);
            return;
        }

        $this->assertTrue(true);
    }

    /**
     * Expects all the possible styling indexes, values optional
     */
    public function testPassesValidation()
    {
        $result = $this->tool->validate(
            array(
                'row_background_color' => '#EAEAEA'
            ),
            $this->site_id,
            $this->form_id,
            $this->field_type
        );
        $this->assertTrue($result);
    }

    /**
     * Expects all the possible styling indexes, values optional
     */
    public function testPassesValidationWithAdditionalParam()
    {
        $result = $this->tool->validate(
            array(
                'row_background_color' => '#EAEAEA',
                'row_background_color_other'=> '#EAEAEA'
            ),
            $this->site_id,
            $this->form_id,
            $this->field_type
        );
        $this->assertTrue($result);
    }
}
