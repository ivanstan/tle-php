<?php

use Ivanstan\Tle\Model\Tle;
use Ivanstan\Tle\Specification\GeostationaryOrbitTleSpecification;
use PHPUnit\Framework\TestCase;

class GeostationaryOrbitSpecificationTest extends TestCase
{
    public function testSpecificationIsSatisfied(): void
    {
        // GOES-16 is an operational geostationary weather satellite with mean motion ~1.0027 rev/day
        $tle = new Tle(
            '1 41866U 16071A   21155.52066792 -.00000268  00000-0  00000-0 0  9999',
            '2 41866   0.0182 271.3365 0001158 338.3132  95.7577  1.00271127 17212',
            'GOES-16'
        );

        $specification = new GeostationaryOrbitTleSpecification();
        $this->assertTrue($specification->isSatisfiedBy($tle), 'GOES-16 should satisfy geostationary orbit specification');
    }

    public function testSpecificationIsNotSatisfiedForNonGeoSatellite(): void
    {
        // GOES-10 was decommissioned and moved to graveyard orbit (mean motion ~0.99 rev/day)
        $tle = new Tle(
            '1 24786U 97019A   21155.72351740  .00000066  00000-0  00000-0 0  9998',
            '2 24786  10.9975  32.9857 0023848 192.2435 350.7348  0.99121401 87849',
            'GOES-10'
        );

        $specification = new GeostationaryOrbitTleSpecification();
        $this->assertFalse($specification->isSatisfiedBy($tle), 'GOES-10 in graveyard orbit should not satisfy geostationary orbit specification');
    }
}



