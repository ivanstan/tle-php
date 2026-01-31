<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

/**
 * High Earth Orbit (HEO) specification.
 * HEO includes orbits with apogee above geostationary altitude (35,786 km).
 * Used by deep space missions, lunar transfers, and highly elliptical orbits.
 */
class HighEarthOrbitTleSpecification implements TleSpecificationInterface
{
    private const GEO_ALTITUDE = 35786000;  // 35,786 km in meters

    public function isSatisfiedBy(Tle $tle): bool
    {
        // Apogee must be above geostationary altitude
        return $tle->apogeeAltitude() > self::GEO_ALTITUDE;
    }
}

