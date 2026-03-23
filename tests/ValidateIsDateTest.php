<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB\Tests;

use Ocolin\EasyDB\Validate;
use PHPUnit\Framework\TestCase;

class ValidateIsDateTest extends TestCase
{
    public function testIsDateGood() : void
    {
        $output = Validate::isDATE( '2026-02-11' );
        $this->assertTrue( $output );
    }

    public function testIsDateBad() : void
    {
        $output = Validate::isDATE( 'string' );
        $this->assertIsString( $output );
    }

    public function testIsDateBadFormat() : void
    {
        $output = Validate::isDATE( 1 );
        $this->assertIsString( $output );
    }

}