<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

interface TleSpecificationInterface
{
    public function isSatisfiedBy(Tle $tle): bool;
}
