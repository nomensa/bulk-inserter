# Bulk Inserter

_Note: This helper library is specific to the Laravel framework_

If you are stress-testing your new application to see how it will behave with a realistic 
future amount of data then you are probably writing a seeder which inserts thousands of rows.

Using many individual queries in PHP to insert rows one-by-one may be slow and 
hampering development or even breaching prepared statement limits.

This package utilises MySQLs native dump import so you can prepare the data inside your loop 
and then plonk the whole lot in the database with 1 speedy operation which is way quicker 
than doing lots of individual inserts!

 
## Install

```bash
$ composer require --dev -- nomensa/bulk-inserter
```

_Note: Please install as a dev requirement only._


## Example

The following example will insert a thousand users in a couple of seconds:

```php
use Nomensa\BulkInserter\BulkInserter;

class ExampleSeeder
{

    public function run()
    {
        $bulkInserter = new BulkInserter('users',['name','email']);
        
        for ($i = 0; $i < 1000; $i++) {
            $bulkInserter->addRow( '("User ' . $i . '","user' . $i . '@example.com")' );
        }
        
        $bulkInserter->insert();
    }

}
```

If the above task was written using the Eloquent model's '::create()' method it could take
 ~20 seconds. 

Multiply this delay across all your model's tables, factor in how many times you will tweak 
and re-run your seeder during test writing and the time savings add. Using this package makes 
for a much happier developer experience. 


## Friendly reminder about exposing vulnerabilities!

This package executes raw MySQL code in your database. DO NOT use this package in a production 
environment and certainly NEVER populate the content of the rows via inputs from a request. 

This package is for use during development and testing, not everyday application logic.
