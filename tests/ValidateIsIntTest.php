<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB\Tests;

use Ocolin\EasyDB\Validate;
use PHPUnit\Framework\TestCase;

class ValidateIsIntTest extends TestCase
{
    public function testIsIntInt() : void
    {
        $output = Validate::isInt( 1 );
        $this->assertTrue( $output );
    }

    public function testIsStringInt() : void
    {
        $output = Validate::isInt( "1" );
        $this->assertTrue( $output );
    }

    public function testIsNotInt() : void
    {
        $output = Validate::isInt( "String" );
        $this->assertIsString( $output );
    }

    public function testIsIntTooLowUnsigned() : void
    {
        $output = Validate::isInt( input: -1, unsigned: true );
        $this->assertIsString( $output );
    }

    public function testIsIntTooHighUnsigned() : void
    {
        $output = Validate::isInt( input: 4294967296, unsigned: true );
        $this->assertIsString( $output );
    }
}