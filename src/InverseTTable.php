<?php

namespace JWorman\Statistics;

use JWorman\Statistics\Exceptions\InvalidTailException;

final class InverseTTable
{
    const ONE_TAIL_FILE = __DIR__ . '/../resources/one_tail_inverse_t_table.csv';
    const TWO_TAIL_FILE = __DIR__ . '/../resources/two_tail_inverse_t_table.csv';
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
     * @param string $tail
     * @param int $df
     * @param string $sigma
     * @return float
     */
    public static function getTCritical($tail, $df, $sigma)
    {
        if ($df > 1000) {
            $df = 1000;
        }
        if ($tail === TTest::TWO_TAIL) {
            $inverseTTableFile = self::TWO_TAIL_FILE;
            $csv = \array_map('str_getcsv', \file($inverseTTableFile));
            return (float)$csv[$df - 1][self::getSigmaIndex($sigma)];
        } elseif ($tail === TTest::LEFT_TAIL) {
            $inverseTTableFile = self::ONE_TAIL_FILE;
            $csv = \array_map('str_getcsv', \file($inverseTTableFile));
            return -(float)$csv[$df - 1][self::getSigmaIndex($sigma)];
        } elseif ($tail === TTest::RIGHT_TAIL) {
            $inverseTTableFile = self::ONE_TAIL_FILE;
            $csv = \array_map('str_getcsv', \file($inverseTTableFile));
            return (float)$csv[$df - 1][self::getSigmaIndex($sigma)];
        } else {
            throw new InvalidTailException($tail);
        }
    }

    private static function getSigmaIndex($sigma)
    {
        $map = self::SIGMA_TO_INDEX_MAP;
        if (isset($map[$sigma])) {
            return $map[$sigma];
        }
        throw new \InvalidArgumentException(
            \sprintf(
                'Invalid sigma. You may only use the following: %s',
                \implode(', ', \array_keys(self::SIGMA_TO_INDEX_MAP))
            )
        );
    }
}
