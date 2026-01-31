<?php

use Ivanstan\Tle\Model\Tle;
use Ivanstan\Tle\Specification\MediumEarthOrbitTleSpecification;
use PHPUnit\Framework\TestCase;

class MediumEarthOrbitSpecificationTest extends TestCase
{
    public function testSpecificationIsSatisfied(): void
    {
        // GPS satellite NAVSTAR 81 (USA 304) in MEO at ~20,200 km altitude
        $tle = new Tle(
            '1 48859U 21054A   21155.48097222  .00000011  00000-0  00000-0 0  9995',
            '2 48859  55.0498 177.3508 0009877 207.2437 152.7660  2.00564744  1889',
            'GPS BIIR-2 (PRN 13)'
        );

        $specification = new MediumEarthOrbitTleSpecification();
        $this->assertTrue($specification->isSatisfiedBy($tle), 'GPS satellite should satisfy MEO specification');
    }

    public function testSpecificationIsNotSatisfiedForLEO(): void
    {
        // ISS is in LEO
        $tle = new Tle(
            '1 25544U 98067A   21155.52916667  .00002182  00000-0  41420-4 0  9998',
            '2 25544  51.6461 339.8014 0003357  34.4297 125.4396 15.48919393285582',
            'ISS (ZARYA)'
        );

        $specification = new MediumEarthOrbitTleSpecification();
        $this->assertFalse($specification->isSatisfiedBy($tle), 'LEO satellite should not satisfy MEO specification');
    }
}

