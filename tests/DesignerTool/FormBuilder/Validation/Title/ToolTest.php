<?php

final class DesignerTool_FormBuilder_Validation_Title_ToolTest extends
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

        $this->tool = new Dlayer_DesignerTool_FormBuilder_Title_Tool();
    }

    /**
     * Expected form_title and form_subtitle indexes, value for form_subtitle optional
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
     * Expected form_title and form_subtitle indexes, value for form_subtitle optional
     */
    public function testFailsValidationMissingParamTitle()
    {
        $result = $this->tool->validateAuto(
            array(
                'form_subtitle' => 'Title'
            ),
            $this->site_id,
            $this->form_id
        );

        $this->assertFalse($result);
    }

    /**
     * Expected form_title and form_subtitle indexes, value for form_subtitle optional
     */
    public function testFailsValidationMissingParamSubTitle()
    {
        $result = $this->tool->validateAuto(
            array(
                'form_title' => 'Title'
            ),
            $this->site_id,
            $this->form_id
        );

        $this->assertFalse($result);
    }

    /**
     * Expected form_title and form_subtitle indexes, value for form_subtitle optional
     */
    public function testFailsValidationMissingParamTitleEmpty()
    {
        $result = $this->tool->validateAuto(
            array(
                'form_title' => '',
                'form_subtitle' => ''
            ),
            $this->site_id,
            $this->form_id
        );

        $this->assertFalse($result);
    }

    /**
     * Expected form_title and form_subtitle indexes, value for form_subtitle optional
     */
    public function testPassesValidationTitleAndSubtitle()
    {
        $result = $this->tool->validateAuto(
            array(
                'form_title' => 'Title',
                'form_subtitle' => 'Subtitle'
            ),
            $this->site_id,
            $this->form_id
        );

        $this->assertTrue($result);
    }

    /**
     * Expected form_title and form_subtitle indexes, value for form_subtitle optional
     */
    public function testPassesValidationTitleNoSubtitle()
    {
        $result = $this->tool->validateAuto(
            array(
                'form_title' => 'Title',
                'form_subtitle' => ''
            ),
            $this->site_id,
            $this->form_id
        );

        $this->assertTrue($result);
    }

    /**
     * Expected form_title and form_subtitle indexes, value for form_subtitle optional
     */
    public function testPassesValidationTitleInteger()
    {
        $result = $this->tool->validateAuto(
            array(
                'form_title' => 31415,
                'form_subtitle' => ''
            ),
            $this->site_id,
            $this->form_id
        );

        $this->assertTrue($result);
    }

    /**
     * Expected form_title and form_subtitle indexes, value for form_subtitle optional
     */
    public function testFailsValidationTitleNull()
    {
        try {
            $this->tool->validateAuto(
                array(
                    'form_title' => null,
                    'form_subtitle' => ''
                ),
                $this->site_id,
                $this->form_id
            );
        } catch (\Exception $e) {
            $this->assertFalse(false);
        }
    }

    /**
     * Expected form_title and form_subtitle indexes, value for form_subtitle optional
     */
    public function testFailsValidationTitleArray()
    {
        try {
            $this->tool->validateAuto(
                array(
                    'form_title' => array(),
                    'form_subtitle' => ''
                ),
                $this->site_id,
                $this->form_id
            );
        } catch (\Exception $e) {
            $this->assertFalse(false);
        }
    }

    /**
     * Expected form_title and form_subtitle indexes, value for form_subtitle optional
     */
    public function testFailsValidationTitleObject()
    {
        try {
            $this->tool->validateAuto(
                array(
                    'form_title' => new stdClass(),
                    'form_subtitle' => ''
                ),
                $this->site_id,
                $this->form_id
            );
        } catch (\Exception $e) {
            $this->assertFalse(false);
        }
    }
}
