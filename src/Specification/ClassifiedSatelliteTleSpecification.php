<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

/**
 * Classified satellite specification.
 * 
 * Identifies satellites marked as classified or secret in TLE data.
 * Classification field values:
 * - 'U' = Unclassified
 * - 'C' = Classified
 * - 'S' = Secret
 */
class ClassifiedSatelliteTleSpecification implements TleSpecificationInterface
{
    public function isSatisfiedBy(Tle $tle): bool
    {
        return in_array($tle->getClassification(), ['C', 'S'], true);
    }
}

