<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB\Tests;

use Ocolin\EasyDB\Validate;
use PHPUnit\Framework\TestCase;

class ValidateIsMediumIntTest extends TestCase
{
    public function testIsMediumInt() : void
    {
        $output = Validate::isMEDIUMINT( 1 );
        $this->assertTrue( $output );
    }

    public function testIsMediumIntStringInt() : void
    {
        $output = Validate::isMEDIUMINT( "1" );
        $this->assertTrue( $output );
    }

    public function testIsMediumIntString() : void
    {
        $output = Validate::isMEDIUMINT( "String" );
        $this->assertIsString( $output );
    }

    public function testIsMediumIntTooLow() : void
    {
        $output = Validate::isMEDIUMINT( -8388609 );
        $this->assertIsString( $output );
    }

    public function testIsMediumIntTooHigh() : void
    {
        $output = Validate::isMEDIUMINT( 8388608 );
        $this->assertIsString( $output );
    }


    public function testIsMediumIntTooLowUnsigned() : void
    {
        $output = Validate::isMEDIUMINT( input: -1, unsigned: true );
        $this->assertIsString( $output );
    }

    public function testIsMediumIntTooHighUnsigned() : void
    {
        $output = Validate::isMEDIUMINT( input: 16777216, unsigned: true );
        $this->assertIsString( $output );
    }
}