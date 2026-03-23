<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB\Tests;

use Ocolin\EasyDB\Validate;
use PHPUnit\Framework\TestCase;

class ValidateIsFloatTest extends TestCase
{
    public function testIsFloatString() : void
    {
        $output = Validate::isFLOAT( input: "string", precision: 1, scale: 1 );
        $this->assertIsString( $output );
    }

    public function testIsFloatFloat() : void
    {
        $output = Validate::isFLOAT( input: 10.99, precision: 4, scale: 2 );
        $this->assertTrue( $output );
    }

    public function testIsFloatStringFloat() : void
    {
        $output = Validate::isFLOAT( input: "10.99", precision: 4, scale: 2 );
        $this->assertTrue( $output );
    }

    public function testIsFloatPrecision() : void
    {
        $output = Validate::isFLOAT( input: 10.99, precision: 2, scale: 2 );
        $this->assertIsString( $output );
    }

    public function testIsFloatScale() : void
    {
        $output = Validate::isFLOAT( input: 10.99, precision: 4, scale: 1 );
        $this->assertIsString( $output );
    }

}