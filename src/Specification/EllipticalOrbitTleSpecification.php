<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

/**
 * Elliptical orbit specification.
 * An elliptical orbit has significant eccentricity.
 * Includes Molniya, Tundra, and transfer orbits.
 */
class EllipticalOrbitTleSpecification implements TleSpecificationInterface
{
    protected float $minEccentricity;

    /**
     * @param float $minEccentricity Minimum eccentricity to be considered elliptical (default 0.1)
     */
    public function __construct(float $minEccentricity = 0.1)
    {
        $this->minEccentricity = $minEccentricity;
    }

    public function isSatisfiedBy(Tle $tle): bool
    {
        return $tle->eccentricity() >= $this->minEccentricity;
    }
}

