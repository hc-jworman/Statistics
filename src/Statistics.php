<?php

namespace JWorman\Statistics;

const SAMPLE = 'sample';
const POPULATION = 'population';

/**
 * @param array<int|float> $samples
 * @return float|int
 */
function mean(array $samples)
{
    return \array_sum($samples) / \count($samples);
}

/**
 * @param array<int|float> $samples
 * @param string $type "sample" or "population"
 * @return float|int
 */
function variance(array $samples, $type = SAMPLE)
{
    $mean = mean($samples);
    $sumOfSquaredDifferences = \array_reduce(
        $samples,
        function ($carry, $item) use ($mean) {
            return $carry + \pow($item - $mean, 2);
        },
        0
    );
    if ($type === SAMPLE) {
        return $sumOfSquaredDifferences / (\count($samples) - 1);
    } elseif ($type === POPULATION) {
        return $sumOfSquaredDifferences / \count($samples);
    } else {
        throw new \InvalidArgumentException('Invalid type given: ' . $type);
    }
}

/**
 * @param array<int|float> $samples
 * @param string $type "sample" or "population"
 * @return float|int
 */
function standardDeviation(array $samples, $type = SAMPLE)
{
    return \sqrt(variance($samples, $type));
}

function twoSampleTTest(array $sample1, array $sample2, $type, $significance)
{
    $x1 = mean($sample1);
    $v1 = variance($sample1);
    $n1 = \count($sample1);

    $x2 = mean($sample2);
    $v2 = variance($sample2);
    $n2 = \count($sample2);

    $t = ($x1 - $x2) / \sqrt(($v1 / $n1) + ($v2 / $n2));
    $tCritical = InverseTTable::getTScore($type, $this->df, $significance);
    return \abs($t) > $tCritical;
}
