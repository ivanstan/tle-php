<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

class GeostationaryOrbitTleSpecification implements TleSpecificationInterface
{
    public function isSatisfiedBy(Tle $tle): bool
    {
        return (abs($tle->meanMotion() - 1.0027) < 0.0002);
    }
}
