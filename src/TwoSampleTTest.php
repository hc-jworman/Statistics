<?php

namespace Statistics;

class TwoSampleTTest
{
    /** @var array */
    private $sample1;
    /** @var int */
    private $n1;
    /** @var float|int */
    private $mean1;
    /** @var float|int */
    private $variance1;

    /** @var array */
    private $sample2;
    /** @var int */
    private $n2;
    /** @var float|int */
    private $mean2;
    /** @var float|int */
    private $variance2;

    /** @var float|int */
    private $df;

    public function __construct(array $sample1, array $sample2)
    {
        $this->sample1 = $sample1;
        $this->n1 = \count($sample1);
        $this->mean1 = Statistics::mean($sample1);
        $this->variance1 = Statistics::variance($sample1);

        $this->sample2 = $sample2;
        $this->n2 = \count($sample2);
        $this->mean2 = Statistics::mean($sample2);
        $this->variance2 = Statistics::variance($sample2);

        $this->calculateDegreesOfFreedom();
    }

    private function calculateDegreesOfFreedom()
    {
        $num = \pow(($this->variance1 / $this->n1) / ($this->variance2 / $this->n2), 2);
        $den = (\pow($this->variance1, 2) / (\pow($this->n1, 2) * ($this->n1 - 1)))
            / (\pow($this->variance2, 2) / (\pow($this->n2, 2) * ($this->n2 - 1)));
        $this->df = \floor($num / $den);
        if ($this->df < 1 || $this->df > 1000) {
            throw new \InvalidArgumentException('');
        }
    }

    public function test($significanceLevel = 0.05)
    {
        $t = ($this->mean1 - $this->mean2) / \sqrt(($this->variance1 / $this->n1) + ($this->variance2 / $this->n2));
        $tCritical = $this->getTCritical($significanceLevel);
        return \abs($t) > $tCritical;
    }

    private function getTCritical($significanceLevel)
    {
        $csv = \array_map('str_getcsv', \file(__DIR__ . '/../InvTTable.csv'));
        $row = $csv[$this->df - 1];
        switch ($significanceLevel) {
            case 0.05:
                return (float)$row[1];
            case 0.01:
                return (float)$row[2];
            case 0.001:
                return (float)$row[3];
            default:
                throw new \InvalidArgumentException('Unsupported significance level: ' . $significanceLevel);
        }
    }
}
