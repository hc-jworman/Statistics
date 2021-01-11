<?php

namespace JWorman\Statistics;

use JWorman\Statistics\Exceptions\InvalidTailException;

final class TTest
{
    const TWO_TAIL = 'two_tail';
    const LEFT_TAIL = 'left_tail';
    const RIGHT_TAIL = 'right_tail';

    /**
     * @param float[]|int[] $sample
     * @param float|int $nullHypothesis
     * @param string $tail
     * @param string $significanceThreshold
     * @return bool
     */
    public static function oneSample(
        array $sample,
        $nullHypothesis = 0,
        $tail = self::TWO_TAIL,
        $significanceThreshold = '2'
    ) {
        $x = mean($sample);
        $s = standardDeviation($sample);
        $n = \count($sample);
        $df = $n - 1;

        $t = ($x - $nullHypothesis) / ($s / \sqrt($n));

        return self::isStatisticallySignificant($tail, $t, $df, $significanceThreshold);
    }

    private static function isStatisticallySignificant($tail, $t, $df, $sigma)
    {
        $tCritical = InverseTTable::getTCritical($tail, $df, $sigma);
        if ($tail === self::TWO_TAIL) {
            return \abs($t) > $tCritical;
        } elseif ($tail === self::LEFT_TAIL) {
            return $t < $tCritical;
        } elseif ($tail === self::RIGHT_TAIL) {
            return $t > $tCritical;
        } else {
            throw new InvalidTailException($tail);
        }
    }

    /**
     * @param array $sample1
     * @param array $sample2
     * @param string $tail
     * @param string $significanceThreshold
     * @param float|int $nullHypothesis
     * @return bool
     */
    public static function twoSample(
        array $sample1,
        array $sample2,
        $nullHypothesis = 0,
        $tail = self::TWO_TAIL,
        $significanceThreshold = '2'
    ) {
        $x1 = mean($sample1);
        $v1 = variance($sample1);
        $n1 = \count($sample1);

        $x2 = mean($sample2);
        $v2 = variance($sample2);
        $n2 = \count($sample2);

        $num = \pow(($v1 / $n1) + ($v2 / $n2), 2);
        $den = (\pow($v1 / $n1, 2) / ($n1 - 1)) + (\pow($v2 / $n2, 2) / ($n2 - 1));
        $df = \floor($num / $den);

        $t = ($x1 - $x2 - $nullHypothesis) / \sqrt(($v1 / $n1) + ($v2 / $n2));

        return self::isStatisticallySignificant($tail, $t, $df, $significanceThreshold);
    }
}
