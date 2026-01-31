<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

/**
 * NOT specification decorator.
 * 
 * Inverts another specification.
 * If the wrapped specification is satisfied, this returns false, and vice versa.
 * 
 * Example: Filter for non-geostationary satellites
 * $spec = new NotTleSpecification(new GeostationaryOrbitTleSpecification());
 */
class NotTleSpecification implements TleSpecificationInterface
{
    protected TleSpecificationInterface $specification;

    public function __construct(TleSpecificationInterface $specification)
    {
        $this->specification = $specification;
    }

    public function isSatisfiedBy(Tle $tle): bool
    {
        return !$this->specification->isSatisfiedBy($tle);
    }
}

