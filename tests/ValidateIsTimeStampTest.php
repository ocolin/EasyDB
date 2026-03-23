<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB\Tests;

use Ocolin\EasyDB\Validate;
use PHPUnit\Framework\TestCase;

class ValidateIsTimeStampTest extends TestCase
{
    public function testIsTimestampTime() : void
    {
        $output = Validate::isTIMESTAMP( '2026-03-22 10:10:10' );
        $this->assertTrue( $output );
    }

    public function testIsTimestampBad() : void
    {
        $output = Validate::isTIMESTAMP( '2022-03-22 10:10:100' );
        $this->assertIsString( $output );
    }

    public function testIsTimestampRange() : void
    {
        $output = Validate::isTIMESTAMP( '999-03-22 10:10:100' );
        $this->assertIsString( $output );
    }
}