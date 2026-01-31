<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Enum\Constant;
use Ivanstan\Tle\Model\Tle;

class SunSynchronousOrbitTleSpecification implements TleSpecificationInterface
{
    /**
     * Sun-synchronous orbits precess at ~0.9856°/day (360°/365.25 days)
     * to maintain constant sun angle throughout the year.
     */
    private const REQUIRED_PRECESSION_RATE = 0.9856; // degrees per day
    
    protected float $tolerance;

    /**
     * @param float $tolerance degrees per day tolerance for precession rate
     */
    public function __construct(float $tolerance = 0.05)
    {
        $this->tolerance = $tolerance;
    }

    public function isSatisfiedBy(Tle $tle): bool
    {
        $precessionPerDay = $this->calculatePrecessionRate($tle);
        
        return abs($precessionPerDay - self::REQUIRED_PRECESSION_RATE) <= $this->tolerance;
    }

    /**
     * Calculate nodal precession rate in degrees per day.
     * 
     * Formula: ΔΩ = -3π * J₂ * (Rₑ/p)² * cos(i) per orbit
     */
    private function calculatePrecessionRate(Tle $tle): float
    {
        $p = $tle->semiLatusRectum() / 1000; // km
        $inclinationRad = deg2rad($tle->getInclination()); // Convert degrees to radians
        
        // Precession per orbit in radians
        $precessionPerOrbit = (-3 * M_PI) 
            * ((Constant::SECOND_ZONAL_COEFFICIENT * (Constant::MEAN_EARTH_RADIUS ** 2)) / ($p ** 2)) 
            * cos($inclinationRad);
        
        // Convert to degrees per day
        $orbitsPerDay = $tle->meanMotion();
        
        return abs(rad2deg($precessionPerOrbit) * $orbitsPerDay);
    }
}

