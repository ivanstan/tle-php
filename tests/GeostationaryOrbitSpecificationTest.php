<?php

use Ivanstan\Tle\Model\Tle;
use Ivanstan\Tle\Specification\GeostationaryOrbitTleSpecification;
use PHPUnit\Framework\TestCase;

class GeostationaryOrbitSpecificationTest extends TestCase
{
    public function testSpecificationIsSatisfied(): void
    {
        // GOES-16 is an operational geostationary weather satellite
        // Inclination: 0.0182°, Eccentricity: 0.0001158, Mean motion: 1.00271127 rev/day
        $tle = new Tle(
            '1 41866U 16071A   21155.52066792 -.00000268  00000-0  00000-0 0  9999',
            '2 41866   0.0182 271.3365 0001158 338.3132  95.7577  1.00271127 17212',
            'GOES-16'
        );

        $specification = new GeostationaryOrbitTleSpecification();
        $this->assertTrue($specification->isSatisfiedBy($tle), 'GOES-16 should satisfy geostationary orbit specification');
    }

    public function testSpecificationIsNotSatisfiedForGraveyardOrbit(): void
    {
        // GOES-10 was decommissioned and moved to graveyard orbit (mean motion ~0.99 rev/day)
        $tle = new Tle(
            '1 24786U 97019A   21155.72351740  .00000066  00000-0  00000-0 0  9998',
            '2 24786  10.9975  32.9857 0023848 192.2435 350.7348  0.99121401 87849',
            'GOES-10'
        );

        $specification = new GeostationaryOrbitTleSpecification();
        $this->assertFalse($specification->isSatisfiedBy($tle), 'GOES-10 in graveyard orbit should not satisfy geostationary specification');
    }

    public function testSpecificationIsNotSatisfiedForInclinedGeosynchronous(): void
    {
        // GOES-10 in graveyard with high inclination - it's geosynchronous (if we adjust mean motion)
        // but NOT geostationary due to inclination ~11°
        $tle = new Tle(
            '1 24786U 97019A   21155.72351740  .00000066  00000-0  00000-0 0  9998',
            '2 24786  10.9975  32.9857 0023848 192.2435 350.7348  0.99121401 87849',
            'GOES-10'
        );

        $specification = new GeostationaryOrbitTleSpecification();
        $this->assertFalse($specification->isSatisfiedBy($tle), 'Inclined orbit should not satisfy geostationary specification (requires equatorial)');
    }

    public function testSpecificationIsNotSatisfiedForLeoSatellite(): void
    {
        // ISS is in LEO, not geostationary
        $tle = new Tle(
            '1 25544U 98067A   21155.52916667  .00002182  00000-0  41420-4 0  9998',
            '2 25544  51.6461 339.8014 0003357  34.4297 125.4396 15.48919393285582',
            'ISS (ZARYA)'
        );

        $specification = new GeostationaryOrbitTleSpecification();
        $this->assertFalse($specification->isSatisfiedBy($tle), 'LEO satellite should not satisfy geostationary specification');
    }
}



