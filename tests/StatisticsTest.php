<?php

namespace JWorman\Statistics\Tests;

use JWorman\Statistics\Exceptions\EmptySampleException;
use PHPUnit\Framework\TestCase;

use function JWorman\Statistics\mean;
use function JWorman\Statistics\standardDeviation;
use function JWorman\Statistics\twoSampleTTest;
use function JWorman\Statistics\variance;

use const JWorman\Statistics\POPULATION;

final class StatisticsTest extends TestCase
{
    const INT_SAMPLE = [-16, -46, 100, 99, -13];
    const FLOAT_SAMPLE = [85.5945925643064, -7.53563844854945, -21.4031910838233, 34.3417313490613, -66.5000275780948];

    /**
     * @covers \JWorman\Statistics\mean
     */
    public function testMean()
    {
        $this->assertEquals(24.8, mean(self::INT_SAMPLE));
        $this->assertEquals(4.89949336058003, mean(self::FLOAT_SAMPLE));

        $this->expectException(EmptySampleException::class);
        mean([]);
    }

    /**
     * @covers \JWorman\Statistics\variance
     */
    public function testVariance()
    {
        $this->assertEquals(4816.7, variance(self::INT_SAMPLE));
        $this->assertEquals(3853.36, variance(self::INT_SAMPLE, POPULATION));
        $this->assertEquals(3330.72492890854, variance(self::FLOAT_SAMPLE));
        $this->assertEquals(2664.57994312683, variance(self::FLOAT_SAMPLE, POPULATION));

        $this->expectException(EmptySampleException::class);
        variance([]);
    }

    /**
     * @covers \JWorman\Statistics\standardDeviation
     */
    public function testStandardDeviation()
    {
        $this->assertEquals(69.4024495244944, standardDeviation(self::INT_SAMPLE));
        $this->assertEquals(62.075437976707, standardDeviation(self::INT_SAMPLE, POPULATION));
        $this->assertEquals(57.7124330530999, standardDeviation(self::FLOAT_SAMPLE));
        $this->assertEquals(51.6195693814549, standardDeviation(self::FLOAT_SAMPLE, POPULATION));

        $this->expectException(EmptySampleException::class);
        standardDeviation([]);
    }

    /**
     * @covers \JWorman\Statistics\twoSampleTTest
     */
    public function testTwoSampleTTest()
    {
        $sample1 = [14, 15, 15, 15, 16, 18, 22, 23, 24, 25, 25];
        $sample2 = [10, 12, 14, 15, 18, 22, 24, 27, 31, 33, 34, 34, 34];
        $this->assertFalse(twoSampleTTest($sample1, $sample2));

        $sample1 = [0, 0, 0, 0, 0, 0, 0, 0, 1];
        $sample2 = [20, 20, 20, 20, 20, 20, 20, 21];
        $this->assertTrue(twoSampleTTest($sample1, $sample2));
    }
}
