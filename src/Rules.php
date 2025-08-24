<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB;


class Rules
{

/* INT COLUMN
---------------------------------------------------------------------------- */

    /**
     *  @param  int|string|float $input Data to inspect
     *  @return true|string
     */

    public static function is_INT( int|string|float $input ) : true|string
    {
        if( !filter_var( value: $input,  filter: FILTER_VALIDATE_INT )) {
            return "INT: Value '{$input}' is not an integer.";
        }

        return true;
    }



/* TINYINT COLUMN
---------------------------------------------------------------------------- */

    /**
     *  @param  int|string|float $input Data to inspect
     *  @param  bool $unsigned Use an unsigned Integer
     *  @return true|string
     */

    public static function is_TINYINT(
        int|string|float $input,
        bool $unsigned = false
    ) : true|string
    {

        if( !filter_var( value: $input, filter: FILTER_VALIDATE_INT )) {
            return "TINYINT: Value '{$input}' is not an integer.";
        }

        $input = (int)$input;
        if( $unsigned === true AND ( $input < 0 OR $input > 255 )) {
            return "TINYINT unsigned: Value '{$input}' is out of range.";
        }

        if( $unsigned === false AND ( $input < -128 OR $input > 127 )) {
            return "TINYINT signed: Value '{$input}' is out of range.";
        }

        return true;
    }



/* SMALL INT COLUMN
---------------------------------------------------------------------------- */

    /**
     *  @param  int|string|float $input Data to inspect
     *  @param  bool $unsigned Use an unsigned Integer
     *  @return true|string
     */

    public static function is_SMALLINT(
        int|string|float $input,
        bool $unsigned = false
    ) : true|string
    {
        if( !filter_var( value: $input, filter: FILTER_VALIDATE_INT )) {
            return "SMALLINT: Value {$input} is not an integer.";
        }

        $input = (int)$input;
        if( $unsigned === true AND ( $input < 0 OR $input > 255 )) {
            return "TINYINT unsigned: Value '{$input}' is out of range.";
        }

        if(  $unsigned === false AND ( $input < -32768 OR $input > 32767 )) {
            return "SMALLINT: Value '{$input}' is out of range for Medium Int.";
        }

        return true;
    }



/* MEDIUM INT COLUMN
---------------------------------------------------------------------------- */

    /**
     *  @param  int|string|float $input Data to inspect
     *  @param  bool $unsigned Use an unsigned Integer
     *  @return true|string
     */
    public static function is_MEDIUMINT(
        int|string|float $input,
        bool $unsigned = true
    ) : true|string
    {
        if( !filter_var( value: $input, filter: FILTER_VALIDATE_INT )) {
            return "MEDIUMINT: Value '{$input}' is not an integer.";
        }

        $input = (int)$input;
        if( $unsigned === true AND ( $input < 0 OR $input > 16777215 )) {
            return "MEDIUMINT unsigned: Value '{$input}' is out of range.";
        }

        if( $unsigned === false AND ( $input < -8388608 OR $input > 8388607 )) {
            return "MEDIUMINT: Value '{$input}' is out of range for Medium Int.";
        }

        return true;
    }



/* BIG INT COLUMN
---------------------------------------------------------------------------- */

    /**
     *  @param  int|string|float $input Data to inspect
     *  @return true|string
     */

    public static function is_BIGINT( int|string|float $input ) : true|string
    {
        if( !filter_var( value: $input, filter: FILTER_VALIDATE_INT )) {
            return "BIGINT: Value '{$input}' is not an integer.";
        }

        return true;
    }



/* DATE COLUMN
---------------------------------------------------------------------------- */

    /**
     *  @param  string $input Data to inspect
     *  @return true|string
     */

    public static function is_DATE( string $input ) : true|string
    {
        $regex = "#^(19|20)\d{2}-(0[1-9]|11|12)-(0[1-9]|[12]\d|3[01])$#";
        if( !preg_match( pattern: $regex, subject: $input )) {
            return "DATE: Value '{$input}' is not a valid date in format XXXX-XX-XX";
        }

        return true;
    }



/* TIME COLUMN
---------------------------------------------------------------------------- */

    /**
     *  @param  string $input Data to inspect
     *  @return true|string
     */

    public static function is_TIME( string $input ) : true|string
    {
        $regex = '#^-?([0-7]\d{1,2}|8[0-2]\d|83[0-8]):[0-5]\d:[0-5]\d$#';
        if( !preg_match( pattern: $regex, subject: $input )) {
            return "TIME: Value '{$input}' is not a valid time format.";
        }

        return true;
    }



/* TIMESTAMP COLUMN
---------------------------------------------------------------------------- */

    /**
     *  @param  string $input Data to inspect
     *  @return true|string
     */

    public static function is_TIMESTAMP( string $input ) : true|string
    {
        $d_regex = "(19|20)\d{2}-(0[1-9]|11|12)-(0[1-9]|[12]\d|3[01])";
        $t_regex = '([0-7]\d{1,2}|8[0-2]\d|83[0-8]):[0-5]\d:[0-5]\d(\.\d{1,6)?';
        if( !preg_match( pattern: "#^$d_regex $t_regex$#", subject: $input )) {
            return "TIMESTAMP: Value '{$input}' is not valid Timestamp.";
        }

        return true;
    }



/* CHAR COLUMN
---------------------------------------------------------------------------- */

    /**
     * @param string $input Data to inspect
     * @param int $length Length of string
     * @return true|string
     */

    public static function is_CHAR( string $input, int $length = 255 ) : true|string
    {
        if( strlen( string: $input ) > $length ) {
            return "CHAR: Value '{$input}' is too long for CHAR({$length}).";
        }

        return true;
    }



/* VARCHAR COLUMN
---------------------------------------------------------------------------- */

    /**
     * @param string $input Data to inspect
     * @param int $length Length of string
     * @return true|string
     */

    public static function is_VARCHAR( string $input, int $length = 255 ) : true|string
    {
        if( strlen( string: $input ) > $length ) {
            return "VARCHAR: Value '{$input}' is too long for VARCHAR({$length}).";
        }

        if( strlen( string: $input ) > 65535 ) {
            return "VARCHAR: Value is too long for a VARCHAR type. User MEDIUMTEXT";
        }

        return true;
    }



/* DECIMAL COLUMN
---------------------------------------------------------------------------- */

    /**
     *  @param  int|string|float $input Data to inspect
     *  @param  int $max Maximum digits
     *  @param  int $d Decimal places
     *  @return true|string
     */

    public static function is_DECIMAL( string|int|float $input, int $max, int $d ) : true|string
    {
        if( !is_numeric( value: $input )) {
            return "DECIMAL: Value '{$input}' is not a decimal format.";
        }

        $string = (string)$input;

        if( strlen( string: $string ) > ( $max + 1 )) {
            return "DECIMAL: Value '{$input}' Is longer than maximum( {$max} ).";
        }

        list( $whole, $fraction ) = explode( separator: '.', string: $string );
        if( strlen( string: $fraction ) > $d ) {
            return "DECIMAL: Value '{$input}' decimals are longer than {$d}.";
        }

        return true;
    }



/* FLOAT COLUMN
---------------------------------------------------------------------------- */

    /**
     *  @param  int|string|float $input Data to inspect
     *  @param  int $max Maximum digits
     *  @param  int $d Decimal places
     *  @return true|string
     */

    public static function is_FLOAT( string|int|float $input, int $max, int $d ) : true|string
    {
        if( !is_numeric( value: $input )) {
            return "FLOAT: Value '{$input}' is not a decimal format.";
        }

        $string = ltrim( string: (string)$input, characters: '-');

        if( strlen( string: $string ) > ( $max + 1 )) {
            return "FLOAT: Value '{$input}' Is longer than maximum( {$max} ).";
        }

        list( $whole, $fraction ) = explode( separator: '.', string: $string );
        if( strlen( string: $fraction ) > $d ) {
            return "FLOAT: Value '{$input}' decimals are longer than {$d}.";
        }

        return true;
    }



/* TEXT COLUMN
---------------------------------------------------------------------------- */

    /**
     *  @param  string $input Data to inspect
     *  @return true|string
     */

    public static function is_TEXT( string $input ) : true|string
    {
        if( strlen( string: $input ) > 65535 ) {
            return "TEXT: Value for text field is over 65,535 characters.";
        }

        return true;
    }



/* TINYTEXT COLUMN
---------------------------------------------------------------------------- */

    /**
     *  @param  string $input Data to inspect
     *  @return true|string
     */

    public static function is_TINYTEXT( string $input ) : true|string
    {
        if( strlen( string: $input ) > 255 ) {
            return "TINYTEXT: Value for text field is over 255 characters.";
        }

        return true;
    }
}