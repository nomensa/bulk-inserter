<?php

use PHPUnit\Framework\TestCase;

use Nomensa\BulkInserter\BulkInserter;

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

}
