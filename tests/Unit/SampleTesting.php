<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class SampleTesting extends TestCase
{
    /**
    * A basic unit test for testing simple sum process.
    *
    * @return void
    */
    public function test_sum()
    {
        $value1 = 10;
        $value2 = 20;
        
        $result = $value1 + $value2;
        assertEquals(30, $result);
        
    }
}
