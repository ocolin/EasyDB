<?php

declare( strict_types = 1 );

namespace Ocolin\Database\Tests;

use PHPUnit\Framework\TestCase;
use Ocolin\Database\DB;

final class testTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testONE() : void
    {
        $test = DB::envDbHandler( prefix: 'TEST', local: true );
        $test->prepare( query: "SELECT * FROM device");
    }
}

