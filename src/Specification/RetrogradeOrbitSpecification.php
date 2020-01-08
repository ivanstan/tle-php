<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

class RetrogradeOrbitSpecification implements SpecificationInterface
{
    public function isSatisfiedBy(Tle $tle): bool
    {
        return $tle->getInclination() > 90;
    }
}