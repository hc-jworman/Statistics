<?php

namespace Statistics\Tests;

use PHPUnit\Framework\TestCase;
use Statistics\TTableCsvParser;

class TTableCsvParserTest extends TestCase
{
    /**
     * @covers       \Statistics\TTableCsvParser::getTScore
     * @dataProvider provideDataForTestGetTScore
     * @param string $type
     * @param int $df
     * @param string $sigma
     * @param float $expectedResult
     */
    public function testGetTScore($type, $df, $sigma, $expectedResult)
    {
        $result = TTableCsvParser::getTScore($type, $df, $sigma);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array[]
     */
    public function provideDataForTestGetTScore()
    {
        return [
            [TTableCsvParser::TWO_TAILED, 1, TTableCsvParser::SIGMA_3, 235.801497960467],
            [TTableCsvParser::TWO_TAILED, 99, TTableCsvParser::SIGMA_5, 5.3478501763224],
            [TTableCsvParser::RIGHT_TAILED, 23, TTableCsvParser::SIGMA_1, 1.4569245113396],
            [TTableCsvParser::RIGHT_TAILED, 568, TTableCsvParser::SIGMA_4, 4.194887596433],
        ];
    }
}
