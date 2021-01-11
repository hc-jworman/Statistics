<?php

namespace JWorman\Statistics\Tests;

use JWorman\Statistics\InverseTTable;
use JWorman\Statistics\TTest;
use PHPUnit\Framework\TestCase;

final class InverseTTableTest extends TestCase
{
    /**
     * @covers       \JWorman\Statistics\TTableCsvParser::getTScore
     * @dataProvider provideDataForTestGetTScore
     * @param string $type
     * @param int $df
     * @param string $sigma
     * @param float $expectedResult
     */
    public function testGetTScore($type, $df, $sigma, $expectedResult)
    {
        $result = InverseTTable::getTCritical($type, $df, $sigma);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array[]
     */
    public function provideDataForTestGetTScore()
    {
        return [
            [TTest::TWO_TAIL, 1, '3', 235.801497960467],
            [TTest::TWO_TAIL, 99, '5', 5.3478501763224],
            [TTest::RIGHT_TAIL, 23, '1', 1.4569245113396],
            [TTest::LEFT_TAIL, 23, '1', -1.4569245113396],
            [TTest::RIGHT_TAIL, 568, '4', 4.194887596433],
        ];
    }
}
