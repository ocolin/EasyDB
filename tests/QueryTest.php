<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB\Tests;

use Ocolin\EasyDB\Query;
use Ocolin\EasyDB\DB;
use PHPUnit\Framework\TestCase;

class QueryTest extends TestCase
{
   public function testQueryCreateColumns() : void
   {
       $output = Query::createColumns( params: ['one' => 1, 'two' => 2, 'three' => 3] );
       $this->assertSame( '`one`, `two`, `three`', $output );
   }

    public function testQueryCreateColumnValues() : void
    {
        $output = Query::createColumnValues( params: ['one' => 1, 'two' => 2, 'three' => 3] );
        $this->assertSame( ':one, :two, :three', $output );
    }

    public function testQueryReplaceInto() : void
    {
        $params =  ['one' => 1, 'two' => 2, 'three' => 3];
        $output = Query::replaceInto( table: 'mytable', params: $params );
        $this->assertSame( "REPLACE INTO mytable
                ( `one`, `two`, `three` )
            VALUES
                ( :one, :two, :three )", $output );
    }


    public function testQueryFilterColumns() : void
    {
        $allowed  = [ 'one' ];
        $params   = [ 'one' => 1, 'two' => 2, 'three' => 3 ];

        $output = Query::filterColumns( params: $params, allowed: $allowed );
        $this->assertSame( [ 'one' => 1 ], $output );
    }


}
