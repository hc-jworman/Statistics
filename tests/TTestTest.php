<?php

namespace JWorman\Statistics\Tests;

use JWorman\Statistics\TTest;
use PHPUnit\Framework\TestCase;

class TTestTest extends TestCase
{
    /**
     * @covers \JWorman\Statistics\TTest::oneSample
     */
    public function testOneSample()
    {
        $sample1 = [14, 15, 15, 15, 16, 18, 22, 23, 24, 25, 25];
        $this->assertTrue(TTest::oneSample($sample1));

        $sample1 = [0, 0, 0, 0, 0, 0, 0, 0, 1];
        $this->assertFalse(TTest::oneSample($sample1));
    }

    /**
     * @covers \JWorman\Statistics\TTest::twoSample
     */
    public function testTwoSample()
    {
        $sample1 = [14, 15, 15, 15, 16, 18, 22, 23, 24, 25, 25];
        $sample2 = [10, 12, 14, 15, 18, 22, 24, 27, 31, 33, 34, 34, 34];
        $this->assertFalse(TTest::twoSample($sample1, $sample2));

        $sample1 = [0, 0, 0, 0, 0, 0, 0, 0, 1];
        $sample2 = [20, 20, 20, 20, 20, 20, 20, 21];
        $this->assertTrue(TTest::twoSample($sample1, $sample2));
    }
}
