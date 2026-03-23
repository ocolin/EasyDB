<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB\Tests;

use Ocolin\EasyDB\Validate;
use PHPUnit\Framework\TestCase;

class ValidateIsMediumTextTest extends TestCase
{
    public function testIsTinyTextGood() : void
    {
        $output = Validate::isMEDIUMTEXT( str_repeat( string: 'a', times: 255 ));
        $this->assertTrue( $output );
    }

    public function testIsTinyTextLong() : void
    {
        $output = Validate::isMEDIUMTEXT( str_repeat( string: 'a', times: 16777216 ));
        $this->assertIsString( $output );
    }

    public function testIsTinyTextWrongFormat() : void
    {
        $output = Validate::isMEDIUMTEXT( [] );
        $this->assertIsString( $output );
    }
}