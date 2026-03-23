<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB;

use Ocolin\EasyEnv\EasyEnvFileHandleError;
use Ocolin\EasyEnv\Env As EasyEnv;
use Ocolin\GlobalType\ENV;
use PDO;
use RuntimeException;

/*
 *  PDO::ATTR_DEFAULT_FETCH_MODE    PDO::FETCH_ASSOC
 *  PDO::ATTR_EMULATE_PREPARES
 *  PDO::ATTR_PERSISTENT
 *  PDO::MYSQL_ATTR_INIT_COMMAND
 */


class DB
{
    private PDO $db;


/*
----------------------------------------------------------------------------- */

    /**
     * @param string $name Name of database.
     * @param string $user Name of login user.
     * @param string $pass Password for login.
     * @param string $host Hostname of database server.
     * @param array<int, int|bool> $options Additional PDO options.
     */
    private function __construct(
        string $name,
        string $user,
        string $pass,
        string $host = 'localhost',
         array $options = []
    )
    {
        $options = $options + [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_STRINGIFY_FETCHES  => false,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        $this->db = new PDO(
                 dsn: "mysql:host={$host};dbname={$name}",
            username: $user,
            password: $pass,
             options: $options
        );
    }



/*
----------------------------------------------------------------------------- */

    /**
     * @param string $host Hostname of database server.
     * @param string $name Name of database.
     * @param string $user Name of login user.
     * @param string $pass Password for login.
     * @param array<int, int|bool> $options Additional PDO options.
     */
    public static function connect(
        string $host,
        string $name,
        string $user,
        string $pass,
         array $options = []
    ) : PDO
    {
        return ( new self(
               name: $name,
               user: $user,
               pass: $pass,
               host: $host,
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