<?php

namespace BASE\PHPUnit\Database;

use BASE\Database\MySQL;
use PHPUnit\Framework\TestCase;

/**
 * Class MySQLiTest
 */
class MySQLTest extends TestCase
{

    /**
     *
     */
    public function testGet()
    {
        if (!isset($_ENV['mysqli_host']) or
            !isset($_ENV['mysqli_username']) or
            !isset($_ENV['mysqli_password'])
        ) {
            $this->markTestSkipped(
                'MySQL Login data not set'
            );
        }

        $database = "";

        $obj1 = MySQL::get($database);
        $this->assertTrue(is_object($obj1));
        $this->assertTrue(is_a($obj1, "mysqli"));

        $obj2 = MySQL::get($database);
        $this->assertTrue(is_object($obj2));
        $this->assertTrue(is_a($obj2, "mysqli"));

        $this->assertTrue($obj1 === $obj2);
    }
}
