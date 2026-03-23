# EasyDB

## About

EasyDB is a simple lightweight PDO wrapper for creating a quick database handler using environment variables.

EasyDB uses a prefix system so that you can add a DB handler with a single string parameter. That prefix tells EasyDB which environment parameters to load. So your code will look very short, easy, and readable.


## Requirements

This plugin was designed for PHP 8.2 or above.

## Installation

```
composer require Ocolin\Easy-db
```

## Usage

### Quick connection from environment variables

#### Explanation 

The key feature to this tool is the prefix. You provide a prefix string which will be used to find the needed environment variables that start with that prefix name.
This saves you from having to specify the parameters needed and also allow you to have multiple handlers distinguished by prefix name.

Here are the environment variables that get loaded. In this example, the prefix is "PREFIX":

- PREFIX_DB_HOST
- PREFIX_DB_NAME
- PREFIX_DB_USER
- PREFIX_DB_PASS

#### Code example:

```php
// Setting up variables manually for visual purposes
$_ENV['PREFIX_DB_HOST'] = 'localhost';
$_ENV['PREFIX_DB_NAME'] = 'mydb';
$_ENV['PREFIX_DB_USER'] = 'admin';
$_ENV['PREFIX_DB_PASS'] = 'password1234';

$prefix_db = Ocolin\EasyDB\DB::fromEnv( prefix: 'PREFIX' );
```
If you don't have a means of loading environment variables or want to use this as a stand alone, you can specify a file with your environment variables:

```php
/*
 * Contents of .env file:
 * MYDATA_DB_HOST=localhost
 * MYDATA_DB_NAME=mydb
 * MYDATA_DB_USER=admin
 * MYDATA_DB_PASS=password1234
 */

$prefix_db = Ocolin\EasyDB\DB::fromEnv( 
    prefix: 'MYDATA', files: __DIR__ . '/../.env' 
);
```

### Direct connection

EasyDB also has a direct connection function for use without environment variables.

```php

$pdo_handler = Ocolin\EasyDB\DB::connect(
    host: 'localhost',
    name: 'mydb',
    user: 'admin',
    pass: 'password1234'
);
```

NOTE: the host parameter defaults to 'localhost', so it can be skipped when working on localhost.

### Options

By default EasyDB sets the following PDO options:

- PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
- PDO::ATTR_STRINGIFY_FETCHES => FALSE
- PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC

The options argument takes an array of options. These can override the defaults or ad additional options. Please see the PDO manual for which options and their settings are valid.

## Query

An additional helper library is added to assist with building some of the more basic SQL queries.

### createColumns

This function takes an array of database column names and create a coma separated string that can be used in an SQL query to specify columns to return in a SELECT query.

```php
$output = Ocolin\EasyDB\Query::createColumns( params: [ 'A' => '1', 'B' => '2', 'C' => '3'] );
// output: `A`, `B`, `C`
```

### createColumnValues

This function takes an associative array and builds a coma separated variable names for an INSERT type os query.

```php
$output = Ocolin\EasyDB\Query::createColumnValues( params: [ 'A' => '1', 'B' => '2', 'C' => '3']);
// output: ":A, :B, :C"
```

### replaceInto

Using the previous two functions we can create an SQL REPLACE INTO query providing just an array.

```php
$output = Ocolin\EasyDB\Query::replaceInto( 
    table: 'mytable', params: [ 'A' => '1', 'B' => '2', 'C' => '3' ] 
);
/*
    REPLACE INTO mytable
        ( `A`, `B`, `C` )
    VALUES
        ( :A, :B, :C )
 */
```

### bindParameters

This function allows you to bind data to your PDO query parameters. It requires a pointer to your PDO statement handler, and an array of your data.

```php
Ocolin\EasyDB\Query::bindParameters( query: $pdo_statement, params: [ 'A' => '1', 'B' => '2', 'C' => '3' ] );
```
Used in conjunction with a function like replaceInto(), it will bind those array values to the matching parameter names in your PDO query statement.

### bindValues

This is similar to bind parameters but does so with values. 

```php
Ocolin\EasyDB\Query::bindValues( query: $pdo_statement, params: [ 'A' => '1', 'B' => '2', 'C' => '3' ] );
```
### filterColumns

This function is helpful when you have more data than you want to update. Perhaps you have an array with data that you don't want to overwrite such as the column index of the table. This basic function will strip out the columns that are not allowed.

```php
$newparams = Ocolin\EasyDB\Query::filterColumns(
    params: [ 'A' => '1', 'B' => '2', 'C' => '3' ],
    allowed: [ 'A', 'B', 'D' ]
)

// $newparams = [ 'A' => '1', 'B' => '2' ]

$output = Ocolin\EasyDB\Query::replaceInto( 
    table: 'mytable', params: $newparams
);
```

## Validate

Another utility provided is a series of static functions for validating data being sent to the database. There is a function for each COLUMN data type and each function is named in format of "is" + the column type name.

The function will respond with TRUE if the data is valid, or an error string explaining why it is not valid. Here is a list of helper functions:

|Function| Arguments             | Argument Types |
|--------|-----------------------|----------------|
|isINT| input,unsigned        | mixed,bool     |
|isTINYINT| input,unsigned        | mixed,bool     |
|isSMALLINT| input,unsigned        | mixed,bool     |
|isMEDIUMINT| input,unsigned        | mixed,bool     |
|isBIGINT| input,unsigned        | mixed,bool     |
|isBOOLEAN| input | mixed  |
|isDECIMAL| input,precision,scale | mixed,int,int  |
|isFLOAT| input,precision,scale | mixed,int,int  |
|isCHAR| input,length          | mixed,int      |
|isVARCHAR| input,length          | mixed,int      |
|isTINYTEXT| input                 | mixed          |
|isTEXT| input                 | mixed          |
|isMEDIUMTEXT| input                 | mixed          |
|isLONGTEXT| input                 | mixed          |
|isENUM| input,allowed| mixed,array    |
|isDATE| input                 | mixed          |
|isTIME| input                 | mixed          |
|isTIMESTAMP| input                 | mixed          |
|isDATETIME| input                 | mixed          |
|isYEAR| input                 | mixed          |

### Example:

```php
$output = Ocolin\EasyDB\Validate::isCHAR( input: ['A'] );
// "CHAR: Input must be a string, got array."

$output = Ocolin\EasyDB\Validate::isCHAR( input: 'A' );
// TRUE
```



