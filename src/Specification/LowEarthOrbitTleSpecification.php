<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

/**
 * Low Earth Orbit (LEO) specification.
 * LEO is typically defined as orbits with altitude between 160-2,000 km.
 * Used by ISS, Starlink, Iridium, and most Earth observation satellites.
 */
class LowEarthOrbitTleSpecification implements TleSpecificationInterface
{
    private const MIN_ALTITUDE = 160000;   // 160 km in meters
    private const MAX_ALTITUDE = 2000000;  // 2,000 km in meters

    public function isSatisfiedBy(Tle $tle): bool
    {
        $perigee = $tle->perigeeAltitude();
        $apogee = $tle->apogeeAltitude();
        
        return $perigee >= self::MIN_ALTITUDE && $apogee <= self::MAX_ALTITUDE;
    }
}

