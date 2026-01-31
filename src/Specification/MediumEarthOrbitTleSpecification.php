<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

/**
 * Medium Earth Orbit (MEO) specification.
 * MEO is typically defined as orbits with altitude between 2,000-35,786 km.
 * Used by GPS, GLONASS, Galileo, and BeiDou navigation satellites.
 */
class MediumEarthOrbitTleSpecification implements TleSpecificationInterface
{
    private const MIN_ALTITUDE = 2000000;   // 2,000 km in meters
    private const MAX_ALTITUDE = 35786000;  // 35,786 km in meters (below GEO)

    public function isSatisfiedBy(Tle $tle): bool
    {
        $perigee = $tle->perigeeAltitude();
        $apogee = $tle->apogeeAltitude();
        
        // Both perigee and apogee must be within MEO range
        return $perigee >= self::MIN_ALTITUDE && $apogee <= self::MAX_ALTITUDE;
    }
}

