<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB\Tests;

use Ocolin\EasyDB\Validate;
use PHPUnit\Framework\TestCase;

class ValidateIsBooleanTest extends TestCase
{
    public function testIsBooleanBoolean() : void
    {
        $output = Validate::isBoolean( true );
        $this->assertTrue( $output );
    }

    public function testIsBooleanInt() : void
    {
        $output = Validate::isBoolean( 1 );
        $this->assertTrue( $output );
    }

    public function testIsBooleanString() : void
    {
        $output = Validate::isBoolean( 'string' );
        $this->assertIsString( $output );
    }
}