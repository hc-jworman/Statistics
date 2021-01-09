<?php

namespace Statistics;

class Statistics
{
    const TYPE_SAMPLE = 'sample';
    const TYPE_POPULATION = 'population';

    /**
     * @param array<int|float> $samples
     * @param int $type
     * @return float|int
     */
    public static function standardDeviation(array $samples, $type = self::TYPE_SAMPLE)
    {
        return \sqrt(self::variance($samples, $type));
    }

    /**
     * @param array<int|float> $samples
     * @param int $type
     * @return float|int
     */
    public static function variance(array $samples, $type = self::TYPE_SAMPLE)
    {
        $mean = self::mean($samples);
        $sumOfSquaredDifferences = \array_reduce(
            $samples,
            function ($carry, $item) use ($mean) {
                return $carry + \pow($item - $mean, 2);
            },
            0
        );
        if ($type === self::TYPE_SAMPLE) {
            return $sumOfSquaredDifferences / (\count($samples) - 1);
        } elseif ($type === self::TYPE_POPULATION) {
            return $sumOfSquaredDifferences / \count($samples);
        } else {
            throw new \InvalidArgumentException('Invalid type given: ' . $type);
        }
    }

    /**
     * @param array<int|float> $samples
     * @return float|int
     */
    public static function mean(array $samples)
    {
        return \array_sum($samples) / \count($samples);
    }
}
