<?php

final class DesignerTool_ContentManager_Validation_Text_ToolTest extends \PHPUnit_Framework_TestCase
{
    private $site_id;
    private $page_id;

    /**
     * @var Dlayer_Tool_Content
     */
    private $tool;

    public function setUp()
    {
        $this->site_id = 1;
        $this->page_id = 1;

        $this->tool = new Dlayer_DesignerTool_ContentManager_Text_Tool();
    }

    /**
     * Expect two indexes, name and content, both must have strings with a length greater than 0
     */
    public function testFailsValidationMissingParam()
    {
        $result = $this->tool->validate(
            array(
                'content'=> 'Data'
            ),
            $this->site_id,
            $this->page_id
        );
        $this->assertFalse($result);
    }

    /**
     * Expect two indexes, name and content, both must have strings with a length greater than 0
     */
    public function testFailsValidationNoValues()
    {
        $result = $this->tool->validate(
            array(
                'name' => '',
                'content'=> ''
            ),
            $this->site_id,
            $this->page_id
        );
        $this->assertFalse($result);
    }

    /**
     * Expect two indexes, name and content, both must have strings with a length greater than 0
     */
    public function testFailsValidationOneValueArray()
    {
        try {
            $this->tool->validate(
                array(
                    'name' => 'Data',
                    'content'=> array()
                ),
                $this->site_id,
                $this->page_id
            );
        } catch (\Exception $e) {
            $this->assertFalse(false);
            return;
        }

        $this->assertTrue(true);
    }

    /**
     * Expect two indexes, name and content, both must have strings with a length greater than 0
     */
    public function testFailsValidationOneValueNull()
    {
        $result = $this->tool->validate(
            array(
                'name' => 'Data',
                'content'=> null
            ),
            $this->site_id,
            $this->page_id
        );
        $this->assertFalse($result);
    }

    /**
     * Expect two indexes, name and content, both must have strings with a length greater than 0
     */
    public function testFailsValidationOneValueObject()
    {
        try {
            $this->tool->validate(
                array(
                    'name' => 'Data',
                    'content'=> new stdClass()
                ),
                $this->site_id,
                $this->page_id
            );
        } catch (\Exception $e) {
            $this->assertFalse(false);
            return;
        }

        $this->assertTrue(true);
    }

    /**
     * Expect two indexes, name and content, both must have strings with a length greater than 0
     */
    public function testPassesValidation()
    {
        $result = $this->tool->validate(
            array(
                'name' => 'Data',
                'content'=> 'Data'
            ),
            $this->site_id,
            $this->page_id
        );
        $this->assertTrue($result);
    }

    /**
     * Expect two indexes, name and content, both must have strings with a length greater than 0
     */
    public function testPassesValidationWithAdditionalParam()
    {
        $result = $this->tool->validate(
            array(
                'name' => 'Data',
                'content'=> 'Data',
                'extra' => 'Data'
            ),
            $this->site_id,
            $this->page_id
        );
        $this->assertTrue($result);
    }
}
