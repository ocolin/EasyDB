<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB\Tests;

use Ocolin\EasyDB\Validate;
use PHPUnit\Framework\TestCase;

class ValidateIsTimeTest extends TestCase
{
    public function testIsTimeGood() : void
    {
        $output = Validate::isTime( '01:01:00' );
        $this->assertTrue( $output );
    }

    public function testIsTimeBad() : void
    {
        $output = Validate::isTime( '231:01:100' );
        $this->assertIsString( $output );
    }

    public function testIsTimeBadFormat() : void
    {
        $output = Validate::isTime( 1 );
        $this->assertIsString( $output );
    }
}