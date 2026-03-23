<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB\Tests;

use Ocolin\EasyDB\DB;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use PDO;

final class DBTest extends TestCase
{
   public function testFromEnvGood() : void
   {
       $db = DB::fromEnv( prefix: 'TEST', files: __DIR__ . '/../.env' );
       $this->assertInstanceOf( PDO::class, $db );
   }

   public function testFromEnvException() : void
   {
       $this->expectException( RuntimeException::class );
       $db = DB::fromEnv( prefix: 'MISSING', files: __DIR__ . '/../.env' );
   }
}

