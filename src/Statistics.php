<?php

namespace JWorman\Statistics;

use JWorman\Statistics\Exceptions\EmptySampleException;

const SAMPLE = false;
const POPULATION = true;

/**
 * @param float[]|int[] $sample
 * @return float|int
 */
function mean(array $sample)
{
    if (empty($sample)) {
        throw new EmptySampleException();
    }
    return \array_sum($sample) / \count($sample);
}

/**
 * @param float[]|int[] $sample
 * @param bool $isPopulation
 * @return float|int
 */
function variance(array $sample, $isPopulation = SAMPLE)
{
    if (empty($sample)) {
        throw new EmptySampleException();
    }
    $mean = mean($sample);
    $sumOfSquaredDifferences = \array_reduce(
        $sample,
        function ($carry, $item) use ($mean) {
            return $carry + \pow($item - $mean, 2);
        },
        0
    );
    return $isPopulation
        ? $sumOfSquaredDifferences / \count($sample)
        : $sumOfSquaredDifferences / (\count($sample) - 1);
}

/**
 * @param float[]|int[] $sample
 * @param bool $isPopulation
 * @return float|int
 */
function standardDeviation(array $sample, $isPopulation = SAMPLE)
{
    if (empty($sample)) {
        throw new EmptySampleException();
    }
    return \sqrt(variance($sample, $isPopulation));
}
