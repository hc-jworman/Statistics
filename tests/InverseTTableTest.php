<?php

namespace JWorman\Statistics\Tests;

use JWorman\Statistics\InverseTTable;
use PHPUnit\Framework\TestCase;

use const JWorman\Statistics\RIGHT_TAILED;
use const JWorman\Statistics\TWO_TAILED;

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
        $result = InverseTTable::getTScore($type, $df, $sigma);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array[]
     */
    public function provideDataForTestGetTScore()
    {
        return [
            [TWO_TAILED, 1, '3', 235.801497960467],
            [TWO_TAILED, 99, '5', 5.3478501763224],
            [RIGHT_TAILED, 23, '1', 1.4569245113396],
            [RIGHT_TAILED, 568, '4', 4.194887596433],
        ];
    }
}
