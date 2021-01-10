<?php

namespace JWorman\Statistics;

class InverseTTable
{
    const RIGHT_TAILED = 'right_tailed';
    const TWO_TAILED = 'two_tailed';
    const INVERSE_T_TABLE_FILE_MAP = [
        self::RIGHT_TAILED => __DIR__ . '/../resources/right_tailed_inverse_t_table.csv',
        self::TWO_TAILED => __DIR__ . '/../resources/two_tailed_inverse_t_table.csv',
    ];
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
     * @param string $type
     * @param int $df
     * @param string $sigma
     * @return float
     */
    public static function getTScore($type, $df, $sigma)
    {
        $inverseTTableFile = self::getInverseTTableFile($type);
        $csv = \array_map('str_getcsv', \file($inverseTTableFile));
        $map = self::SIGMA_TO_INDEX_MAP;
        return (float)$csv[$df - 1][$map[$sigma]];
    }

    /**
     * @param string $type
     * @return string
     */
    private static function getInverseTTableFile($type)
    {
        $map = InverseTTable::INVERSE_T_TABLE_FILE_MAP;
        if (isset($map[$type])) {
            return self::INVERSE_T_TABLE_FILE_MAP[$type];
        }
        throw new \InvalidArgumentException();
    }
}
