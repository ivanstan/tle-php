<?php

use Ivanstan\Tle\Model\Tle;
use Ivanstan\Tle\Specification\SunSynchronousOrbitTleSpecification;
use PHPUnit\Framework\TestCase;

class SunSynchronousOrbitSpecificationTest extends TestCase
{
    public function testSpecificationIsSatisfied(): void
    {
        // MIDORI II (ADEOS-II) is a sun-synchronous Earth observation satellite
        $tle = new Tle(
            '1 27597U 02056A   21155.61803229  .00000027  00000-0  28782-4 0  9998',
            '2 27597  98.5638 101.1878 0002039  64.3768 295.7624 14.27502008962051',
            'MIDORI II (ADEOS-II)'
        );

        $specification = new SunSynchronousOrbitTleSpecification();
        $this->assertTrue($specification->isSatisfiedBy($tle), 'MIDORI II should satisfy sun-synchronous orbit specification');
    }

    public function testSpecificationIsNotSatisfied(): void
    {
        // ISS has a low inclination (~51.6°) and is not sun-synchronous
        // It has a much faster mean motion (~15.5 rev/day) and different precession characteristics
        $tle = new Tle(
            '1 25544U 98067A   21155.52916667  .00002182  00000-0  41420-4 0  9998',
            '2 25544  51.6461 339.8014 0003357  34.4297 125.4396 15.48919393285582',
            'ISS (ZARYA)'
        );

        $specification = new SunSynchronousOrbitTleSpecification();
        $this->assertFalse($specification->isSatisfiedBy($tle), 'ISS should not satisfy sun-synchronous orbit specification');
    }
}
