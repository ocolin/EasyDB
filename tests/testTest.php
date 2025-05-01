<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Ocolin\EasyDB\DB;

final class testTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testONE() : void
    {
        $db = DB::envDbHandler( prefix: 'TEST', local: true );
        $query = $db->prepare( query: "SELECT * FROM device");
        $query->execute();

        $output = $query->fetchAll( mode: \PDO::FETCH_ASSOC );
        $this->assertIsArray( actual: $output );

    }
}

