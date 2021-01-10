<?php

namespace JWorman\Statistics\Tests;

use PHPUnit\Framework\TestCase;

use function JWorman\Statistics\mean;
use function JWorman\Statistics\standardDeviation;
use function JWorman\Statistics\variance;

use const JWorman\Statistics\POPULATION;
use const JWorman\Statistics\SAMPLE;

class StatisticsTest extends TestCase
{
    const INT_SAMPLE = [-16, -46, 100, 99, -13];
    const FLOAT_SAMPLE = [85.5945925643064, -7.53563844854945, -21.4031910838233, 34.3417313490613, -66.5000275780948];

    /**
     * @covers       \JWorman\Statistics\Statistics::mean
     * @dataProvider provideDataForTestMean
     * @param array $samples
     * @param float|int $expectedResult
     */
    public function testMean(array $samples, $expectedResult)
    {
        $result = mean($samples);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array[]
     */
    public function provideDataForTestMean()
    {
        return [
            [self::INT_SAMPLE, 24.8],
            [self::FLOAT_SAMPLE, 4.89949336058003],
        ];
    }

    /**
     * @covers       \JWorman\Statistics\Statistics::variance
     * @dataProvider provideDataForTestVariance
     * @param array $samples
     * @param string $type
     * @param float|int $expectedResult
     */
    public function testVariance(array $samples, $type, $expectedResult)
    {
        $result = variance($samples, $type);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array[]
     */
    public function provideDataForTestVariance()
    {
        return [
            [self::INT_SAMPLE, SAMPLE, 4816.7],
            [self::INT_SAMPLE, POPULATION, 3853.36],
            [self::FLOAT_SAMPLE, SAMPLE, 3330.72492890854],
            [self::FLOAT_SAMPLE, POPULATION, 2664.57994312683],
        ];
    }

    /**
     * @covers       \JWorman\Statistics\Statistics::standardDeviation
     * @dataProvider provideDataForTestStandardDeviation
     * @param array $samples
     * @param string $type
     * @param float|int $expectedResult
     */
    public function testStandardDeviation(array $samples, $type, $expectedResult)
    {
        $result = standardDeviation($samples, $type);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array[]
     */
    public function provideDataForTestStandardDeviation()
    {
        return [
            [self::INT_SAMPLE, SAMPLE, 69.4024495244944],
            [self::INT_SAMPLE, POPULATION, 62.075437976707],
            [self::FLOAT_SAMPLE, SAMPLE, 57.7124330530999],
            [self::FLOAT_SAMPLE, POPULATION, 51.6195693814549],
        ];
    }
}
