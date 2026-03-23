<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB\Tests;

use Ocolin\EasyDB\Validate;
use PHPUnit\Framework\TestCase;

class ValidateIsTinyTextTest extends TestCase
{
    public function testIsTinyTextGood() : void
    {
        $output = Validate::isTINYTEXT( str_repeat( string: 'a', times: 255 ));
        $this->assertTrue( $output );
    }

    public function testIsTinyTextLong() : void
    {
        $output = Validate::isTINYTEXT( str_repeat( string: 'a', times: 256 ));
        $this->assertIsString( $output );
    }

    public function testIsTinyTextWrongFormat() : void
    {
        $output = Validate::isTINYTEXT( [] );
        $this->assertIsString( $output );
    }

}