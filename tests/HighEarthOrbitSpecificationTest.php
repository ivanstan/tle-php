<?php

use Ivanstan\Tle\Model\Tle;
use Ivanstan\Tle\Specification\HighEarthOrbitTleSpecification;
use PHPUnit\Framework\TestCase;

class HighEarthOrbitSpecificationTest extends TestCase
{
    public function testSpecificationIsSatisfied(): void
    {
        // TESS is in a highly elliptical orbit with apogee ~373,000 km
        $tle = new Tle(
            '1 43435U 18038A   21155.76042824 -.00000389  00000-0  00000-0 0  9993',
            '2 43435  28.1373 142.4581 8947273 181.4337 180.8614  0.06516003  1193',
            'TESS'
        );

        $specification = new HighEarthOrbitTleSpecification();
        $this->assertTrue($specification->isSatisfiedBy($tle), 'TESS should satisfy HEO specification');
    }

    public function testSpecificationIsNotSatisfied(): void
    {
        // ISS is in LEO
        $tle = new Tle(
            '1 25544U 98067A   21155.52916667  .00002182  00000-0  41420-4 0  9998',
            '2 25544  51.6461 339.8014 0003357  34.4297 125.4396 15.48919393285582',
            'ISS (ZARYA)'
        );

        $specification = new HighEarthOrbitTleSpecification();
        $this->assertFalse($specification->isSatisfiedBy($tle), 'LEO satellite should not satisfy HEO specification');
    }
}

