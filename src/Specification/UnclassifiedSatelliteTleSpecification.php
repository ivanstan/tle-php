<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

/**
 * Unclassified satellite specification.
 * 
 * Identifies satellites marked as unclassified in TLE data.
 * Most publicly tracked satellites have classification 'U'.
 */
class UnclassifiedSatelliteTleSpecification implements TleSpecificationInterface
{
    public function isSatisfiedBy(Tle $tle): bool
    {
        return $tle->getClassification() === 'U';
    }
}

