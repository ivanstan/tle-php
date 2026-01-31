<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

/**
 * Orbital period specification.
 * 
 * Verifies that the orbital period is within a specified range.
 * Useful for filtering satellites by their orbital characteristics.
 * 
 * Common orbital periods:
 * - LEO: 88-127 minutes
 * - MEO (GPS): ~12 hours (720 minutes)
 * - GEO: ~24 hours (1440 minutes)
 */
class OrbitalPeriodTleSpecification implements TleSpecificationInterface
{
    protected float $minPeriodMinutes;
    protected float $maxPeriodMinutes;

    /**
     * @param float $minPeriodMinutes Minimum orbital period in minutes
     * @param float $maxPeriodMinutes Maximum orbital period in minutes
     */
    public function __construct(float $minPeriodMinutes, float $maxPeriodMinutes)
    {
        $this->minPeriodMinutes = $minPeriodMinutes;
        $this->maxPeriodMinutes = $maxPeriodMinutes;
    }

    public function isSatisfiedBy(Tle $tle): bool
    {
        $periodMinutes = $tle->period() / 60;
        
        return $periodMinutes >= $this->minPeriodMinutes && $periodMinutes <= $this->maxPeriodMinutes;
    }
}

