<?php

use Ivanstan\Tle\Model\Tle;
use Ivanstan\Tle\Specification\GeosynchronousOrbitTleSpecification;
use PHPUnit\Framework\TestCase;

class GeosynchronousOrbitSpecificationTest extends TestCase
{
    public function testGeostationaryIsSatisfied(): void
    {
        // GOES-16 is geostationary - which is a subset of geosynchronous
        $tle = new Tle(
            '1 41866U 16071A   21155.52066792 -.00000268  00000-0  00000-0 0  9999',
            '2 41866   0.0182 271.3365 0001158 338.3132  95.7577  1.00271127 17212',
            'GOES-16'
        );

        $specification = new GeosynchronousOrbitTleSpecification();
        $this->assertTrue($specification->isSatisfiedBy($tle), 'Geostationary satellite should satisfy geosynchronous specification');
    }

    public function testInclinedGeosynchronousIsSatisfied(): void
    {
        // Quasi-Zenith Satellite (QZS-1) - geosynchronous but inclined
        // It has Earth-synchronous period but traces a figure-8 pattern
        // Using a hypothetical TLE with correct mean motion but high inclination
        $tle = new Tle(
            '1 37158U 10045A   21155.54166667  .00000000  00000-0  00000-0 0  9999',
            '2 37158  43.0000 195.0000 0750000 270.0000  90.0000  1.00270000  3000',
            'QZS-1 (MICHIBIKI)'
        );

        $specification = new GeosynchronousOrbitTleSpecification();
        $this->assertTrue($specification->isSatisfiedBy($tle), 'Inclined geosynchronous satellite should satisfy geosynchronous specification');
    }

    public function testSpecificationIsNotSatisfiedForLeo(): void
    {
        // ISS is in LEO, not geosynchronous
        $tle = new Tle(
            '1 25544U 98067A   21155.52916667  .00002182  00000-0  41420-4 0  9998',
            '2 25544  51.6461 339.8014 0003357  34.4297 125.4396 15.48919393285582',
            'ISS (ZARYA)'
        );

        $specification = new GeosynchronousOrbitTleSpecification();
        $this->assertFalse($specification->isSatisfiedBy($tle), 'LEO satellite should not satisfy geosynchronous specification');
    }

    public function testSpecificationIsNotSatisfiedForMeo(): void
    {
        // GPS satellite in MEO (~12 hour period, not 24 hour)
        $tle = new Tle(
            '1 48859U 21054A   21155.48097222  .00000011  00000-0  00000-0 0  9995',
            '2 48859  55.0498 177.3508 0009877 207.2437 152.7660  2.00564744  1889',
            'GPS BIIR-2 (PRN 13)'
        );

        $specification = new GeosynchronousOrbitTleSpecification();
        $this->assertFalse($specification->isSatisfiedBy($tle), 'MEO/GPS satellite should not satisfy geosynchronous specification');
    }

    public function testSpecificationIsNotSatisfiedForGraveyardOrbit(): void
    {
        // GOES-10 in graveyard orbit (slightly different mean motion)
        $tle = new Tle(
            '1 24786U 97019A   21155.72351740  .00000066  00000-0  00000-0 0  9998',
            '2 24786  10.9975  32.9857 0023848 192.2435 350.7348  0.99121401 87849',
            'GOES-10'
        );

        $specification = new GeosynchronousOrbitTleSpecification();
        $this->assertFalse($specification->isSatisfiedBy($tle), 'Graveyard orbit satellite should not satisfy geosynchronous specification');
    }
}

