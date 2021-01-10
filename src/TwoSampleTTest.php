<?php

namespace JWorman\Statistics;

class TwoSampleTTest
{
    const TWO_TAILED = 'two_tailed';
    const RIGHT_TAILED = 'right_tailed';

    /**
     * @param array $sample1
     * @param array $sample2
     * @param string $type
     * @param int $significance
     * @return bool
     */
    public static function test(array $sample1, array $sample2, $type = self::TWO_TAILED, $significance = 3)
    {
        $x1 = mean($sample1);
        $v1 = variance($sample1);
        $n1 = \count($sample1);

        $x2 = mean($sample2);
        $v2 = variance($sample2);
        $n2 = \count($sample2);

        $df = self::calculateDegreesOfFreedom($v1, $n1, $v2, $n2);

        $t = ($x1 - $x2) / \sqrt(($v1 / $n1) + ($v2 / $n2));
        $tCritical = InverseTTable::getTScore($type, $df, $significance);
        if ($type === self::TWO_TAILED) {
            return \abs($t) > $tCritical;
        } elseif ($type === self::RIGHT_TAILED) {
            return $t > $tCritical;
        } else {
            throw new \InvalidArgumentException();
        }
    }

    private static function calculateDegreesOfFreedom($v1, $n1, $v2, $n2)
    {
        $num = \pow(($v1 / $n1) + ($v2 / $n2), 2);
        $den = (\pow($v1, 2) / (\pow($n1, 2) * ($n1 - 1)))
            / (\pow($v2, 2) / (\pow($n2, 2) * ($n2 - 1)));
        return \floor($num / $den);
    }
}
