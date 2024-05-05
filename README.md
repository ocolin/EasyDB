# Database

## About

This is a very simple library with a lot of default configuration. It was built for custom purposes. Because of the many hard-set configuration settings it is not ideal for general use.Here are some of those:

- Uses MySQL
- Uses PDO
- Does not stringify values
- Runs in exception mode

Meant as a customer fast/lightweight handler for throwing into scripts that don't need customization

## Environment

Handler does have a function for directly inputting DB configuration. However it was made for reading DB credentials from environment variables.

By default, it will look for existing environment variables. But, if local is set to true, it will load environment variables from a local .env file. This is useful in cases where this library is cloned instead of used as a composer plugin. If you have many projects including this library you can maintain a single set of DB credentials.

## Example: envDbHandler

    $db = DB::envDbHandler( prefix: 'MYDATA' );

In this example environment variables will need to be named as:
- MYDATA_DB_HOST
- MYDATA_DB_NAME
- MYDATA_DB_USER
- MYDATA_DB_PASS

## Example: localHandler

    $db = DB::localHandler( prefix: 'MYDATA' );

In this example environment variables will need to be named as:
- MYDATA_DB_NAME
- MYDATA_DB_USER
- MYDATA_DB_PASS