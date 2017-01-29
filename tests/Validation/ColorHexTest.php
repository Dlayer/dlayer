<?php

final class Validation_ColorHexText extends \PHPUnit_Framework_TestCase
{
    public function testStringTooShort()
    {
        $validator = new \Dlayer_Validate_ColorHex();
        $this->assertFalse($validator->isValid('#ddd'));
    }

    public function testStringTooLong()
    {
        $validator = new \Dlayer_Validate_ColorHex();
        $this->assertFalse($validator->isValid('#dddddddd'));
    }

    public function testInvalidHexValue()
    {
        $validator = new \Dlayer_Validate_ColorHex();
        $this->assertFalse($validator->isValid('#jddddd'));
    }

    public function testValidHexValue()
    {
        $validator = new \Dlayer_Validate_ColorHex();
        $this->assertTrue($validator->isValid('#dddddd'));
    }
}
