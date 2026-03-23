<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB\Tests;

use Ocolin\EasyDB\Validate;
use PHPUnit\Framework\TestCase;

class ValidateIsDateTimeTest extends TestCase
{
    public function testIsDateTime() : void
    {
        $output = Validate::isDATETIME( '2026-03-22 10:10:10' );
        $this->assertTrue( $output );
    }

    public function testIsDateBad() : void
    {
        $output = Validate::isDATETIME( '2022-03-22 10:10:100' );
        $this->assertIsString( $output );
    }

    public function testIsDateRange() : void
    {
        $output = Validate::isDATETIME( '999-03-22 10:10:100' );
        $this->assertIsString( $output );
    }
}