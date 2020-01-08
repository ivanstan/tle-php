<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

interface SpecificationInterface
{
    public function isSatisfiedBy(Tle $tle): bool;
}