<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

class PolarOrbitSpecification implements SpecificationInterface
{
    protected float $tolerance;

    /**
     * @param float $tolerance degrees of inclination
     */
    public function __construct(float $tolerance = 0.0)
    {
        $this->tolerance = $tolerance;
    }

    public function isSatisfiedBy(Tle $tle): bool
    {
        return abs($tle->getInclination() - 90) <= $this->tolerance;
    }
}