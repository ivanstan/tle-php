<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

/**
 * Low drag specification.
 * 
 * Identifies satellites with low atmospheric drag based on BSTAR coefficient.
 * BSTAR represents the drag coefficient and is related to the ballistic coefficient.
 * 
 * Low BSTAR values indicate:
 * - High altitude satellites (less atmospheric drag)
 * - Dense satellites with low area-to-mass ratio
 * - More stable orbital lifetime
 */
class LowDragTleSpecification implements TleSpecificationInterface
{
    protected float $maxBstar;

    /**
     * @param float $maxBstar Maximum BSTAR coefficient (default 0.0001)
     *                        Typical values: 1e-5 to 1e-3 for LEO satellites
     */
    public function __construct(float $maxBstar = 0.0001)
    {
        $this->maxBstar = $maxBstar;
    }

    public function isSatisfiedBy(Tle $tle): bool
    {
        return abs($tle->bstarFloat()) <= $this->maxBstar;
    }
}

