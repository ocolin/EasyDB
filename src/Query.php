<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB;

use PDO;
use PDOStatement;

class Query
{

/* CREATE LIST OF COLUMNS
---------------------------------------------------------------------------- */

    /**
     *  @param  array<string, string|int|float|bool> $params List of columns and values
     *  @return string Coma separated list of column names.
     */

    public static function createColumns( array $params ) : string
    {
        return implode( separator: ', ', array: array_map(
            callback: fn( string $key ) => "`{$key}`",
               array: array_keys( $params )
        ));
    }



/* CREATE STRING OF COLUMN VALUE NAMES
---------------------------------------------------------------------------- */

    /**
     *  @param  array<string, string|int|float|bool> $params List of columns
     *  and values
     *  @return string
     */

    public static function createColumnValues( array $params ) : string
    {
        return implode( separator: ', ', array: array_map(
            callback: fn( string $key ) => ":{$key}",
               array: array_keys( $params )
        ));
    }



/* CREATE REPLACE INTO QUERY
---------------------------------------------------------------------------- */

    /**
     * @param  string  $table Name of DB table
     * @param  array<string, string|int|float|bool> $params
     * @return string Text of a REPLACE INTO statement.
     */

    public static function replaceInto( string $table, array $params ) : string
    {
        $columns = self::createColumns( params: $params );
        $values  = self::createColumnValues( params: $params );

        return trim( string: "
            REPLACE INTO {$table}
                ( {$columns} )
            VALUES
                ( {$values} )
        ");
    }



/* CREATE INSERT INTO QUERY
---------------------------------------------------------------------------- */

    /**
     * @param  string $table Name of DB table
     * @param  array<string, string|int|float|bool> $params
     * @return string Text of a INSERT INTO statement.
     */

    public static function insertInto( string $table, array $params ) : string
    {
        $columns = self::createColumns( params: $params );
        $values  = self::createColumnValues( params: $params );

        return trim( string: "
            INSERT INTO {$table}
                ( {$columns} )
            VALUES
                ( {$values} )
        ");
    }



/* BIND PARAMETERS
---------------------------------------------------------------------------- */

    /**
     *  @param  PDOStatement $query PDO query statement.
     *  @param  array<string, string|int|float|bool> $params Parameters.
     *  @return void
     */

    public static function bindParameters(
        PDOStatement &$query,
        array $params
    ) : void
    {
        foreach( $params as $key => $value )
        {
            $type = match( true ) {
                is_int( $value )  => PDO::PARAM_INT,
                is_bool( $value ) => PDO::PARAM_BOOL,
                default           => PDO::PARAM_STR,
            };

            $query->bindParam( param:  ":{$key}", var: $value, type: $type );
        }
    }


/* BIND VALUES
---------------------------------------------------------------------------- */

    /**
     *  @param  PDOStatement $query
     *  @param  array<string, string|int|float|bool> $params
     *  @return void
     */

    public static function bindValues(
        PDOStatement &$query,
        array $params
    ) : void
    {
        foreach( $params as $key => $value )
        {
            $type = match( true ) {
                is_int( $value )  => PDO::PARAM_INT,
                is_bool( $value ) => PDO::PARAM_BOOL,
                default           => PDO::PARAM_STR,
            };
            $query->bindValue( param: ":{$key}", value: $value, type: $type );
        }
    }



/* FILTER COLUMNS
---------------------------------------------------------------------------- */

    /**
     *  Take an array of parameters and filter out ones that are not allowed
     *
     *  @param  array<string, string|int|float|bool> $params List of parameters
     *  to send to DB
     *  @param  array<string> $allowed List of allowed parameters
     *  @return array<string, bool|string|int|float> List of filtered parameters
     */

    public static function filterColumns( array $params, array $allowed ) : array
    {
        return array_intersect_key( $params, array_flip( array: $allowed ));
    }

}