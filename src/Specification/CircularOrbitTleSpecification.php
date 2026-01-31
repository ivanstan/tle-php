<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

/**
 * Circular orbit specification.
 * A circular orbit has very low eccentricity (close to 0).
 * Most operational LEO and geostationary satellites have near-circular orbits.
 */
class CircularOrbitTleSpecification implements TleSpecificationInterface
{
    protected float $maxEccentricity;

    /**
     * @param float $maxEccentricity Maximum eccentricity to be considered circular (default 0.05)
     */
    public function __construct(float $maxEccentricity = 0.05)
    {
        $this->maxEccentricity = $maxEccentricity;
    }

    public function isSatisfiedBy(Tle $tle): bool
    {
        return $tle->eccentricity() < $this->maxEccentricity;
    }
}

