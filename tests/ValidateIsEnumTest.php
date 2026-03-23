<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB\Tests;

use Ocolin\EasyDB\Validate;
use PHPUnit\Framework\TestCase;

class ValidateIsEnumTest extends TestCase
{
    public function testIsEnumGood() : void
    {
        $output = Validate::isENUM( input: 'a',  allowed: [ 'a', 'b', 'c' ] );
        $this->assertTrue( $output );
    }

    public function testIsEnumBad() : void
    {
        $output = Validate::isENUM( input: 'g', allowed: [ 'a', 'b', 'c' ] );
        $this->assertIsString( $output );
    }
}