<?php

final class DesignerTool_FormBuilder_Validation_Text_SubTool_Delete_ToolTest extends
    \PHPUnit_Framework_TestCase
{
    private $site_id;
    private $form_id;
    private $field_type;

    /**
     * @var Dlayer_Tool_Form
     */
    private $tool;

    public function setUp()
    {
        $this->site_id = 1;
        $this->form_id = 1;
        $this->field_type = 'Text';

        $this->tool = new Dlayer_DesignerTool_FormBuilder_Text_SubTool_Delete_Tool();
    }

    /**
     * Only expected param 'confirm' (1)
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
     * Only expected param 'confirm' (1)
     */
    public function testFailsValidationConfirmFalse()
    {
        $result = $this->tool->validate(
            array(
                'confirm' => 0
            ),
            $this->site_id,
            $this->form_id,
            $this->field_type
        );
        $this->assertFalse($result);
    }

    /**
     * Only expected param 'confirm' (1)
     */
    public function testFailsValidationConfirmNull()
    {
        $result = $this->tool->validate(
            array(
                'confirm' => null
            ),
            $this->site_id,
            $this->form_id,
            $this->field_type
        );
        $this->assertFalse($result);
    }

    /**
     * Only expected param 'confirm' (1)
     */
    public function testFailsValidationConfirmArray()
    {
        $result = $this->tool->validate(
            array(
                'confirm' => array()
            ),
            $this->site_id,
            $this->form_id,
            $this->field_type
        );
        $this->assertFalse($result);
    }

    /**
     * Only expected param 'confirm' (1)
     */
    public function testFailsValidationConfirmInteger()
    {
        $result = $this->tool->validate(
            array(
                'confirm' => 6
            ),
            $this->site_id,
            $this->form_id,
            $this->field_type
        );
        $this->assertFalse($result);
    }

    /**
     * Only expected param 'confirm' (1)
     */
    public function testFailsValidationConfirmString()
    {
        $result = $this->tool->validate(
            array(
                'confirm' => 'true'
            ),
            $this->site_id,
            $this->form_id,
            $this->field_type
        );
        $this->assertFalse($result);
    }

    /**
     * Only expected param 'confirm' (1)
     */
    public function testPassesValidation()
    {
        $result = $this->tool->validate(
            array(
                'confirm' => 1
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
    public function testPassesValidationExtraParam()
    {
        $result = $this->tool->validate(
            array(
                'confirm' => 1,
                'extraParam' => false
            ),
            $this->site_id,
            $this->form_id,
            $this->field_type
        );
        $this->assertTrue($result);
    }
}
