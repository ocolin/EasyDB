<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB\Tests;

use Ocolin\EasyDB\Validate;
use PHPUnit\Framework\TestCase;

class ValidateIsSmallIntTest extends TestCase
{
    public function testIsSmallIntInt() : void
    {
        $output = Validate::isSMALLINT( 1 );
        $this->assertTrue( $output );
    }

    public function testIsSmallIntStringInt() : void
    {
        $output = Validate::isSMALLINT( "1" );
        $this->assertTrue( $output );
    }

    public function testIsSmallIntString() : void
    {
        $output = Validate::isSMALLINT( "String" );
        $this->assertIsString( $output );
    }

    public function testIsSmallIntTooLow() : void
    {
        $output = Validate::isSMALLINT( -32769 );
        $this->assertIsString( $output );
    }

    public function testIsSmallIntTooHigh() : void
    {
        $output = Validate::isSMALLINT( 32768 );
        $this->assertIsString( $output );
    }


    public function testIsSmallIntTooLowUnsigned() : void
    {
        $output = Validate::isSMALLINT( input: -1, unsigned: true );
        $this->assertIsString( $output );
    }

    public function testIsSmallIntTooHighUnsigned() : void
    {
        $output = Validate::isSMALLINT( input: 65536, unsigned: true );
        $this->assertIsString( $output );
    }
}