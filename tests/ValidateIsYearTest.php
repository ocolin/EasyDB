<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB\Tests;

use Ocolin\EasyDB\Validate;
use PHPUnit\Framework\TestCase;

class ValidateIsYearTest extends TestCase
{
    public function testIsYear() : void
    {
        $output = Validate::isYear( '2026' );
        $this->assertTrue( $output );
    }

    public function testIsYearInt() : void
    {
        $output = Validate::isYear( 2026 );
        $this->assertTrue( $output );
    }

    public function testIsYearBad() : void
    {
        $output = Validate::isYear( 1900 );
        $this->assertIsString( $output );
    }

    public function testIsYearBadFormat() : void
    {
        $output = Validate::isYear( [] );
        $this->assertIsString( $output );
    }
}