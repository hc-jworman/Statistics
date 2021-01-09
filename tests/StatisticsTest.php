<?php

namespace Statistics\Tests;

use PHPUnit\Framework\TestCase;
use Statistics\Statistics;

class StatisticsTest extends TestCase
{
    /**
     * @covers       \Statistics\Statistics::mean
     * @dataProvider provideDataForTestMean
     * @param array $samples
     * @param float|int $expectedResult
     */
    public function testMean(array $samples, $expectedResult)
    {
        $result = Statistics::mean($samples);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array[]
     */
    public function provideDataForTestMean()
    {
        return [
            [[1, 2, 3, 4, 5], 3],
            [[1.1, 2.1, 3.1, 4.1, 5.1], 3.1],
        ];
    }

    /**
     * @covers       \Statistics\Statistics::variance
     * @dataProvider provideDataForTestVariance
     * @param array $samples
     * @param string $type
     * @param float|int $expectedResult
     */
    public function testVariance(array $samples, $type, $expectedResult)
    {
        $result = Statistics::variance($samples, $type);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array[]
     */
    public function provideDataForTestVariance()
    {
        return [
            [[1, 2, 3, 4, 5], Statistics::TYPE_POPULATION, 2],
            [[1, 2, 3, 4, 5], Statistics::TYPE_SAMPLE, 2.5],
            [[1.1, 2.1, 3.1, 4.1, 5.1], Statistics::TYPE_POPULATION, 2],
            [[1.1, 2.1, 3.1, 4.1, 5.1], Statistics::TYPE_SAMPLE, 2.5],
        ];
    }

    /**
     * @covers       \Statistics\Statistics::standardDeviation
     * @dataProvider provideDataForTestStandardDeviation
     * @param array $samples
     * @param string $type
     * @param float|int $expectedResult
     */
    public function testStandardDeviation(array $samples, $type, $expectedResult)
    {
        $result = Statistics::standardDeviation($samples, $type);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array[]
     */
    public function provideDataForTestStandardDeviation()
    {
        return [
            [[1, 2, 3, 4, 5], Statistics::TYPE_POPULATION, \sqrt(2)],
            [[1, 2, 3, 4, 5], Statistics::TYPE_SAMPLE, \sqrt(2.5)],
            [[1.1, 2.1, 3.1, 4.1, 5.1], Statistics::TYPE_POPULATION, \sqrt(2)],
            [[1.1, 2.1, 3.1, 4.1, 5.1], Statistics::TYPE_SAMPLE, \sqrt(2.5)],
        ];
    }
}
