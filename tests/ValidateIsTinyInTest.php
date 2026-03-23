<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB\Tests;

use Ocolin\EasyDB\Validate;
use PHPUnit\Framework\TestCase;

class ValidateIsTinyInTest extends TestCase
{
    public function testIsTinyIntInt() : void
    {
        $output = Validate::isTINYINT( 1 );
        $this->assertTrue( $output );
    }

    public function testIsStringTinyInt() : void
    {
        $output = Validate::isTINYINT( "1" );
        $this->assertTrue( $output );
    }

    public function testIsNotTinyInt() : void
    {
        $output = Validate::isTINYINT( "String" );
        $this->assertIsString( $output );
    }

    public function testIsTinyIntTooLow() : void
    {
        $output = Validate::isTINYINT( -200 );
        $this->assertIsString( $output );
    }

    public function testIsTinyIntTooHigh() : void
    {
        $output = Validate::isTINYINT( 1000 );
        $this->assertIsString( $output );
    }


    public function testIsTinyIntTooLowUnsigned() : void
    {
        $output = Validate::isTINYINT( input: -1, unsigned: true );
        $this->assertIsString( $output );
    }

    public function testIsTinyIntTooHighUnsigned() : void
    {
        $output = Validate::isTINYINT( input: 1000, unsigned: true );
        $this->assertIsString( $output );
    }
}