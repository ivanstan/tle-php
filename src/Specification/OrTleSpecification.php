<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

/**
 * Composite OR specification.
 * 
 * Combines multiple specifications with OR logic.
 * At least one specification must be satisfied for this specification to be satisfied.
 * 
 * Example: Filter for LEO or MEO satellites
 * $spec = new OrTleSpecification(
 *     new LowEarthOrbitTleSpecification(),
 *     new MediumEarthOrbitTleSpecification()
 * );
 */
class OrTleSpecification implements TleSpecificationInterface
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
            if ($specification->isSatisfiedBy($tle)) {
                return true;
            }
        }
        
        return false;
    }
}

