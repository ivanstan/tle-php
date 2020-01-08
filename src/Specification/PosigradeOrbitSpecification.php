<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

class PosigradeOrbitSpecification implements SpecificationInterface
{
    public function isSatisfiedBy(Tle $tle): bool
    {
        return $tle->getInclination() < 90;
    }
}