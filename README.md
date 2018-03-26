# Bulk Inserter

_Note: This helper library is specific to the Laravel framework_

If you are stress-testing your new application to see how it will behave with a realistic future amount 
of data then you are probably writing a seeder which inserts thousands of rows.

Using PHP to insert rows individually may be slow and hampering development or even breaching prepared
statement limits.

This package helps you utilise MySQLs native dump import which is way quicker than doing lots of individual
inserts in a loop!

 
## Install

```bash
$ composer require nomensa/bulk-inserter
```


## Example

The following example will insert a thousand users in a few seconds.

```php
use Nomensa\BulkInserter;

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

If the above task was written using the Eloquent model's '::create()' method is could take 
up to a minute or even longer.

When dealing with thousands of rows in multiple tables you are probably going to be re-seed
many times so these time savings add up and make for a happier develop experience. 
