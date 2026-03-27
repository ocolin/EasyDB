<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB;

use Ocolin\EasyEnv\EasyEnvFileHandleError;
use Ocolin\EasyEnv\Env As EasyEnv;
use Ocolin\GlobalType\ENV;
use RuntimeException;
use PDO;



class DB
{
    /**
     * @var PDO PDO handler.
     */
    private PDO $db;


/* CONSTRUCTOR
----------------------------------------------------------------------------- */

    /**
     * @param string $name Name of database.
     * @param string $user Name of login user.
     * @param string $pass Password for login.
     * @param string $host Hostname of database server.
     * @param int $port Database port number.
     * @param array<int, int|bool> $options Additional PDO options.
     */
    private function __construct(
        string $name,
        string $user,
        string $pass,
        string $host = 'localhost',
           int $port = 3306,
         array $options = []
    )
    {
        $options = $options + [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_STRINGIFY_FETCHES  => false,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        $this->db = new PDO(
                 dsn: "mysql:host={$host};port={$port};dbname={$name}",
            username: $user,
            password: $pass,
             options: $options
        );
    }



/* CONNECT TO DB
----------------------------------------------------------------------------- */

    /**
     * Connect to database and return a PDO handler.
     *
     * @param string $host Hostname of database server.
     * @param string $name Name of database.
     * @param string $user Name of login user.
     * @param string $pass Password for login.
     * @param int $port Port number of database.
     * @param array<int, int|bool> $options Additional PDO options.
     */
    public static function connect(
        string $host,
        string $name,
        string $user,
        string $pass,
           int $port = 3306,
         array $options = []
    ) : PDO
    {
        return ( new self(
               name: $name,
               user: $user,
               pass: $pass,
               host: $host,
               port: $port,
            options: $options
        ))->db;
    }


/* FROM ENV
----------------------------------------------------------------------------- */

    /**
     *  Get Database handler using environment variables.
     *
     * @param string $prefix Prefix to prepend to Environment variables called.
     * @param string|array<string>|null $files Optional env file(s).
     * @param array<int, int|bool> $options Optional PDO parameters.
     * @return PDO Database handler.
     * @throws EasyEnvFileHandleError
     * @throws RuntimeException
     */
    public static function fromEnv(
        string $prefix,
        string|array|null $files = null,
        array $options = []
    ) : PDO
    {
        if( $files !== null ) { EasyEnv::load( files: $files, append: true ); }

        return self::connect(
               host: self::requireEnv( name: $prefix . '_DB_HOST' ),
               name: self::requireEnv( name: $prefix . '_DB_NAME' ),
               user: self::requireEnv( name: $prefix . '_DB_USER' ),
               pass: self::requireEnv( name: $prefix . '_DB_PASS' ),
               port: ENV::getIntNull( name: $prefix . 'DB_PORT' ) ?? 3306,
            options: $options
        );
    }



/* REQUIRE ENVIRONMENT VARIABLES
----------------------------------------------------------------------------- */

    /**
     * Validate parameter before sending to PDO.
     *
     * @param string $name Name of $_ENV key.
     * @return string Value of $_ENV key.
     * @throws RuntimeException
     */
    private static function requireEnv( string $name ) : string
    {
        return ENV::getStringNull( name: $name )
            ?? throw new RuntimeException(
                message: "Missing environment variable: {$name}"
            );
    }
}