<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

/**
 * Tundra orbit specification.
 * 
 * Tundra orbits are highly elliptical geosynchronous orbits with:
 * - Inclination ~63.4° (critical inclination - no apsidal precession)
 * - Eccentricity ~0.27
 * - Period ~24 hours (mean motion ~1.0 rev/day)
 * 
 * Used by Sirius XM radio satellites for North American coverage.
 */
class TundraOrbitTleSpecification implements TleSpecificationInterface
{
    private const CRITICAL_INCLINATION = 63.4;    // degrees
    private const TUNDRA_ECCENTRICITY = 0.27;
    private const TUNDRA_MEAN_MOTION = 1.0;       // rev/day (~24 hour period)

    protected float $inclinationTolerance;
    protected float $eccentricityTolerance;
    protected float $meanMotionTolerance;

    public function __construct(
        float $inclinationTolerance = 2.0,
        float $eccentricityTolerance = 0.05,
        float $meanMotionTolerance = 0.05
    ) {
        $this->inclinationTolerance = $inclinationTolerance;
        $this->eccentricityTolerance = $eccentricityTolerance;
        $this->meanMotionTolerance = $meanMotionTolerance;
    }

    public function isSatisfiedBy(Tle $tle): bool
    {
        $inclinationMatch = abs($tle->getInclination() - self::CRITICAL_INCLINATION) <= $this->inclinationTolerance;
        $eccentricityMatch = abs($tle->eccentricity() - self::TUNDRA_ECCENTRICITY) <= $this->eccentricityTolerance;
        $meanMotionMatch = abs($tle->meanMotion() - self::TUNDRA_MEAN_MOTION) <= $this->meanMotionTolerance;

        return $inclinationMatch && $eccentricityMatch && $meanMotionMatch;
    }
}

