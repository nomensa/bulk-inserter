<?php

use PHPUnit\Framework\TestCase;

use Nomensa\BulkInserter\BulkInserter;
use Nomensa\BulkInserter\Exceptions\InvalidRowException;

class BulkInserterTest extends TestCase
{

    public function testMakeFirstBit()
    {
        $bulkInserter = new BulkInserter('users', [ 'name', 'shoe_size', 'email' ]);

        $this->assertEquals('INSERT INTO `users` (name,shoe_size,email) VALUES ' . PHP_EOL, $bulkInserter->makeFirstBit());
    }

    public function testMakeInsertBits()
    {
        $bulkInserter = new BulkInserter('users', [ 'name', 'shoe_size', 'email' ]);

        $bulkInserter->addRow('("Martin Joiner",12,"me@example.com")');

        $expected = 'INSERT INTO `users` (name,shoe_size,email) VALUES ' .
                    PHP_EOL .
                    '("Martin Joiner",12,"me@example.com");' .
                    PHP_EOL . PHP_EOL;

        $this->assertEquals($expected,$bulkInserter->makeInsertBits());
    }

    public function testMissingValueCausesInvalidRowException()
    {
        $this->expectException(InvalidRowException::class);
        $bulkInserter = new BulkInserter('table1', [ 'field1', 'field2', 'field3' ]);
        $bulkInserter->addRow('("Value 1",3)');
    }

    /**
     * This is to test that if the actual value contains a comma, that doesn't accidentally
     * trigger an Exception for thinking there are too many values
     */
    public function testTooManyCommasDoesNotCausesInvalidRowException()
    {
        $bulkInserter = new BulkInserter('table1', [ 'field1', 'field2', 'field3' ]);
        $bulkInserter->addRow('("Value 1, extra bit","Value 2",3)');

        $expected = 'INSERT INTO `table1` (field1,field2,field3) VALUES ' .
            PHP_EOL .
            '("Value 1, extra bit","Value 2",3);' .
            PHP_EOL . PHP_EOL;

        $this->assertEquals($expected,$bulkInserter->makeInsertBits());
    }

}
