<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

/**
 * Critical inclination orbit specification.
 * 
 * At critical inclination (~63.4° or ~116.6°), the rate of apsidal precession is zero.
 * This means the argument of perigee remains stable, which is essential for
 * Molniya and Tundra orbits that need to maintain apogee over a specific region.
 * 
 * The critical inclination is given by: cos²(i) = 1/5, so i ≈ 63.43° or 116.57°
 */
class CriticalInclinationOrbitTleSpecification implements TleSpecificationInterface
{
    private const CRITICAL_INCLINATION_PROGRADE = 63.4;    // degrees
    private const CRITICAL_INCLINATION_RETROGRADE = 116.6; // degrees (180 - 63.4)

    protected float $tolerance;

    /**
     * @param float $tolerance Tolerance in degrees for critical inclination matching
     */
    public function __construct(float $tolerance = 1.0)
    {
        $this->tolerance = $tolerance;
    }

    public function isSatisfiedBy(Tle $tle): bool
    {
        $inclination = $tle->getInclination();
        
        $progradeMatch = abs($inclination - self::CRITICAL_INCLINATION_PROGRADE) <= $this->tolerance;
        $retrogradeMatch = abs($inclination - self::CRITICAL_INCLINATION_RETROGRADE) <= $this->tolerance;

        return $progradeMatch || $retrogradeMatch;
    }
}

