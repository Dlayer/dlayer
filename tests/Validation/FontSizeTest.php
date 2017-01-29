<?php

final class Validation_FontSizeTest extends \PHPUnit_Framework_TestCase
{
    public function testPassingString()
    {
        $validator = new \Dlayer_Validate_FontSize();
        $this->assertFalse($validator->isValid('two'));
    }

    public function testPassingArray()
    {
        $validator = new \Dlayer_Validate_FontSize();
        $this->assertFalse($validator->isValid(array()));
    }

    public function testPassingNull()
    {
        $validator = new \Dlayer_Validate_FontSize();
        $this->assertFalse($validator->isValid(null));
    }

    public function testPassingInteger()
    {
        $validator = new \Dlayer_Validate_FontSize();
        $this->assertTrue($validator->isValid(28));
    }

    public function testPassingIntegerBelowLowerLimit()
    {
        $validator = new \Dlayer_Validate_FontSize();
        $this->assertFalse($validator->isValid(4));
    }

    public function testPassingIntegerAboveHigherLimit()
    {
        $validator = new \Dlayer_Validate_FontSize();
        $this->assertFalse($validator->isValid(74));
    }

    public function testPassingIntegerLowerLimit()
    {
        $validator = new \Dlayer_Validate_FontSize();
        $this->assertTrue($validator->isValid(6));
    }

    public function testPassingIntegerHigherLimit()
    {
        $validator = new \Dlayer_Validate_FontSize();
        $this->assertTrue($validator->isValid(72));
    }
}
