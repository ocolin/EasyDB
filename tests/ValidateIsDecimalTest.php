<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB\Tests;

use Ocolin\EasyDB\Validate;
use PHPUnit\Framework\TestCase;

class ValidateIsDecimalTest extends TestCase
{
    public function testValidateIsDecimalString() : void
    {
        $output = Validate::isDECIMAL( input: "string", precision: 10, scale: 10 );
        $this->assertIsString( $output );
    }

    public function testValidateIsDecimalPrecision() : void
    {
        $output = Validate::isDECIMAL( input: 100.999, precision: 1, scale: 1 );
        $this->assertIsString( $output );
    }

    public function testValidateIsDecimalScale() : void
    {
        $output = Validate::isDECIMAL( input: 100.999, precision: 6, scale: 1 );
        $this->assertIsString( $output );
    }

    public function testValidateIsDecimalGood() : void
    {
        $output = Validate::isDecimal( input: 1.10, precision: 5, scale: 2 );
        $this->assertTrue( $output );
    }
}