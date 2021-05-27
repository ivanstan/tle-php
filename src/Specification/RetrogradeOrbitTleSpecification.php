<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

class RetrogradeOrbitTleSpecification implements TleSpecificationInterface
{
    public function isSatisfiedBy(Tle $tle): bool
    {
        return $tle->getInclination() > 90;
    }
}
