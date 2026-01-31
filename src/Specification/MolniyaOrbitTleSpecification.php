<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

/**
 * Molniya orbit specification.
 * 
 * Molniya orbits are highly elliptical orbits with:
 * - Inclination ~63.4° (critical inclination - no apsidal precession)
 * - Eccentricity ~0.74
 * - Period ~12 hours (mean motion ~2.0 rev/day)
 * 
 * Used by Russian communications satellites for high-latitude coverage.
 */
class MolniyaOrbitTleSpecification implements TleSpecificationInterface
{
    private const CRITICAL_INCLINATION = 63.4;    // degrees
    private const MOLNIYA_ECCENTRICITY = 0.74;
    private const MOLNIYA_MEAN_MOTION = 2.0;      // rev/day (~12 hour period)

    protected float $inclinationTolerance;
    protected float $eccentricityTolerance;
    protected float $meanMotionTolerance;

    public function __construct(
        float $inclinationTolerance = 2.0,
        float $eccentricityTolerance = 0.05,
        float $meanMotionTolerance = 0.1
    ) {
        $this->inclinationTolerance = $inclinationTolerance;
        $this->eccentricityTolerance = $eccentricityTolerance;
        $this->meanMotionTolerance = $meanMotionTolerance;
    }

    public function isSatisfiedBy(Tle $tle): bool
    {
        $inclinationMatch = abs($tle->getInclination() - self::CRITICAL_INCLINATION) <= $this->inclinationTolerance;
        $eccentricityMatch = abs($tle->eccentricity() - self::MOLNIYA_ECCENTRICITY) <= $this->eccentricityTolerance;
        $meanMotionMatch = abs($tle->meanMotion() - self::MOLNIYA_MEAN_MOTION) <= $this->meanMotionTolerance;

        return $inclinationMatch && $eccentricityMatch && $meanMotionMatch;
    }
}

