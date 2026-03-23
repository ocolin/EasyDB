<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB\Tests;

use Ocolin\EasyDB\Validate;
use PHPUnit\Framework\TestCase;

class ValidateIsCharTest extends TestCase
{
    public function testIsCharChar() : void
    {
        $output = Validate::isCHAR( input: 'a', length: 1 );
        $this->assertTrue( $output );
    }

    public function testIsCharInt() : void
    {
        $output = Validate::isCHAR( input: 1, length: 1 );
        $this->assertTrue( $output );
    }

    public function testIsCharFloat() : void
    {
        $output = Validate::isCHAR( input: 1.1, length: 3 );
        $this->assertTrue( $output );
    }

    public function testIsCharArray() : void
    {
        $output = Validate::isCHAR( input: [], length: 3 );
        $this->assertIsString( $output );
    }

    public function testIsCharLength() : void
    {
        $output = Validate::isCHAR( input: 'aaa', length: 1 );
        $this->assertIsString( $output );
    }
}