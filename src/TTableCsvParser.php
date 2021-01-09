<?php

namespace Statistics;

class TTableCsvParser
{
    const RIGHT_TAILED = 'right_tailed';
    const TWO_TAILED = 'two_tailed';
    const INVERSE_T_TABLE_FILE_MAP = [
        self::RIGHT_TAILED => __DIR__ . '/../resources/right_tailed_inverse_t_table.csv',
        self::TWO_TAILED => __DIR__ . '/../resources/two_tailed_inverse_t_table.csv',
    ];

    const SIGMA_0_5 = '0.5';
    const SIGMA_1 = '1';
    const SIGMA_1_5 = '1.5';
    const SIGMA_2 = '2';
    const SIGMA_2_5 = '2.5';
    const SIGMA_3 = '3';
    const SIGMA_3_5 = '3.5';
    const SIGMA_4 = '4';
    const SIGMA_4_5 = '4.5';
    const SIGMA_5 = '5';
    const SIGMA_INDEX_MAP = [
        self::SIGMA_0_5 => 1,
        self::SIGMA_1 => 2,
        self::SIGMA_1_5 => 3,
        self::SIGMA_2 => 4,
        self::SIGMA_2_5 => 5,
        self::SIGMA_3 => 6,
        self::SIGMA_3_5 => 7,
        self::SIGMA_4 => 8,
        self::SIGMA_4_5 => 9,
        self::SIGMA_5 => 10,
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
        return (float)$csv[$df - 1][self::getSigmaIndex($sigma)];
    }

    /**
     * @param string $type
     * @return string
     */
    private static function getInverseTTableFile($type)
    {
        $map = TTableCsvParser::INVERSE_T_TABLE_FILE_MAP;
        if (isset($map[$type])) {
            return self::INVERSE_T_TABLE_FILE_MAP[$type];
        }
        throw new \InvalidArgumentException();
    }

    /**
     * @param string $sigma
     * @return int
     */
    private static function getSigmaIndex($sigma)
    {
        switch ($sigma) {
            case '0.5':
                return 1;
            case '1':
                return 2;
            case '1.5':
                return 3;
            case '2':
                return 4;
            case '2.5':
                return 5;
            case '3':
                return 6;
            case '3.5':
                return 7;
            case '4':
                return 8;
            case '4.5':
                return 9;
            case '5':
                return 10;
            default:
                throw new \InvalidArgumentException();
        }
    }
}
