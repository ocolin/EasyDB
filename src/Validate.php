<?php

declare( strict_types = 1 );

namespace Ocolin\EasyDB;

use DateTime;

class Validate
{

/* INT COLUMN
---------------------------------------------------------------------------- */

    /**
     *  @param mixed $input Data to validate.
     *  @return true|string Error message or true.
     */

    public static function isINT( mixed $input, bool $unsigned = false ) : true|string
    {
        if( filter_var( value: $input,  filter: FILTER_VALIDATE_INT ) === false ) {
            return "INT: Value is not an integer.";
        }

        /** @phpstan-ignore-next-line - filter_var INT check guarantees safe cast */
        $input = (int)$input;
        if( $unsigned === true AND ( $input < 0 OR $input > 4294967295 )) {
            return "INT unsigned: Value '{$input}' is out of range.";
        }

        if( $unsigned === false AND ( $input < -2147483648 OR $input > 2147483647 )) {
            return "INT signed: Value '{$input}' is out of range.";
        }

        return true;
    }



/* TINYINT COLUMN
---------------------------------------------------------------------------- */

    /**
     *  @param mixed $input Data to validate.
     *  @param bool $unsigned Use an unsigned Integer.
     *  @return true|string Error message or true.
     */

    public static function isTINYINT(
        mixed $input,
         bool $unsigned = false
    ) : true|string
    {

        if(
            filter_var( value: $input, filter: FILTER_VALIDATE_INT ) === false
        ) { return "TINYINT: Value is not an integer."; }

        /** @phpstan-ignore-next-line - filter_var INT check guarantees safe cast */
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
     *  @param mixed $input Data to validate.
     *  @param bool $unsigned Use an unsigned Integer
     *  @return true|string Error message or true.
     */

    public static function isSMALLINT(
        mixed $input,
         bool $unsigned = false
    ) : true|string
    {
        if(
            filter_var( value: $input, filter: FILTER_VALIDATE_INT ) === false
        ) { return "SMALLINT: Value is not an integer."; }

        /** @phpstan-ignore-next-line - filter_var INT check guarantees safe cast */
        $input = (int)$input;
        if( $unsigned === true AND ( $input < 0 OR $input > 65535 )) {
            return "SMALLINT unsigned: Value '{$input}' is out of range.";
        }

        if(  $unsigned === false AND ( $input < -32768 OR $input > 32767 )) {
            return "SMALLINT signed: Value '{$input}' is out of range.";
        }

        return true;
    }



/* MEDIUM INT COLUMN
---------------------------------------------------------------------------- */

    /**
     *  @param mixed $input Data to validate.
     *  @param bool $unsigned Use an unsigned Integer.
     *  @return true|string Error message or true.
     */
    public static function isMEDIUMINT(
        mixed $input,
         bool $unsigned = false
    ) : true|string
    {
        if(
            filter_var( value: $input, filter: FILTER_VALIDATE_INT ) === false
        ) { return "MEDIUMINT: Value is not an integer."; }

        /** @phpstan-ignore-next-line - filter_var INT check guarantees safe cast */
        $input = (int)$input;
        if( $unsigned === true AND ( $input < 0 OR $input > 16777215 )) {
            return "MEDIUMINT unsigned: Value '{$input}' is out of range.";
        }

        if( $unsigned === false AND ( $input < -8388608 OR $input > 8388607 )) {
            return "MEDIUMINT signed: Value '{$input}' is out of range.";
        }

        return true;
    }



/* BIG INT COLUMN
---------------------------------------------------------------------------- */

    /**
     * @param mixed $input Data to validate.
     * @param bool $unsigned Specify if integer is unsigned.
     * @return true|string Error message or true.
     */

    public static function isBIGINT(
        mixed $input,
         bool $unsigned = false
    ) : true|string
    {
        if( filter_var( value: $input, filter: FILTER_VALIDATE_INT ) === false ) {
            return "BIGINT: Value is not an integer.";
        }

        return true;
    }



/* BOOLEAN COLUMN (TINYINT(0)
---------------------------------------------------------------------------- */

    /**
     * @param mixed $input Input to validate.
     * @return string|true Error message or true.
     */

    public static function isBOOLEAN( mixed $input ) : string|true
    {
        if( !is_bool( $input ) && !in_array( $input, [0, 1], strict: true )) {
            return "BOOLEAN: Value is not a valid boolean.";
        }
        return true;
    }



/* DECIMAL COLUMN
---------------------------------------------------------------------------- */

    /**
     *  @param mixed $input Data to validate.
     *  @param int $precision Maximum digits.
     *  @param int $scale Decimal places.
     *  @return true|string Error message or true.
     */

    public static function isDECIMAL(
        mixed $input,
          int $precision,
          int $scale
    ) : true|string
    {
        if( is_numeric( value: $input ) === false ) {
            return "DECIMAL: Value is not a decimal format.";
        }

        if( str_contains( haystack: (string)$input, needle: 'e' )
            OR str_contains( haystack: (string)$input, needle: 'E' )) {
            return "DECIMAL: Scientific notation is not valid for DECIMAL columns.";
        }

        $string = ltrim( string: (string)$input, characters: '-' );
        $parts  = explode( separator: '.', string: $string );
        $whole  = $parts[0];
        $fraction = $parts[1] ?? '';

        if( strlen( $whole ) > ( $precision - $scale ) ) {
            return "DECIMAL: Whole part exceeds {$precision} total digits with {$scale} decimal places.";
        }
        if( strlen( $fraction ) > $scale ) {
            return "DECIMAL: Value '{$input}' has more than {$scale} decimal places.";
        }

        return true;
    }



/* FLOAT COLUMN
---------------------------------------------------------------------------- */

    /**
     *  @param mixed $input Data to validate.
     *  @param int $precision Maximum digits.
     *  @param int $scale Decimal places.
     *  @return true|string Error message or true.
     */

    public static function isFLOAT(
        mixed $input,
          int $precision,
          int $scale
    ) : true|string
    {
        if( is_numeric( value: $input ) ===  false ) {
            return "FLOAT: Value is not a float format.";
        }

        $string = ltrim( string: (string)$input, characters: '-');
        $parts    = explode( separator: '.', string: $string );
        $whole    = $parts[0];
        $fraction = $parts[1] ?? '';

        if( strlen( $whole ) > ( $precision - $scale )) {
            return "FLOAT: Whole part exceeds {$precision} total digits with {$scale} decimal places.";
        }
        if( strlen( $fraction ) > $scale ) {
            return "FLOAT: Value '{$input}' has more than {$scale} decimal places.";
        }

        return true;
    }



/* CHAR COLUMN
---------------------------------------------------------------------------- */

    /**
     * @param mixed $input Data to validate.
     * @param int $length Length of string
     * @return true|string Error message or true.
     */

    public static function isCHAR( mixed $input, int $length = 255 ) : true|string
    {
        if( !is_string( $input ) && !is_int( $input ) && !is_float( $input )) {
            return "CHAR: Input must be a string, got " . gettype( $input ) . ".";
        }

        $input = (string)$input;
        if( strlen( string: $input ) > $length ) {
            return "CHAR: Value is too long for CHAR({$length}). Got " . strlen($input) . " characters.";
        }

        return true;
    }



/* VARCHAR COLUMN
---------------------------------------------------------------------------- */

    /**
     * @param mixed $input Data to validate.
     * @param int $length Length of string.
     * @return true|string Error message or true.
     */

    public static function isVARCHAR( mixed $input, int $length = 255 ) : true|string
    {
        if( !is_string( $input ) && !is_int( $input ) && !is_float( $input )) {
            return "VARCHAR: Input must be a string, got " . gettype( $input ) . ".";
        }
        $input = (string)$input;

        if( strlen( string: $input ) > 65535 ) {
            return "VARCHAR: Value exceeds maximum VARCHAR size of 65,535 characters. Got "
                . strlen( $input ) . " characters.";
        }

        if( strlen( string: $input ) > $length ) {
            return "VARCHAR: Value '{$input}' is too long for VARCHAR({$length}). ";
        }

        return true;
    }



/* TINYTEXT COLUMN
---------------------------------------------------------------------------- */

    /**
     *  @param mixed $input Data to validate.
     *  @return true|string Error message or true.
     */

    public static function isTINYTEXT( mixed $input ) : true|string
    {
        if( !is_string( $input ) && !is_int( $input ) && !is_float( $input )) {
            return "TINYTEXT: Input must be a string, got " . gettype( $input ) . ".";
        }

        $input = (string)$input;
        if( strlen( string: $input ) > 255 ) {
            return "TINYTEXT: Value exceeds maximum TEXT size of 255 characters. Got "
                . strlen( $input ) . " characters.";
        }

        return true;
    }



/* TEXT COLUMN
---------------------------------------------------------------------------- */

    /**
     *  @param mixed $input Data to validate.
     *  @return true|string Error message or true.
     */

    public static function isTEXT( mixed $input ) : true|string
    {
        if( !is_string( $input ) && !is_int( $input ) && !is_float( $input )) {
            return "TEXT: Input must be a string, got " . gettype( $input ) . ".";
        }

        $input = (string)$input;
        if( strlen( string: $input ) > 65535 ) {
            return "TEXT: Value exceeds maximum TEXT size of 65,535 characters. Got "
                . strlen( $input ) . " characters.";
        }

        return true;
    }



/* MEDIUMTEXT COLUMN
---------------------------------------------------------------------------- */

    /**
     *  @param mixed $input Data to validate.
     *  @return true|string Error message or true.
     */

    public static function isMEDIUMTEXT( mixed $input ) : true|string
    {
        if( !is_string( $input ) && !is_int( $input ) && !is_float( $input )) {
            return "MEDIUMTEXT: Input must be a string, got " . gettype( $input ) . ".";
        }

        $input = (string)$input;
        if( strlen( string: $input ) > 16777215 ) {
            return "MEDIUMTEXT: Value exceeds maximum MEDIUMTEXT size of 16,777,215 characters. Got "
                . strlen( $input ) . " characters.";
        }

        return true;
    }



/* LONGTEXT COLUMN
---------------------------------------------------------------------------- */

    /**
     *  @param mixed $input Data to validate.
     *  @return true|string Error message or true.
     */

    public static function isLONGTEXT( mixed $input ) : true|string
    {
        if( !is_string( $input ) && !is_int( $input ) && !is_float( $input )) {
            return "LONGTEXT: Input must be a string, got " . gettype( $input ) . ".";
        }

        $input = (string)$input;
        if( strlen( string: $input ) > 4294967295 ) {
            return "LONGTEXT: Value exceeds maximum LONGTEXT size of 4,294,967,295 characters. Got "
                . strlen( $input ) . " characters.";
        }

        return true;
    }



/* ENUM COLUMN
---------------------------------------------------------------------------- */

    /**
     * @param mixed $input Value to validate.
     * @param array<string> $allowed List of values from the DB ENUM column.
     * @return true|string Error message or true.
     */

    public static function isENUM( mixed $input, array $allowed ) : true|string
    {
        if( !is_string( $input )) {
            return "ENUM: Input must be a string, got " . gettype( $input ) . ".";
        }

        if( !in_array( needle: $input, haystack: $allowed, strict: true ) ) {
            return "ENUM: Value '{$input}' is not in the list of allowed values.";
        }

        return true;
    }



/* DATE COLUMN
---------------------------------------------------------------------------- */

    /**
     *  @param mixed $input Data to validate.
     *  @return true|string Error message or true.
     */

    public static function isDATE( mixed $input ) : true|string
    {
        if( !is_string( $input )) {
            return "DATE: Input must be a string, got " . gettype( $input ) . ".";
        }

        $date = DateTime::createFromFormat( '!Y-m-d', $input );
        if( $date === false OR $date->format( format: 'Y-m-d' ) !== $input ) {
            return "DATE: Value '{$input}' is not a valid date in format YYYY-MM-DD.";
        }

        return true;
    }



/* TIME COLUMN
---------------------------------------------------------------------------- */

    /**
     *  @param mixed $input Data to validate.
     *  @return true|string Error message or true.
     */

    public static function isTIME( mixed $input ) : true|string
    {
        if( !is_string( $input )) {
            return "TIME: Input must be a string, got " . gettype( $input ) . ".";
        }

        $regex = '#^-?([0-7]\d{1,2}|8[0-2]\d|83[0-8]):[0-5]\d:[0-5]\d$#';
        if( !preg_match( pattern: $regex, subject: $input )) {
            return "TIME: Value '{$input}' is not a valid time format.";
        }

        return true;
    }



/* TIMESTAMP COLUMN
---------------------------------------------------------------------------- */

    /**
     *  @param mixed $input Data to validate.
     *  @return true|string Error message or true.
     */

    public static function isTIMESTAMP( mixed $input ) : true|string
    {
        if( !is_string( $input )) {
            return "TIMESTAMP: Input must be a string, got " . gettype( $input ) . ".";
        }

        $timestamp = DateTime::createFromFormat( '!Y-m-d H:i:s.u', $input )
            ?: DateTime::createFromFormat( '!Y-m-d H:i:s', $input );

        $valid = $timestamp !== false && (
                $timestamp->format( format: 'Y-m-d H:i:s.u' ) === $input ||
                $timestamp->format( format: 'Y-m-d H:i:s' )   === $input
            );

        if( $timestamp === false OR !$valid ) {
            return "TIMESTAMP: Value '{$input}' is not a valid timestamp in format YYYY-MM-DD HH:MM:SS.";
        }

        $min = new DateTime( datetime: '1970-01-01 00:00:01' );
        $max = new DateTime( datetime: '2038-01-19 03:14:07' );
        if( $timestamp < $min OR $timestamp > $max ) {
            return "TIMESTAMP: Value '{$input}' is out of the valid TIMESTAMP range.";
        }

        return true;
    }



/* DATETIME COLUMN
---------------------------------------------------------------------------- */

    /**
     *  @param mixed $input Data to validate.
     *  @return true|string Error message or true.
     */

    public static function isDATETIME( mixed $input ) : true|string
    {
        if( !is_string( $input )) {
            return "DATETIME: Input must be a string, got " . gettype( $input ) . ".";
        }

        $datetime = DateTime::createFromFormat( '!Y-m-d H:i:s', $input );
        if( $datetime === false OR $datetime->format( format: 'Y-m-d H:i:s' ) !== $input ) {
            return "DATETIME: Value '{$input}' is not a valid datetime in format YYYY-MM-DD HH:MM:SS.";
        }

        $min = new DateTime( datetime: '1000-01-01 00:00:00' );
        $max = new DateTime( datetime: '9999-12-31 23:59:59' );
        if( $datetime < $min OR $datetime > $max ) {
            return "DATETIME: Value '{$input}' is out of the valid DATETIME range.";
        }

        return true;
    }



/* YEAR COLUMN
---------------------------------------------------------------------------- */

    /**
     * @param mixed $input Value to validate.
     * @return string|true Error message or true.
     */
    public static function isYEAR( mixed $input ) : string|true
    {
        if( filter_var( value: $input,  filter: FILTER_VALIDATE_INT ) === false ) {
            return "YEAR: Value is not an integer format.";
        }

        /** @phpstan-ignore-next-line - filter_var INT check guarantees safe cast */
        $input = (int)$input;
        if( $input < 1901 OR $input > 2155 ) {
            return "YEAR: Value '{$input}' is not a valid year. Must be from 1901 to 2155.";
        }

        return true;
    }
}