<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

/**
 * Composite AND specification.
 * 
 * Combines multiple specifications with AND logic.
 * All specifications must be satisfied for this specification to be satisfied.
 * 
 * Example: Filter for circular LEO satellites
 * $spec = new AndTleSpecification(
 *     new LowEarthOrbitTleSpecification(),
 *     new CircularOrbitTleSpecification()
 * );
 */
class AndTleSpecification implements TleSpecificationInterface
{
    /** @var TleSpecificationInterface[] */
    protected array $specifications;

    public function __construct(TleSpecificationInterface ...$specifications)
    {
        $this->specifications = $specifications;
    }

    public function isSatisfiedBy(Tle $tle): bool
    {
        foreach ($this->specifications as $specification) {
            if (!$specification->isSatisfiedBy($tle)) {
                return false;
            }
        }
        
        return true;
    }
}

