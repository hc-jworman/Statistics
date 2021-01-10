<?php

namespace JWorman\Statistics;

final class InverseTTable
{
    const RIGHT_TAILED_FILE = __DIR__ . '/../resources/right_tailed_inverse_t_table.csv';
    const TWO_TAILED_FILE = __DIR__ . '/../resources/two_tailed_inverse_t_table.csv';
    const SIGMA_TO_INDEX_MAP = [
        '0.5' => 1,
        '1' => 2,
        '1.5' => 3,
        '2' => 4,
        '2.5' => 5,
        '3' => 6,
        '3.5' => 7,
        '4' => 8,
        '4.5' => 9,
        '5' => 10,
    ];

    /**
     * @param bool $twoTailedOrRightTailed
     * @param int $df
     * @param string $sigma
     * @return float
     */
    public static function getTScore($twoTailedOrRightTailed, $df, $sigma)
    {
        $inverseTTableFile = $twoTailedOrRightTailed ? self::RIGHT_TAILED_FILE : self::TWO_TAILED_FILE;
        $csv = \array_map('str_getcsv', \file($inverseTTableFile));
        $map = self::SIGMA_TO_INDEX_MAP;
        return (float)$csv[$df - 1][$map[$sigma]];
    }
}
