<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB\Tests;

use Ocolin\EasyDB\Validate;
use PHPUnit\Framework\TestCase;

class ValidateIsLongTextTest extends TestCase
{
    public function testIsTinyTextGood() : void
    {
        $output = Validate::isLONGTEXT( str_repeat( string: 'a', times: 25 ));
        $this->assertTrue( $output );
    }


    public function testIsTinyTextWrongFormat() : void
    {
        $output = Validate::isLONGTEXT( [] );
        $this->assertIsString( $output );
    }

}