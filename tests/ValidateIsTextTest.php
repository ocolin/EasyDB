<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB\Tests;

use Ocolin\EasyDB\Validate;
use PHPUnit\Framework\TestCase;

class ValidateIsTextTest extends TestCase
{
    public function testIsTinyTextGood() : void
    {
        $output = Validate::isTEXT( str_repeat( string: 'a', times: 255 ));
        $this->assertTrue( $output );
    }

    public function testIsTinyTextLong() : void
    {
        $output = Validate::isTEXT( str_repeat( string: 'a', times: 65536 ));
        $this->assertIsString( $output );
    }

    public function testIsTinyTextWrongFormat() : void
    {
        $output = Validate::isTEXT( [] );
        $this->assertIsString( $output );
    }

}