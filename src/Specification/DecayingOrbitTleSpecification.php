<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

/**
 * Decaying orbit specification.
 * 
 * Identifies satellites with significant orbital decay based on the
 * first derivative of mean motion (dn/dt).
 * 
 * A positive value indicates the orbit is decaying (satellite speeding up
 * as it falls into lower orbit due to atmospheric drag).
 */
class DecayingOrbitTleSpecification implements TleSpecificationInterface
{
    protected float $minDecayRate;

    /**
     * @param float $minDecayRate Minimum decay rate (first derivative of mean motion in rev/day²)
     *                            Default 0.0001 indicates measurable decay
     */
    public function __construct(float $minDecayRate = 0.0001)
    {
        $this->minDecayRate = $minDecayRate;
    }

    public function isSatisfiedBy(Tle $tle): bool
    {
        // Positive first derivative means orbit is decaying (mean motion increasing)
        return $tle->firstDerivativeMeanMotion() >= $this->minDecayRate;
    }
}

