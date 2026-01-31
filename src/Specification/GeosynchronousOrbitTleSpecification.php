<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

/**
 * Geosynchronous orbit (GSO) specification.
 * 
 * A geosynchronous orbit has an orbital period matching Earth's rotation period
 * (~23h 56m 4s = 1 sidereal day). This means the satellite completes exactly
 * one orbit per sidereal day (~1.0027 revolutions per solar day).
 * 
 * Key characteristics:
 * - Mean motion ≈ 1.0027 rev/day
 * - May have any inclination (traces figure-8 analemma if inclined)
 * - May be circular or elliptical
 * 
 * Note: All geostationary orbits are geosynchronous, but not all geosynchronous
 * orbits are geostationary.
 */
class GeosynchronousOrbitTleSpecification implements TleSpecificationInterface
{
    /**
     * Mean motion for Earth-synchronous orbit (revolutions per solar day)
     * 1 sidereal day = 23h 56m 4s ≈ 0.99727 solar days
     * So mean motion = 1 / 0.99727 ≈ 1.00274 rev/solar day
     */
    private const SYNCHRONOUS_MEAN_MOTION = 1.0027;
    
    protected float $meanMotionTolerance;

    /**
     * @param float $meanMotionTolerance Tolerance for mean motion matching (default 0.0002 rev/day)
     */
    public function __construct(float $meanMotionTolerance = 0.0002)
    {
        $this->meanMotionTolerance = $meanMotionTolerance;
    }

    public function isSatisfiedBy(Tle $tle): bool
    {
        return abs($tle->meanMotion() - self::SYNCHRONOUS_MEAN_MOTION) < $this->meanMotionTolerance;
    }
}

