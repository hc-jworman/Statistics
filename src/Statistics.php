<?php

namespace JWorman\Statistics;

use JWorman\Statistics\Exceptions\EmptySampleException;

const SAMPLE = false;
const POPULATION = true;
const TWO_TAILED = false;
const RIGHT_TAILED = true;

/**
 * @param float[]|int[] $samples
 * @return float|int
 */
function mean(array $samples)
{
    if (empty($samples)) {
        throw new EmptySampleException();
    }
    return \array_sum($samples) / \count($samples);
}

/**
 * @param float[]|int[] $samples
 * @param bool $isPopulation
 * @return float|int
 */
function variance(array $samples, $isPopulation = SAMPLE)
{
    if (empty($samples)) {
        throw new EmptySampleException();
    }
    $mean = mean($samples);
    $sumOfSquaredDifferences = \array_reduce(
        $samples,
        function ($carry, $item) use ($mean) {
            return $carry + \pow($item - $mean, 2);
        },
        0
    );
    return $isPopulation
        ? $sumOfSquaredDifferences / \count($samples)
        : $sumOfSquaredDifferences / (\count($samples) - 1);
}

/**
 * @param float[]|int[] $samples
 * @param bool $isPopulation
 * @return float|int
 */
function standardDeviation(array $samples, $isPopulation = SAMPLE)
{
    if (empty($samples)) {
        throw new EmptySampleException();
    }
    return \sqrt(variance($samples, $isPopulation));
}

/**
 * @param array $sample
 * @param false $twoTailedOrRightTailed
 * @param string $significance
 * @param float|int $nullHypothesis
 * @return bool
 */
function oneSampleTTest(array $sample, $twoTailedOrRightTailed = TWO_TAILED, $significance = '2', $nullHypothesis = 0)
{
    $x = mean($sample);
    $s = standardDeviation($sample);
    $n = \count($sample);

    $df = $n - 1;

    $t = ($x - $nullHypothesis) / ($s / \sqrt($n));
    $tCritical = InverseTTable::getTScore($twoTailedOrRightTailed, $df, $significance);
    return $twoTailedOrRightTailed ? $t > $tCritical : \abs($t) > $tCritical;
}

/**
 * @param array $sample1
 * @param array $sample2
 * @param bool $twoTailedOrRightTailed
 * @param string $significance "0.5", "1", ..., "4.5", "5"
 * @param float|int $nullHypothesis
 * @return bool True if statistically significant, false otherwise
 */
function twoSampleTTest(
    array $sample1,
    array $sample2,
    $twoTailedOrRightTailed = TWO_TAILED,
    $significance = '2',
    $nullHypothesis = 0
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
    $tCritical = InverseTTable::getTScore($twoTailedOrRightTailed, $df, $significance);
    return $twoTailedOrRightTailed ? $t > $tCritical : \abs($t) > $tCritical;
}
