<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB;

require_once __DIR__ . '/../vendor/autoload.php';

use Exception;
use PDO;
use \Ocolin\Env\EasyEnv;
use PDOStatement;

class DB
{
    private PDO $db;


/* CONSTRUCTOR
----------------------------------------------------------------------------- */

    /**
     * @param string $host Hostname database is on
     * @param string $name Name of the database
     * @param string $user database login username
     * @param string $pass database login password
     */
    public function __construct(
        private readonly string $host,
        private readonly string $name,
        private readonly string $user,
        private readonly string $pass
    )
    {
        try {
            $this->db = new PDO(
                     dsn: "mysql:host={$this->host}; dbname={$this->name}",
                username: $this->user,
                password: $this->pass
            );
            $this->db->setAttribute( attribute: PDO::ATTR_ERRMODE, value: PDO::ERRMODE_EXCEPTION );
            $this->db->setAttribute( attribute: PDO::ATTR_STRINGIFY_FETCHES, value:false );
        }
        catch( \PDOException $e ) {
            if( isset( $_ENV['DATABASE_ERROR_EMAIL'] )) {
                mail(
                         to: $_ENV['DATABASE_ERROR_EMAIL'],
                    subject: "DB error with {$this->host} : {$this->name}",
                    message: print_r(
                        value: [
                            'globals' => $GLOBALS,
                            'db' => $e->getMessage()
                        ],
                        return: true
                    )
                );
            }
            else {
                echo $e->getMessage();
            }
        }

    }



/* CREATE DB HANDLER FROM ENV VARIABLES
----------------------------------------------------------------------------- */

    /**
     * Create a database handler using credentials in the environment while using
     * a prefix to allow multiple handlers.
     *
     * @param string $prefix Name to append onto environment variable. This is to
     *  allow multiple handlers with different names to be called, but while keeping
     * the data in the environment and avoid coding them all in.
     * @param string|null $db Name of table in Database.
     * @param bool $local Load environment variables from .env within this library.
     * @return PDO
     * @throws Exception
     */
    public static function envDbHandler(
        string $prefix,
        string $db = null,
          bool $local = false
    ) : PDO
    {
        if( $local === true ) {
            EasyEnv::loadEnv(path: __DIR__ . '/../.env', silent: true, append: true);
        }

        $o = new self(
            host: $_ENV[ $prefix . '_DB_HOST' ],
            name: $db ?? $_ENV[ $prefix . '_DB_NAME' ],
            user: $_ENV[ $prefix . '_DB_USER' ],
            pass: $_ENV[ $prefix . '_DB_PASS' ],
        );

        return $o->db;
    }



/* CREATE HANDLER ON LOCAL HOST
----------------------------------------------------------------------------- */

    /**
     * Create database handler using environment variable credentials but
     * using the localhost database.
     *
     * @param string $prefix Prefix to add to name of database environment
     * credentials.
     * @param string|null $db Name of DB table.
     * @param bool $local Load local environment variables.
     * @return PDO
     * @throws Exception
     */
    public static function localHandler(
        string $prefix,
        string $db = null,
          bool $local = false
    ) : PDO
    {
        if( $local === true ) {
            EasyEnv::loadEnv(path: __DIR__ . '/../.env', silent: true, append: true);
        }

        $o = new self(
            host: 'localhost',
            name: $db ?? $_ENV[ $prefix . '_DB_NAME' ],
            user: $_ENV[ $prefix . '_DB_USER' ],
            pass: $_ENV[ $prefix . '_DB_PASS' ],
        );

        return $o->db;
    }



/*
----------------------------------------------------------------------------- */

    /**
     * Generic static handler for creating a database connection.
     * Same as the constructor, but in static format.
     *
     * @param string $host name of host that database is on
     * @param string $name name of database
     * @param string $user database login username
     * @param string $pass database login password
     * @return PDO
     */
    public static function getHandler(
        string $host,
        string $name,
        string $user,
        string $pass
    ) : PDO
    {
        $o = new self(
            host: $host,
            name: $name,
            user: $user,
            pass: $pass,
        );

        return $o->db;
    }





/* CREATE REPLACE INTO QUERY
---------------------------------------------------------------------------- */

    /**
     *  @param  array<string, string|int|float> $params
     *  @param  string  $table Name of DB table
     *  @return string
     */

    public static function replace_Into( array $params, string $table ) : string
    {
        $columns = self::create_Columns( params: $params );
        $values  = self::create_Column_Values( params: $params );


        return /** @lang text */ "
            REPLACE INTO {$table}
                ( {$columns} )
            VALUES
                ( {$values} )
        ";
    }




/* BIND VALUES
---------------------------------------------------------------------------- */

    /**
     *  @param  PDOStatement $query
     *  @param  array<string, string|int|float> $params
     *  @return void
     */

    public static function bind_Values( PDOStatement &$query, array $params ) : void
    {
        foreach( $params as $key => $value )
        {
            $type = PDO::PARAM_STR;

            if( gettype( value: $value ) == 'integer' ) {
                $type = PDO::PARAM_INT;
            }
            $name = ":{$key}";
            $query->bindValue( param: $name, value: $value, type: $type );
        }
    }



/* BIND PARAMETERS
---------------------------------------------------------------------------- */

    /**
     *  @param  PDOStatement $query
     *  @param  array<string, string|int|float> $params
     *  @return void
     */

    public static function bind_Parameters( PDOStatement &$query, array &$params ) : void
    {
        foreach( $params as $key => $value )
        {
            $type = PDO::PARAM_STR;

            if( gettype( value:  $value ) === 'integer' ) {
                $type = PDO::PARAM_INT;
            }
            $name = ":{$key}";
            $query->bindParam( param:  $name, var: $value, type: $type );
        }
    }




    /* CREATE LIST OF COLUMNS
    ---------------------------------------------------------------------------- */

    /**
     *  @param  array<string, string|int|float> $params List of columns and values
     *  @return string
     */

    public static function create_Columns( array $params ) : string
    {
        $output = '';

        foreach( $params as $key => $value )
        {
            $output .= "`{$key}`, ";
        }

        return rtrim( string: $output, characters: ', ' );
    }



/* CREATE STRING OF COLUMN VALUE NAMES
---------------------------------------------------------------------------- */

    /**
     *  @param  array<string, string|int|float> $params List of columns and values
     *  @return string
     */

    public static function create_Column_Values( array $params ) : string
    {
        $output = '';

        foreach( $params as $key => $value )
        {
            $output .= ":{$key}, ";
        }

        return rtrim( string: $output, characters: ', ' );

    }




/* FILTER COLUMNS
---------------------------------------------------------------------------- */

    /**
     *  Take an array of parameters and filter out ones that are not allowed
     *
     *  @param  array<string, string|int|float>   $params List of parameters to send to DB
     *  @param  array<string>   $allowed          List of allowed parameters
     *  @return array<string, string|int|float>   List of filtered parameters
     */

    public static function filter_Columns( array $params, array $allowed ) : array
    {
        $output = [];

        foreach( $params as $key => $value )
        {
            if( in_array( needle:  $key, haystack:  $allowed )) {
                $output[$key] = $value;
            }
        }

        return $output;
    }



/* RETURN CURRENT TIMESTAMP
---------------------------------------------------------------------------- */

    /**
     *  @return string
     */

    public static function get_Timestamp() : string
    {
        return date( format: "Y-m-d H:i:s" );
    }


}