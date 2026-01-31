<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

/**
 * Geostationary orbit (GEO) specification.
 * 
 * A geostationary orbit is a special case of geosynchronous orbit where:
 * - Orbital period matches Earth's rotation (~23h 56m 4s)
 * - Orbit is circular (eccentricity ≈ 0)
 * - Orbit is equatorial (inclination ≈ 0°)
 * - Altitude ≈ 35,786 km
 * 
 * The satellite appears fixed in the sky from the ground, making it ideal
 * for communications, TV broadcasting, and weather satellites.
 * 
 * Note: All geostationary orbits are geosynchronous, but not all geosynchronous
 * orbits are geostationary.
 */
class GeostationaryOrbitTleSpecification implements TleSpecificationInterface
{
    /**
     * Mean motion for Earth-synchronous orbit (revolutions per solar day)
     */
    private const SYNCHRONOUS_MEAN_MOTION = 1.0027;
    
    protected float $meanMotionTolerance;
    protected float $maxInclination;
    protected float $maxEccentricity;

    /**
     * @param float $meanMotionTolerance Tolerance for mean motion matching (default 0.0002 rev/day)
     * @param float $maxInclination Maximum inclination in degrees (default 1.0°)
     * @param float $maxEccentricity Maximum eccentricity (default 0.01)
     */
    public function __construct(
        float $meanMotionTolerance = 0.0002,
        float $maxInclination = 1.0,
        float $maxEccentricity = 0.01
    ) {
        $this->meanMotionTolerance = $meanMotionTolerance;
        $this->maxInclination = $maxInclination;
        $this->maxEccentricity = $maxEccentricity;
    }

    public function isSatisfiedBy(Tle $tle): bool
    {
        // Check for Earth-synchronous period
        $isSynchronous = abs($tle->meanMotion() - self::SYNCHRONOUS_MEAN_MOTION) < $this->meanMotionTolerance;
        
        // Check for equatorial orbit (low inclination)
        $isEquatorial = $tle->getInclination() <= $this->maxInclination;
        
        // Check for circular orbit (low eccentricity)
        $isCircular = $tle->eccentricity() <= $this->maxEccentricity;

        return $isSynchronous && $isEquatorial && $isCircular;
    }
}
